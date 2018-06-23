@extends('layouts.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Modificar vehículo') }}</div>

                <div class="card-body">
                    <form method="POST" action="/vehiculos/modificarVehiculo">
                        @csrf

                        <input type="hidden" name="id_vehiculo" value={{$mi_vehiculo->id_vehiculo}}>

                        <div class="text-center">
                        
                        <div class="form-group row">
                            <label for="patente" class="col-md-4 col-form-label text-md-right">{{ __('Patente') }}</label>

                            <div class="col-md-6">
                                <input id="patente" type="text" class="form-control{{ $errors->has('patente') ? ' is-invalid' : '' }}" name="patente" value="{{ $mi_vehiculo->patente }}" required autofocus>

                                @if ($errors->has('patente'))
                                    <span class="invalid-feedback">
                                        <strong> Patente inválida </strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="marca" class="col-md-4 col-form-label text-md-right">{{ __('Marca') }}</label>

                            <div class="col-md-6">
                                <input id="marca" type="text" class="form-control{{ $errors->has('marca') ? ' is-invalid' : '' }}" name="marca" value="{{ $mi_vehiculo->marca }}" required autofocus>

                                @if ($errors->has('marca'))
                                    <span class="invalid-feedback">
                                        <strong> Marca inválida </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="modelo" class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }}</label>

                            <div class="col-md-6">
                                <input id="modelo" type="text" class="form-control{{ $errors->has('modelo') ? ' is-invalid' : '' }}" name="modelo" value="{{ $mi_vehiculo->modelo }}" required>

                                @if ($errors->has('modelo'))
                                    <span class="invalid-feedback">
                                        <strong> Modelo inválido </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cantidad_asientos" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de asientos') }}</label>

                            <div class="col-md-6">
                                <input id="cantidad_asientos" type="number" min="1" max="50" class="form-control{{ $errors->has('cantidad_asientos') ? ' is-invalid' : '' }}" name="cantidad_asientos" value="{{ $mi_vehiculo->cantidad_asientos }}" required autofocus>

                                @if ($errors->has('cantidad_asientos'))
                                    <span class="invalid-feedback">
                                        <strong> Cantidad de asientos inválida </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Modificar') }}
                                </button>
                                <a href="/mi_usuario">                      
                                    <button type="button" class="btn btn-secondary">
                                        {{ __('Cancelar') }}
                                    </button>
                                </a>
                            </div>
                        </div>

                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
