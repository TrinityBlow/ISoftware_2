@extends('layouts.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Modificar viaje') }}</div>

            <div class="card-body">
                <form method="POST" action="/viajes/modificarViaje">

                    @csrf                     
                    <div class="form-group row">
                        <input type="hidden" name="id_grupo" value="{{ $viaje->id_grupo }}" >
                        <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Título:') }}</label>

                        <div class="col-md-6">
                            <input id="origen" type="text" class="form-control" name="titulo" value="{{ $viaje->titulo }}" required autofocus>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <input type="hidden" name="id_grupo" value="{{ $viaje->id_grupo }}" >
                        <label for="origen" class="col-md-4 col-form-label text-md-right">{{ __('Origen:') }}</label>

                        <div class="col-md-6">
                            <input id="origen" type="text" class="form-control" name="origen" value="{{ $viaje->origen }}" required autofocus>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="destino" class="col-md-4 col-form-label text-md-right">{{ __('Destino:') }}</label>

                        <div class="col-md-6">
                            <input id="destino" type="text" class="form-control" name="destino" value="{{ $viaje->destino }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">Fecha:</label>
                        <div class="col-md-6">
                            <input required type="date" class="form-control" name="fecha" value={{ $viaje->fecha }}>
                        </div>
                    </div>
                    <div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right">Hora:</label>
                        <div class="col-md-6">
                            <input required type="time" class="form-control" name="hora" value={{ $hora}}>
                        </div>    
                    </div>  

                    <div class="form-group row">
                        <label for="precio" class="col-md-4 col-form-label text-md-right">{{ __('Precio:') }}</label>

                        <div class="col-md-6">
                            <input id="precio" type="text" class="form-control" name="precio" value="{{ $viaje->precio }}" required autofocus>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="id_vehiculo" class="control-label">Vehículo que se usará para viajar:</label>
                        <select class="form-control" name="id_vehiculo">
                        @foreach ($vehiculos as $vehiculo)
                            <option value={{$vehiculo->id_vehiculo}}>Patente: {{$vehiculo->patente}} | Marca: {{$vehiculo->marca}} | Modelo: {{$vehiculo->modelo}} | Cantidad de asientos: {{$vehiculo->cantidad_asientos}}</option>
                        @endforeach 
                        </select>                   
                    </div>              
                    <div class="form-group">
                        <label for="tipo_viaje" class="control-label">Tipo de viaje:</label>
                        <select name="tipo_viaje" class="form-control">
                            <option value="ocasional">Ocasional</option>
                            <option value="periodico">Periódico</option>
                            <option value="diario">Diario</option>          
                        </select>                   
                    </div>   
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Modificar') }}
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
