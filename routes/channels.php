<?php

use App\Models\Order;
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

//Aca se transmite las ordenes cuando se crea o se actualiza
Broadcast::channel('orders', function (User $user) {
    /* Logica para determinar si el usuario esta autorizado a escuchar el canal,
    no tiene nada que ver con los usuario que emiten el evento ya que esa
    validacion se haria en el controller donde se emite tal evento. */
    return $user->admin;
});
