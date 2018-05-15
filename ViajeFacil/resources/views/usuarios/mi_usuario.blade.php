@extends('layouts.layout')

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
                <div class="card-body">
                    <form method="GET" action="/mi_usuario/agregar_vehiculo">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Agregar Vehiculo') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
