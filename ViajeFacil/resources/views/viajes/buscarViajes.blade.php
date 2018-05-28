@extends('layouts.layout')
@section('content')
              <div class="card mt-1">
                <div class="card-header">{{ __('Filtrar viajes por:') }}</div>
                <form method="GET" action="/viajes/buscarViajes" class="form-horizontal" role="form">


                  <div class="form-group row mt-2">
                        <label for="origen" class="col-md-12 col-form-label text-md-center">{{ __('Origen') }}</label>
                  </div>
                    <div class="col-sm-12">
                      <input name="ori" type="text" class="form-control" placeholder="Ej.: 'La Plata'">
                    </div>
                  <div class="form-group row mt-2">
                        <label for="destino" class="col-md-12 col-form-label text-md-center">{{ __('Destino') }}</label>
                  </div>
                    <div class="col-sm-12">
                      <input name="dest" type="text" class="form-control" placeholder="Ej.: 'Brasil'">
                    </div>
                    <div class="form-group row mt-2">
                      <label for="fecha1" class="col-md-12 col-form-label text-md-center">Desde la fecha:</label>
                    </div>
                    <div class="col-sm-12">
                      <input type="date" class="form-control" name="fecha1">
                    </div>
                    <div class="form-group row mt-2">
                      <label for="fecha2" class="col-md-12 col-form-label text-md-center">Hasta la fecha:</label>
                    </div>
                    <div class="col-sm-12">
                      <input type="date" class="form-control" name="fecha2">
                    </div>
                  <div class="form-group row mt-2">
                        <label for="destino" class="col-md-12 col-form-label text-md-center">{{ __('Precio límite:') }}</label>
                  </div>
                    <div class="col-sm-12">
                      <input name="precio" type="number" class="form-control" placeholder="Ej.: 500">
                    </div>
                  <div class="form-group mt-2 ml-7">
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-default">{{ __('Buscar') }}</button>
                    </div>
                  </div>
                </form>
              </div>
@foreach ($viajes as $viaje)
	<div class="card w-75 mt-2">
	  <div class="card-body">
	  		<h5 class="card-title">{{ $viaje -> origen }} hacia {{ $viaje -> destino }}</h5>
	    <a href="/viajes/verDetallesGrupo/{{ $viaje -> id_grupo }}" class="btn btn-primary">Ver detalles</a>
	  </div>
	</div>
@endforeach
@endsection