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
					<input type="text" class="form-control" name="titulo" placeholder="(Opcional)">
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

<<<<<<< HEAD
	<div class="form-group">
		<label for="hora" class="control-label">Hora:</label>
		<input required type="time" class="form-control" name="hora">
	</div>						
			
	<div class="form-group">
		<label for="precio" class="control-label">Precio:</label>
		<input required type="text" class="form-control" name="precio">
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
	<div class="form-group">
		<label for="titulo" class="control-label">Título:</label>
		<input required type="text" class="form-control" name="titulo" placeholder="Inserte un titulo descriptivo para la publicación del viaje. Ejemplo: 'Viajo todos los viernes hacia el sur de Bs. As.'">
	</div>		
	
	<div class="form-group"> <!-- Submit Button -->
		<button type="submit" class="btn btn-primary">Publicar viaje</button>
	</div>     
	
</form>
@endsection
=======
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
							<input type="text" class="form-control" name="precio" required>
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

				<div class="form-group text-center mt-3"> <!-- Submit Button -->
					<button type="submit" class="btn btn-primary">Publicar viaje</button>
				</div>

			</form>
		</div>
	</div>
</div>
@endsection
>>>>>>> 9c8900d331d01358e9b6a35711ed2f01e2b018bc
