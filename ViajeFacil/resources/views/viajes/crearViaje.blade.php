@extends('layouts.layout')

@section('content')
<div class="container">
	<div class="card">
		<div class="card-header">{{ __('Crear viaje') }}</div>

		<div class="card-body">
			<form method="POST" action="/viajes/publicarViaje">
				@csrf

				<div class="form-group">
					<label for="titulo" class="control-label">Título:</label>
					<input type="text" class="form-control" name="titulo" placeholder="Ej.: Viajo todos los viernes hacia Cordoba.">
				</div>

				<div class="row">

					<div class="form-group col">
						<label for="origen" class="control-label">Origen:</label>
						<input type="text" class="form-control" name="origen" required>
					</div>

					<div class="form-group col">
						<label for="destino" class="control-label">Destino:</label>
						<input type="text" class="form-control" name="destino" required>
					</div>

				</div>

				<div class="row">

				<div class="form-group">
					<label for="hora" class="control-label ml-3">Hora:</label>
					<input required type="time" class="form-control ml-3" name="hora">
				</div>						
						
				<div class="form-group">
					<label for="precio" class="control-label ml-5">Precio:</label>
					<input required type="text" class="form-control ml-5" name="precio">
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
	<div class="form-group"> <!-- Submit Button -->
		<button type="submit" class="btn btn-primary">Publicar viaje</button>
	</div>     
	
</form>
@endsection