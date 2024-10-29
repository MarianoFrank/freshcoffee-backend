<?php

namespace App\Services\Auth;

use DB;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/*
*NOTA: Las implementaciondes de "logout_all" y lista negra de token
no tiene sentido para el uso de JWT ya que se termina accediendo
la misma cantidad de veces a la BD que si se implementa sesiones
*/

class JwtGuard implements Guard
{
    protected $user;
    protected $provider;
    protected $request;

    protected $rememberMe;

    // Clave secreta para decodificar el JWT
    protected string $secretKey;
    protected string $secretRefreshKey;
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
        $this->secretKey = env('JWT_SECRET', ''); // Leer la clave desde el archivo .env
        $this->secretRefreshKey = env('JWT_REFRESH_SECRET', '');
        $this->rememberMe = request()->get('remember_me', false);
    }

    /**
     * Verifica si el usuario está autenticado.
     */
    public function check()
    {
        return !is_null($this->user());
    }

    /**
     * Determina si el usuario es un invitado (no autenticado).
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Retorna el usuario autenticado.
     * Este metodo se ejecuta en cada peticion para obtener el usuario autenticado
     * por lo que aca debe estar toda la logica de validacion del token (expiracion, logout_all, etc)
     */
    public function user()
    {

        if (!is_null($this->user)) {
            return $this->user;
        }

        // Extraer el token del header Authorization
        $token = $this->request->bearerToken();

        if (!$token) {

            return [
                "error" => "No token"
            ];
        }

        try {
            // Decodificar el JWT
            //el metodo decode ya valida la expiracion
            $credentials = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            // Obtener el usuario usando el UserProvider
            $this->user = $this->provider->retrieveById($credentials->sub);
        } catch (ExpiredException $e) {
            return [
                "error" => "Expired token"
            ];
        } catch (\Exception $e) {
            return [
                "error" => "Invalid token"
            ];
        }


        if ($this->user && $this->isTokenRevoked($token, auth()->id())) {
            $this->user = null;
            return [
                "error" => "Revoked token"
            ];
        }

        //comprobamos si cerro sesion en todas sus sesiones actualmente
        //logoutall timestamp del token actual
        $credentialsTimeLogoutAll = Carbon::createFromTimestamp($credentials->logout_all ?? 0);
        $userTimeLogoutAll = Carbon::createFromTimestamp($this->user->logout_all ?? 0);

        if ($credentialsTimeLogoutAll < $userTimeLogoutAll) {
            $this->user = null;
            return [
                "error" => "Invalid token (logoutall)"
            ];
        }

        return $this->user;
    }

    public function isTokenRevoked($token, $user_id)
    {
        if (!is_null($this->user)) {
            // Verifica si el token está revocado para el usuario
            $revokedToken = DB::table('revoked_tokens')
                ->where('user_id', $user_id)
                ->where('token', $token)
                ->first();

            return !is_null($revokedToken); // Retorna verdadero si el token está revocado
        }

        return null;
    }

    /**
     * Obtiene el ID del usuario autenticado.
     */
    public function id()
    {
        $user = $this->user();

        return $user ? $user->getAuthIdentifier() : null;
    }

    /**
     * Valida las credenciales de un usuario.
     * Retorna token de acceso y refresco
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials['email']) || empty($credentials['password'])) {
            return false;
        }

        $user = $this->provider->retrieveByCredentials($credentials);
        if (!$user) {
            return false;
        }

        // Verificar la contraseña
        if ($this->provider->validateCredentials($user, $credentials)) {

            // Preparar los datos para el payload del token
            $payloadAccesToken = [
                'iss' => env(" APP_URL"), // Emisor del token
                'sub' => $user->id,        // ID del usuario
                'email' => $user->email,   // Email del usuario
                'iat' => time(),           // Hora en que fue emitido
                'exp' => time() + 3600,     // Expira en 1 hora (puedes ajustar esto según tus necesidades)
                'logout_all' => $user->logout_all
            ];

            // Generar el token
            $token = JWT::encode($payloadAccesToken, $this->secretKey, 'HS256');

            if ($this->rememberMe) {
                $payloadRefreshToken = [
                    'iss' => env(" APP_URL"),
                    'sub' => $user->id,
                    'email' => $user->email,
                    'iat' => time(),
                    'exp' => time() + 259200, //3 dias de expiracion     
                    'logout_all' => $user->logout_all
                ];

                $refreshToken = JWT::encode($payloadRefreshToken, $this->secretRefreshKey, 'HS256');
            }


            // Retornar el token y opcionalmente el refresh_token
            return [
                "acces_token" => $token,
                "refresh_token" => $refreshToken ?? null
            ];
        }
        return null;
    }

    /**
     * Establece manualmente el usuario autenticado.
     */
    public function setUser(\Illuminate\Contracts\Auth\Authenticatable $user)
    {
        $this->user = $user;
    }
    public function hasUser()
    {
        return !is_null($this->user);
    }

    /**
     * Agrega el token de acceso y de refresco a la lista negra
     */
    public function logout()
    {
        $message = [];
        // Obtén el token del encabezado de la solicitud
        $token = $this->request->bearerToken();


        $userId = auth()->id(); //usuario actualmente autenticado

        if ($this->isTokenRevoked($token, $userId)) {
            $message[] = 'El token ya ha sido revocado.';
        }
        // Decodificar el token para obtener su payload
        try {
            $credentials = JWT::decode($token, new Key($this->secretKey, 'HS256'));
        } catch (\Exception $e) {
            $message[] = 'Token invalido';
        }

        if ($userId === $credentials->sub) {
            $this->revokeToken($token, $credentials, $userId);

            $message[] = 'Token revocado exitosamente.';
        }

        //misma logica para el refresh token
        $refreshToken = $this->request->get("Refresh") ?? null;
        if (is_null($refreshToken)) {
            return $message;
        }

        if ($this->isTokenRevoked($refreshToken, $userId)) {
            $message[] = 'El refreshToken ya ha sido revocado.';
        }

        try {
            $credentialsRefreshToken = JWT::decode($refreshToken, new Key($this->secretRefreshKey, 'HS256'));
        } catch (\Exception $e) {
            $message[] = 'RefreshToken invalido';
        }
        if ($userId === $credentialsRefreshToken->sub) {
            $this->revokeToken($refreshToken, $credentials, $userId);

            $message[] = 'RefreshToken revocado exitosamente.';
        }

        return $message;

        /*
        * NOTA: Se podria hacer un demonio cada 24 horas que limpie los token revocados
        expirados en la base de datos ya que estamos guardando la expiracion.
        Otra manera seria..., en este mismo metodo logout al momento de agregar
        un token revocado, limpiar los token expirados revocados de este usuario.

            protected function cleanExpiredRevokedTokens($userId) {
                DB::table('revoked_tokens')
                    ->where('user_id', $userId)
                    ->where('expire', '<', now())
                    ->delete();
            }
        */
    }

    public function revokeToken($token, $credentials, $userId)
    {
        // Obtener la fecha de expiración del payload
        $expireTimestamp = $credentials->exp;
        $expire = Carbon::createFromTimestamp($expireTimestamp);
        DB::table('revoked_tokens')->insert([
            'user_id' => $userId,
            'token' => $token,
            'expire' => $expire, // Convierte a formato de fecha
        ]);
    }

    public function refreshToken()
    {
        $refreshToken = $this->request->get('Refresh');

        if (!$refreshToken) {
            return [
                "error" => "No refresh token"
            ];
        }

        try {
            $credentials = JWT::decode($refreshToken, new Key($this->secretRefreshKey, 'HS256'));
        } catch (ExpiredException $e) {
            return [
                "error" => "Expired token"
            ];
        } catch (\Exception $e) {
            return [
                "error" => "Invalid token"
            ];
        }

        if ($this->isTokenRevoked($refreshToken, $credentials->sub)) {
            return [
                "error" => "Revoked token"
            ];
        }

        $credentialsTimeLogoutAll = Carbon::createFromTimestamp($credentials->logout_all ?? 0);
        $userTimeLogoutAll = Carbon::createFromTimestamp($this->user->logout_all ?? 0);

        if ($credentialsTimeLogoutAll < $userTimeLogoutAll) {
            $this->user = null;
            return [
                "error" => "Invalid token (logoutall)"
            ];
        }

        //Si llego hasta aca el refresh token es valido

        //Buscamos al usuario en la base de datos
        $user = DB::table("users")->find($credentials->sub);
        if (!$user) {
            return ["error" => "No user"];
        }

        $newPayload = [
            'iss' => env(" APP_URL"), // Emisor del token
            'sub' => $user->id,        // ID del usuario
            'email' => $user->email,   // Email del usuario
            'iat' => time(),           // Hora en que fue emitido
            'exp' => time() + 3600,     // Expira en 1 hora (puedes ajustar esto según tus necesidades)
            'logout_all' => $user->logout_all
        ];

        $newToken = JWT::encode($newPayload, $this->secretKey, 'HS256');

        return ["acces_token" => $newToken];

    }

}
