@extends('layouts.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Información</div>

            <div class="card-body">
                @switch (session('info'))
                    @case ('sinVehiculos')
                        <p>¡No tienes vehículos para poder crear un viaje!</br>Agrega uno y vuelve a intentarlo.</p>
                        <a href="/mi_usuario/agregarVehiculo" class="btn btn-primary">Agregar vehículo</a>
                        @break
                    @case ('sinViajes')
                        <p>¡No tienes viajes creados!</br>Crea uno y vuelve a intentarlo.</p>
                        <a href="/viajes/crearViaje" class="btn btn-primary">Crear viaje</a>
                        @break
                    @case ('sinPostulaciones')
                        <p>¡No tienes postulaciones a ningún viaje!</br>Busca uno, postúlate y vuelve a intentarlo.</p>
                        <a href="/viajes/buscarViajes" class="btn btn-primary">Buscar viaje</a>
                        @break
                    @default
                        <p>¡Has iniciado sesión correctamente!</p>
                @endswitch
            </div>
            
        </div>
    </div>
</div>
@endsection
