@extends('layouts.layout')
@section('content')
	<div class="card mt-4">
		@csrf
		<li class="list-group-item">
			<b> Mis viajes:</b>
			<div class="table-responsive mt-2">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<tr>
						<th>Origen</th>
						<th>Destino</th>
						<th>Fecha</th>
						<th>Acciones</th>
					</tr>
					@foreach ($mis_viajes as $viaje)
						<tr>
							<td> {{ $viaje -> origen }} </td> 
							<td> {{ $viaje -> destino }} </td>
							<td> {{ $viaje -> fecha }} </td>
							<td>
								@if( $viaje->fecha < $today )
									@if( $viaje->estado_viaje != 'finalizado')
										<a href='/viajes/finalizarViaje/{{$viaje->id_viaje}}'> <button type="button" class="btn btn-success btn-sm"> Finalizar </button></a>
										<a class="text-center" href="/viajes/verPostulacionesViaje/{{$viaje->id_viaje}}"><button type="button" class="btn btn-info mt-2 btn-sm">Ver postulaciones viaje @if($postulacionesViajes[$viaje->id_viaje] > 0) ({{$postulacionesViajes[$viaje->id_viaje]}}) @endif</button></a><br> 
									@else
										<strong>Viaje Finalizado</strong>
									@endif
									<br>
								@endif
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		</li>

	</div>
@endsection