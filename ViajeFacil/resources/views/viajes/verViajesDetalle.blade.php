@extends('layouts.layout')

@section('content')
<div class="container">
	<div class="card">
		@csrf
		<div class="card-header">Viajes desde <strong>{{ $mis_viajes[0] -> origen }}</strong> hacia <strong>{{ $mis_viajes[0] -> destino }}</strong> a las <strong>{{ \Carbon\Carbon::parse($mis_viajes[0] -> fecha)->format('H:i') }}</strong></div>
			
		<div class="card-body">
			<div class="table-responsive">
				<table class="table" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($mis_viajes as $viaje)
							<tr>
								<td> {{ \Carbon\Carbon::parse($viaje -> fecha)->format('d/m/Y') }} </td>
								<td>
									<div class="container">
										@if( $viaje->estado_viaje != 'finalizado')
											<div class="row no-gutters">
												<div class="col-4 pl-1 pr-1">
													<a href="/viajes/verPostulacionesViaje/{{$viaje->id_viaje}}" class="btn btn-info btn-sm btn-block">
														Ver postulaciones
														@if($postulacionesViajes[$viaje->id_viaje] > 0)
															({{$postulacionesViajes[$viaje->id_viaje]}})
														@endif
													</a>
												</div>
												<div class="col-4 pl-1 pr-1">
													<a href="/viajes/verDetallesViaje/{{$viaje->id_viaje}}" class="btn btn-primary btn-sm btn-block">
														Ver preguntas
														@if($preguntasViajes[$viaje->id_viaje] > 0)
															({{$preguntasViajes[$viaje->id_viaje]}})
														@endif
													</a>
												</div>
												@if( $viaje->fecha < $today )
													<div class="col-4 pl-1 pr-1">
														<button class="btn btn-success btn-sm btn-block" data-id="{{$viaje->id_viaje}}" data-toggle="modal" data-target="#myModal"> Finalizar </button>
													</div>
												@endif
											</div>
										@else
											<strong>Viaje finalizado</strong>
										@endif
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalCenterTitle">Finalizar viaje</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="/viajes/finalizarViaje">
				@csrf
				<div class="modal-body">
					<input type="hidden" id="id_modal" name="id_viaje" value="">

					<div class="form-group">
						<label for="tarjeta" class="control-label">Número de tarjeta:</label>
						<input type="text" pattern="\d{16}" class="form-control" name="tarjeta" placeholder="0000000000000000" required>
					</div>
	
					<div class="row">
	
						<div class="form-group col">
							<label for="fecha_vencimiento" class="control-label">Fecha de vencimiento:</label>
							<div class="row">
								<div class="col">
									<select name="mes" class="form-control" required>
										<option value="" hidden>MM</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
									</select>
								</div>
								<div class="col">
									<select name="ano" class="form-control" required>
										<option value="" hidden>AA</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
										<option value="2023">2023</option>
									</select>
								</div>
							</div>
						</div>
	
						<div class="form-group col">
							<label for="cvv" class="control-label">Código de seguridad:</label>
							<input type="text" pattern="\d{3}" class="form-control" name="cvv" placeholder="000" required>
						</div>
	
					</div>

					<div class="form-group">
						<p for="total" class="control-label"><strong>Total a pagar: ${{ ceil( ceil(ceil($viaje->precio * 100) / 110) * 0.10  ) }}</strong></p>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-success">Pagar</button>
				</div>

			</form>
		</div>
	</div>
</div>
@endsection
