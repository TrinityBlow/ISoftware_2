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
					<input type="text" class="form-control" name="titulo" placeholder="Ej.: 'Viajo todos los días a Microcentro' (Opcional)">
				</div>

				<div class="row">

					<div class="form-group col">
						<label for="origen" class="control-label">Origen:</label>
						<input type="text" class="form-control" name="origen" placeholder="Ej.: 'La Plata'" required>
					</div>

					<div class="form-group col">
						<label for="destino" class="control-label">Destino:</label>
						<input type="text" class="form-control" name="destino" placeholder="Ej.: 'Capital Federal'" required>
					</div>

				</div>

				<div class="row">
					<div class="form-group col">
						<label for="fecha" class="control-label">Fecha:</label>
						<input type="date" class="form-control" name="fecha" value={{ $f0 }} min={{ $f0 }} max={{ $f1 }} required>
					</div>

					<div class="form-group col">
						<label for="hora" class="control-label">Hora:</label>
						<input type="time" class="form-control" name="hora" required>
					</div>

				</div>

				<div class="row">
						
					<div class="form-group col">
						<label for="precio" class="control-label">Precio:</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">$</span>
							</div>
							<input type="text" class="form-control" name="precio" placeholder="Ej.: 100" required>
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
					<label for="id_vehiculo" class="control-label">Vehículo que se usará para viajar:</label>
					<select class="form-control" name="id_vehiculo">
					@foreach ($vehiculos as $vehiculo)
						<option value={{$vehiculo->id_vehiculo}}>Patente: {{$vehiculo->patente}} | Marca: {{$vehiculo->marca}} | Modelo: {{$vehiculo->modelo}} | Cantidad de asientos: {{$vehiculo->cantidad_asientos}}</option>
					@endforeach	
					</select>
				</div>

				<div class="form-group text-center"> <!-- Submit Button -->
					<button type="submit" class="btn btn-primary">Publicar viaje</button>
				</div>

			</form>
		</div>
	</div>
</div>
@endsection