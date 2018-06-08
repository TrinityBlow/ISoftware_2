@extends('layouts.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">{{ __('Cambiar contraseña') }}</div>

            <div class="card-body">
                <form method="POST" action="/mi_usuario/cambiarPassword">
                    @csrf

                    <div class="text-center">

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                        <div class="col-md-6">
                            <input id="password_confirmation" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" value="{{ old('password_confirmation') }}" required>

                            @if ($errors->has('password_confirmation'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-10 text-md-right">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Cambiar contraseña') }}
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
@endsection
