<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
    Los canales privados requieren que autorices que el usuario autenticado actualmente
    pueda escuchar en el canal. Esto se logra haciendo una solicitud HTTP a tu aplicación 
    Laravel con el nombre del canal y permitiendo que tu aplicación determine si el 
    usuario puede escuchar en ese canal. Al usar Laravel Echo , la solicitud HTTP para
    autorizar suscripciones a canales privados se realizará automáticamente.
*/

//registra las rutas /broadcasting/auth y utilizo mi guard jwt (TODO deberia crear otro middleware)
Broadcast::routes(['middleware' => ['auth:jwt']]);

Broadcast::channel('orders', function (User $user) {
    /* Logica para determinar si el usuario esta autorizado a escuchar el canal */
    return $user->admin;
});
