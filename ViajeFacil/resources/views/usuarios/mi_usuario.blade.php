@extends('layouts.layout')
@if (session('mensajeCrearViaje'))
    <div class="alert alert-success">
        {{ session('mensajeCrearViaje') }}
    </div>
@endif
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Mi usuario') }}</div>

            <div class="card-body">
                <form method="POST" action="/mi_usuario/modificar">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Auth::user()->name }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong> Nombre invalido </strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Apellido') }}</label>

                        <div class="col-md-6">
                            <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ Auth::user()->last_name }}" required autofocus>

                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                    <strong> Apellido invalido </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de nacimiento') }}</label>

                        <div class="col-md-6">
                            <input id="birthdate" type="date" class="form-control{{ $errors->has('birthdate') ? ' is-invalid' : '' }}" name="birthdate" value="{{ Auth::user()->birthdate }}" required>

                            @if ($errors->has('birthdate'))
                                <span class="invalid-feedback">
                                    <strong> Fecha de nacimiento inválida.</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Auth::user()->email }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong> E-mail ya existente</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Modificar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">  
            

            <div class="card-header">{{ __('Vehiculos') }}</div>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="card-body">
                            <a href="/mi_usuario/agregarVehiculo">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Agregar vehículo') }}
                                </button>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <b> Mis Vehiculos:</b>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tr>
                                    <th>Patente</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Opciones</th>
                                </tr>
                                @foreach ($mis_vehiculos as $vehiculo)
                                    <tr>
                                        <th> {{ $vehiculo->patente }} </th> 
                                        <th> {{ $vehiculo->marca}} </th>
                                        <th> {{ $vehiculo->modelo}} </th> 
                                        <th>
                                            <a class= 'text-center' href="/vehiculos/modificarVehiculo/{{ $vehiculo->id_vehiculo }}"> <button type="button" class="btn btn-primary">Modificar</button> </a> 
                                            <a class= 'text-center' href="/vehiculos/eliminarVehiculo/{{$vehiculo->id_vehiculo}}"> <button type="button" class="btn btn-danger mt-2">Eliminar</button> </a>      
                                        </th>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
</div>
@endsection
