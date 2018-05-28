@extends('layouts.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        
        @if (session('mensajeCrearViaje'))
        <div class="alert alert-success">
            {{ session('mensajeCrearViaje') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('Mi usuario') }}</div>

            <div class="card-body">
                <form method="POST" action="/mi_usuario/modificar" enctype="multipart/form-data">
                    @csrf

                    <div class="text-center mb-6">

                    <div class="text-center mb-6 form-group">

                        <img class="rounded" src='/storage/images/{{ Auth::user()->image }}' height="50%" width="50%">

                        <input id="image" type="file" class="mt-2{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image">
                        
                        @if ($errors->has('image'))
                        <span class="invalid-feedback">
                            <strong> Imagen inválida </strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Auth::user()->name }}" required>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong> Nombre inválido </strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Apellido') }}</label>

                        <div class="col-md-6">
                            <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ Auth::user()->last_name }}" required>

                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                    <strong> Apellido inválido </strong>
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
                                    <strong> Fecha de nacimiento inválida </strong>
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
                                    <strong> E-mail ya existente </strong>
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
        </div>

        <div class="card mt-2">  

            <div class="card-header">{{ __('Vehículos') }}</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center">
                        <a href="/mi_usuario/agregarVehiculo">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Agregar vehículo') }}
                            </button>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b> Mis vehículos: </b>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                <tr>
                                    <th> Patente </th>
                                    <th> Marca </th>
                                    <th> Modelo </th>
                                    <th> Opciones </th>
                                </tr>
                                @foreach ($mis_vehiculos as $vehiculo)
                                    <tr>
                                        <td> {{ $vehiculo->patente }} </td> 
                                        <td> {{ $vehiculo->marca }} </td>
                                        <td> {{ $vehiculo->modelo }} </td> 
                                        <td>
                                            <a href="/vehiculos/modificarVehiculo/{{ $vehiculo->id_vehiculo }}" class="btn btn-primary"> Modificar </a> 
                                            <button class="btn btn-danger" data-id="{{ $vehiculo->id_vehiculo }}" data-toggle="modal" data-target="#eliminarModal"> Eliminar </button>
                                        </td>
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

<!-- Modal -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Eliminar vehículo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/vehiculos/eliminarVehiculo">
                @csrf
                <div class="modal-body">
                    ¿Estás seguro que quieres eliminarlo?
                    <input type="hidden" id="id_modal" name="id_vehiculo" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Sí, estoy seguro</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
