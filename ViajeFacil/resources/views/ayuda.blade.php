@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Ayuda</div>

        <div class="card-body" id="accordion">

            <p>Aquí encontrará las respuestas a preguntas frecuentes. Si su pregunta no se encuentra entre las siguientes, vaya a la sección de contacto haciendo click <a href="{{ route('contacto') }}">aquí</a>.</p>

            @guest
            <div class="card mt-2">
                <div class="card-header" id="heading01">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse01" aria-expanded="false" aria-controls="collapse01">
                            ¿Cómo me registro?
                        </button>
                    </h5>
                </div>
                <div id="collapse01" class="collapse" aria-labelledby="heading01" data-parent="#accordion">
                    <div class="card-body">
                        Haga click en <em>“Registrarse”</em>, ubicado en la parte superior derecha. Complete los datos requeridos. Para finalizar, haga click en <em>“Registrarme”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading02">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse02" aria-expanded="false" aria-controls="collapse02">
                            ¿Olvidé mi contraseña?
                        </button>
                    </h5>
                </div>
                <div id="collapse02" class="collapse" aria-labelledby="heading02" data-parent="#accordion">
                    <div class="card-body">
                        Para reiniciarla, vaya a iniciar sesión y haga click en <em>“¿Olvidaste tu contraseña?”</em>. Complete los datos requeridos y haga click en <em>”Reiniciar contraseña”</em>.
                    </div>
                </div>
            </div>
            @endguest

            <div class="card mt-2">
                <div class="card-header" id="heading03">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse03" aria-expanded="false" aria-controls="collapse03">
                            ¿Cómo cambio mis datos?
                        </button>
                    </h5>
                </div>
                <div id="collapse03" class="collapse" aria-labelledby="heading03" data-parent="#accordion">
                    <div class="card-body">
                        Haga click sobre <em>“Su nombre”</em> y luego sobre <em>“Mi usuario”</em>, ubicado en la parte superior derecha. Cambie los datos que desea modificar. Para guardarlos, haga click en <em>“Modificar”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading04">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse04" aria-expanded="false" aria-controls="collapse04">
                            ¿Cómo cambio mi contraseña?
                        </button>
                    </h5>
                </div>
                <div id="collapse04" class="collapse" aria-labelledby="heading04" data-parent="#accordion">
                    <div class="card-body">
                        Haga click sobre <em>“Su nombre”</em> y luego sobre <em>“Mi usuario”</em>, ubicado en la parte superior derecha. Haga click en <em>“Cambiar contraseña”</em>. Ingrese su nueva contraseña y confírmela. Para finalizar, haga click en <em>“Cambiar”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading05">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse05" aria-expanded="false" aria-controls="collapse05">
                            ¿Cómo agrego un vehículo?
                        </button>
                    </h5>
                </div>
                <div id="collapse05" class="collapse" aria-labelledby="heading05" data-parent="#accordion">
                    <div class="card-body">
                        Haga click sobre <em>“Su nombre”</em> y luego sobre <em>“Mi usuario”</em>, ubicado en la parte superior derecha. Haga click en <em>“Agregar vehículo”</em>. Complete los datos requeridos. Para finalizar, haga click en <em>“Agregar”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading06">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse06" aria-expanded="false" aria-controls="collapse06">
                            ¿Cómo modifico un vehículo?
                        </button>
                    </h5>
                </div>
                <div id="collapse06" class="collapse" aria-labelledby="heading06" data-parent="#accordion">
                    <div class="card-body">
                        Haga click sobre <em>“Su nombre”</em> y luego sobre <em>“Mi usuario”</em>, ubicado en la parte superior derecha. En la parte inferior encontrará la lista de sus vehículos. Haga click en <em>“Modificar”</em>. Cambie los datos que desea modificar. Para finalizar, haga click en <em>“Modificar”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading07">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse07" aria-expanded="false" aria-controls="collapse07">
                            ¿Cómo elimino un vehículo?
                        </button>
                    </h5>
                </div>
                <div id="collapse07" class="collapse" aria-labelledby="heading07" data-parent="#accordion">
                    <div class="card-body">
                        Haga click sobre <em>“Su nombre”</em> y luego sobre <em>“Mi usuario”</em>, ubicado en la parte superior derecha. En la parte inferior encontrará la lista de sus vehículos. Haga click en <em>“Eliminar”</em> y confirme que desea hacerlo. ATENCIÓN: Si elimina un vehículo, no podrá volver a agregar otro con la misma patente.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading08">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse08" aria-expanded="false" aria-controls="collapse08">
                            ¿Cómo me doy de baja?
                        </button>
                    </h5>
                </div>
                <div id="collapse08" class="collapse" aria-labelledby="heading08" data-parent="#accordion">
                    <div class="card-body">
                        Haga click sobre <em>“Su nombre”</em> y luego sobre <em>“Mi usuario”</em>, ubicado en la parte superior derecha. En la parte inferior, haga click en <em>“Darme de baja definitivamente”</em> y confirme que desea hacerlo. ATENCIÓN: Se PERDERÁN todos sus datos de viajes, vehículos y reputación definitivamente.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading09">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse09" aria-expanded="false" aria-controls="collapse09">
                            ¿Cómo busco un viaje?
                        </button>
                    </h5>
                </div>
                <div id="collapse09" class="collapse" aria-labelledby="heading09" data-parent="#accordion">
                    <div class="card-body">
                        Haga click en <em>“Buscar viaje”</em>, ubicado en la parte izquierda. Allí podrá ver todos los viajes disponibles o filtrarlos por origen, destino, fecha y/o precio.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading10">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                            ¿Cómo me postulo a un viaje?
                        </button>
                    </h5>
                </div>
                <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
                    <div class="card-body">
                        Una vez sobre el viaje seleccionado, haga click en <em>“Ver detalles”</em>. Seleccione la fecha que desea viajar (en caso de que sea periódico o diario) y luego haga click en <em>“Postularme para viajar”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading11">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                            ¿Cómo cancelo una postulación?
                        </button>
                    </h5>
                </div>
                <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                    <div class="card-body">
                        Haga click en <em>“Mis postulaciones”</em>, ubicado en la parte izquierda. Allí encontrará la lista de sus postulaciones. Una vez sobre el viaje que desea cancelar la postulación, haga click en <em>“Ver detalles del viaje”</em>. Luego haga click en <em>“Cancelar postulación”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading12">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                            ¿Cómo rechazo una postulación aceptada?
                        </button>
                    </h5>
                </div>
                <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                    <div class="card-body">
                        Haga click en <em>“Mis postulaciones”</em>, ubicado en la parte izquierda. Allí encontrará la lista de sus postulaciones. Una vez sobre el viaje que desea rechazar la postulación, haga click en <em>“Ver detalles del viaje”</em>. Luego haga click en <em>“Rechazar viaje”</em>. ATENCIÓN: Se te restará 1 punto de reputación.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading13">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                            ¿Cómo creo un viaje?
                        </button>
                    </h5>
                </div>
                <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
                    <div class="card-body">
                        Haga click en <em>“Crear viaje”</em>, ubicado en la parte izquierda. Complete los datos requeridos. Para finalizar, haga click en <em>“Publicar viaje”</em>. ATENCIÓN: no podrá publicar un viaje si tiene viajes sin finalizar y/o tiene calificaciones pendientes de hace más de 30 días. NOTA: Se le añadirá un 10% de comisión al precio del viaje.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading14">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse14" aria-expanded="false" aria-controls="collapse14">
                            ¿Cómo veo las postulaciones a uno de mis viajes?
                        </button>
                    </h5>
                </div>
                <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordion">
                    <div class="card-body">
                        Haga click en <em>“Mis viajes”</em>, ubicado en la parte izquierda. Allí encontrará la lista de sus viajes. Una vez sobre el viaje que desea ver las postulaciones, haga click en <em>“Ver detalles de viajes”</em>. Luego, sobre la fecha del viaje seleccionada, haga click en <em>“Ver postulaciones”</em>. NOTA: El sistema le notificará cuando tenga nuevas postulaciones.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading15">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse15" aria-expanded="false" aria-controls="collapse15">
                            ¿Cómo acepto una postulación a uno de mis viajes?
                        </button>
                    </h5>
                </div>
                <div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordion">
                    <div class="card-body">
                        Una vez sobre la postulación que desea aceptar, haga click en <em>“Aceptar”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading16">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
                            ¿Cómo rechazo una postulación a uno de mis viajes?
                        </button>
                    </h5>
                </div>
                <div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordion">
                    <div class="card-body">
                        Una vez sobre la postulación que desea rechazar, haga click en <em>“Rechazar”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading17">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
                            ¿Cómo rechazo una postulación aceptada a uno de mis viajes?
                        </button>
                    </h5>
                </div>
                <div id="collapse17" class="collapse" aria-labelledby="heading17" data-parent="#accordion">
                    <div class="card-body">
                        Una vez sobre la postulación que desea rechazar, haga click en <em>“Rechazar”</em>. ATENCIÓN: Se te restará 1 punto de reputación.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading18">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse18" aria-expanded="false" aria-controls="collapse18">
                            ¿Cómo realizo una pregunta a un viaje?
                        </button>
                    </h5>
                </div>
                <div id="collapse18" class="collapse" aria-labelledby="heading18" data-parent="#accordion">
                    <div class="card-body">
                        Una vez en el viaje seleccionado, encontrará la sección <em>“Realizar pregunta”</em>. Allí escriba su pregunta y haga click en <em>“Publicar pregunta”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading19">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse19" aria-expanded="false" aria-controls="collapse19">
                            ¿Cómo respondo una pregunta a uno de mis viajes?
                        </button>
                    </h5>
                </div>
                <div id="collapse19" class="collapse" aria-labelledby="heading19" data-parent="#accordion">
                    <div class="card-body">
                        Haga click en <em>“Mis viajes”</em>, ubicado en la parte izquierda. Allí encontrará la lista de sus viajes. Una vez sobre el viaje que desea ver las preguntas, haga click en <em>“Ver detalles de viajes”</em>. Luego, sobre la fecha del viaje seleccionada, haga click en <em>“Ver preguntas”</em>. En la parte inferior encontrará las preguntas del viaje. Escriba la respuesta correspondiente y haga click en <em>“Responder”</em>. NOTA: El sistema le notificará cuando tenga nuevas preguntas.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading20">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse20" aria-expanded="false" aria-controls="collapse20">
                            ¿Cómo finalizo un viaje?
                        </button>
                    </h5>
                </div>
                <div id="collapse20" class="collapse" aria-labelledby="heading20" data-parent="#accordion">
                    <div class="card-body">
                        Para finalizar un viaje, deberá pagar la comisión del 10% sobre el precio del viaje. Para esto, haga click en <em>“Mis viajes”</em>, ubicado en la parte izquierda. Allí encontrará la lista de sus viajes. Una vez sobre el viaje que desea ver los que tiene sin finalizar, haga click en <em>“Ver detalles de viajes”</em>. Luego, sobre la fecha del viaje seleccionada, haga click en <em>“Finalizar”</em>. Ingrese los datos de su tarjeta de crédito requeridos y haga click en <em>“Pagar”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading21">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse21" aria-expanded="false" aria-controls="collapse21">
                            ¿Cómo califico un viaje?
                        </button>
                    </h5>
                </div>
                <div id="collapse21" class="collapse" aria-labelledby="heading21" data-parent="#accordion">
                    <div class="card-body">
                        Una vez finalizado un viaje, haga click en <em>“Mis postulaciones”</em>, ubicado en la parte izquierda. Allí encontrará la lista de sus postulaciones. Sobre el viaje finalizado que desea calificar, haga click en <em>“Calificar viaje”</em>. Luego seleccione una calificación y, si desea, realice un comentario. Para finalizar, haga click en <em>“Calificar”</em>.
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header" id="heading22">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" style="color:inherit; text-decoration: none;" data-toggle="collapse" data-target="#collapse22" aria-expanded="false" aria-controls="collapse22">
                            ¿Cómo califico a un viajero?
                        </button>
                    </h5>
                </div>
                <div id="collapse22" class="collapse" aria-labelledby="heading22" data-parent="#accordion">
                    <div class="card-body">
                        Una vez finalizado un viaje, haga click en <em>“Mis viajes”</em>, ubicado en la parte izquierda. Allí encontrará la lista de sus viajes. Una vez sobre el viaje que desea ver las calificaciones pendientes, haga click en <em>“Ver detalles de viajes”</em>. Luego, sobre la fecha del viaje seleccionada, haga click en <em>“Calificar viajeros”</em>. Allí encontrará la lista de viajeros aceptados. Para cada uno de ellos, seleccione una calificación, si desea, realice un comentario y haga click en <em>“Calificar”</em>.
                    </div>
                </div>
            </div>

        </div>
        
    </div>
</div>
@endsection
