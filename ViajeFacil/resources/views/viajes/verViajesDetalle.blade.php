@extends('layouts.layout')

@section('content')
<div class="card">
	@csrf

	<li class="list-group ml-4 mt-3 mr-4">
		<b> Mis viajes:</b>
		<div class="table-responsive mt-3">
			<table class="table" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Origen</th>
						<th>Destino</th>
						<th>Fecha</th>
						<th>Acciones</th>
					</tr>
				</div>
				<tbody>
				@foreach ($mis_viajes as $viaje)
					<tr>
						<td> {{ $viaje -> origen }} </td> 
						<td> {{ $viaje -> destino }} </td>
						<td> {{ $viaje -> fecha }} </td>
						<td>
							@if( $viaje->fecha < $today )
								@if( $viaje->estado_viaje != 'finalizado')
									<div class="btn-group-vertical" style="width:100%">
										<div class="btn-group">
											<a href="/viajes/finalizarViaje/{{$viaje->id_viaje}}" class="btn btn-success btn-sm">
												Finalizar
											</a>
											<a href="/viajes/verPostulacionesViaje/{{$viaje->id_viaje}}" class="btn btn-info btn-sm">
												Ver postulaciones viaje
												@if($postulacionesViajes[$viaje->id_viaje] > 0)
													({{$postulacionesViajes[$viaje->id_viaje]}})
												@endif
											</a>
										</div>
									</div>
								@else
									<strong>Viaje finalizado</strong>
								@endif
							@else
								<a href="/viajes/verPostulacionesViaje/{{$viaje->id_viaje}}" class="btn btn-info btn-sm" style="width:100%">
									Ver postulaciones viaje
									@if($postulacionesViajes[$viaje->id_viaje] > 0)
										({{$postulacionesViajes[$viaje->id_viaje]}})
									@endif
								</a>
							@endif
						</td>
					</tr>
				@endforeach
				</div>
			</table>
		</div>
	</li>

</div>
@endsection
