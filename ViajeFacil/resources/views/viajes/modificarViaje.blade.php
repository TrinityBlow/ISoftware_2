@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Modificar viaje') }}</div>

        <div class="card-body">
            <form method="POST" action="/viajes/modificarViaje">
                @csrf

                <input type="hidden" name="id_grupo" value="{{ $viaje->id_grupo }}">

                <div class="form-group">
                    <label for="titulo" class="control-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $viaje->titulo }}" placeholder="(Opcional)">
                </div>

                <div class="row">

                    <div class="form-group col">
                        <label for="origen" class="control-label">Origen:</label>
                        <input type="text" class="form-control" id="origen" name="origen" value="{{ $viaje->origen }}" required>
                    </div>

                    <div class="form-group col">
                        <label for="destino" class="control-label">Destino:</label>
                        <input type="text" class="form-control" id="destino" name="destino" value="{{ $viaje->destino }}" required>
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col">
                        <label for="fecha" class="control-label">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value={{ $viaje->fecha }} required>
                    </div>

                    <div class="form-group col">
                        <label for="hora" class="control-label">Hora:</label>
                        <input type="time" class="form-control" id="hora" name="hora" value={{ $hora }} required>
                    </div>

                </div>

                <div class="row">
                        
                    <div class="form-group col">
                        <label for="precio" class="control-label">Precio:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control" id="precio" name="precio" value="{{ $viaje->precio }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group col">
                        <label for="tipo_viaje" class="control-label">Tipo de viaje:</label>
                        <select name="tipo_viaje" class="form-control">
                            <option value="ocasional">Ocasional</option>
                            <option value="periodico">Periódico</option>
                            <option value="diario">Diario</option>
                        </select>
                    </div>

                </div>

                <div class="form-group">
                    <label for="id_vehiculo" class="control-label">Vehículo utilizado para viajar:</label>
                    <select class="form-control" name="id_vehiculo">
                    @foreach ($vehiculos as $vehiculo)
                        <option value={{$vehiculo->id_vehiculo}}>Patente: {{$vehiculo->patente}} | Marca: {{$vehiculo->marca}} | Modelo: {{$vehiculo->modelo}} | Cantidad de asientos: {{$vehiculo->cantidad_asientos}}</option>
                    @endforeach 
                    </select>                   
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Modificar') }}
                        </button>
                        <a href="/viajes/misViajes">                      
                            <button type="button" class="btn btn-secondary">
                                {{ __('Cancelar') }}
                            </button>
                        </a>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection
