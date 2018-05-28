@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card mb-2">
        <div class="card-header">{{ __('Filtrar viajes por:') }}</div>

        <div class="card-body">
            <form method="GET" action="/viajes/buscarViajes" class="form-horizontal" role="form">

                <div class="row">

                    <div class="form-group col">
                        <label for="origen" class="col-form-label">{{ __('Origen:') }}</label>
                        <input name="ori" type="text" class="form-control" placeholder="Ej.: 'La Plata'">
                    </div>

                    <div class="form-group col">
                        <label for="destino" class="col-form-label">{{ __('Destino:') }}</label>
                        <input name="dest" type="text" class="form-control" placeholder="Ej.: 'Capital Federal'">
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col">
                        <label for="fecha1" class="col-form-label">Desde la fecha:</label>
                        <input name="fecha1" type="date" class="form-control">
                    </div>

                    <div class="form-group col">
                        <label for="fecha2" class="col-form-label">Hasta la fecha:</label>
                        <input name="fecha2" type="date" class="form-control">
                    </div>

                    <div class="form-group col">
                        <label for="precio_limite" class="col-form-label">{{ __('Precio límite:') }}</label>
                        <div class="input-group">
            							<div class="input-group-prepend">
            								<span class="input-group-text">$</span>
            							</div>
                          <input name="precio" type="number" class="form-control" placeholder="Ej.: 100">
                        </div>
                    </div>

                </div>

                <div class="form-group text-center mt-3">
                    <button type="submit" class="btn btn-primary">{{ __('Buscar') }}</button>
                </div>

            </form>
        </div>
    </div>
</div>
@foreach ($viajes as $viaje)
<div class="card border-dark mb-3 mt-2">
  <div class="card-header">{{ $viaje -> titulo }}</div>
  <div class="card-body text-dark">
    <h5 class="card-title">Origen: <u>{{ $viaje -> origen }}</u> - Destino: <u>{{ $viaje -> destino }}</u></h5>
    <p class="card-text">Precio: {{ $viaje -> precio }} | Tipo: {{ $viaje -> tipo_viaje }} | Fecha y hora: {{ $viaje -> fecha }}</p>
    <a href="/viajes/verDetallesGrupo/{{ $viaje -> id_grupo }}" class="btn btn-primary">Ver detalles</a>
  </div>
</div>
@endforeach
@endsection