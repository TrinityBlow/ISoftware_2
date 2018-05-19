@extends('layouts.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Agregar vehículo') }}</div>

            <div class="card-body">
                <form method="POST" action="/vehiculo/agregarVehiculo">
                    @csrf

                    <div class="form-group row">
                        <label for="patente" class="col-md-4 col-form-label text-md-right">{{ __('Patente') }}</label>

                        <div class="col-md-6">
                            <input id="patente" type="text" class="form-control{{ $errors->has('patente') ? ' is-invalid' : '' }}" name="patente" value="{{ old('patente') }}" required autofocus>

                            @if ($errors->has('patente'))
                                <span class="invalid-feedback">
                                    <strong> {{ $errors->first('patente') }} </strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="marca" class="col-md-4 col-form-label text-md-right">{{ __('Marca') }}</label>

                        <div class="col-md-6">
                            <input id="marca" type="text" class="form-control{{ $errors->has('marca') ? ' is-invalid' : '' }}" name="marca" value="{{ old('marca') }}" required autofocus>

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
                            <input id="modelo" type="text" class="form-control{{ $errors->has('modelo') ? ' is-invalid' : '' }}" name="modelo" value="{{ old('modelo') }}" required>

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
                            <input id="cantidad_asientos" type="number" min="1" class="form-control{{ $errors->has('cantidad_asientos') ? ' is-invalid' : '' }}" name="cantidad_asientos" value="{{ old('cantidad_asientos') }}" required>

                            @if ($errors->has('cantidad_asientos'))
                                <span class="invalid-feedback">
                                    <strong> Cantidad de asientos inválido </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Agregar') }}
                            </button>      
                            <a href="/mi_usuario">                      
                                <button type="button" class="btn btn-primary">
                                    {{ __('Cancelar') }}
                                </button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
