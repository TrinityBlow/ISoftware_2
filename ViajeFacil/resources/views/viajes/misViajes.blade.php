@extends('layouts.layout', ['postulaciones',$postulaciones])
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
                <th>Precio</th>
                <th>Fecha</th>
                <th>Tipo de viaje</th>
                <th>Vehículo a utilizar</th>
                <th>Acciones</th>
            </tr>
            @foreach ($mis_viajes->reverse() as $viaje)
                <tr>
                    <td> {{ $viaje -> origen }} </td> 
                    <td> {{ $viaje -> destino }} </td>
                    <td> {{ $viaje -> precio }} </td>
                    <td> {{ $viaje -> fecha }} </td>
                    <td> {{ $viaje -> tipo_viaje }} </td> 
                    <td> Vehiculo </td>  
                    <td> <a class= 'text-center' href="/viajes/modificarViaje/{{ $viaje -> id_grupo }}"> <button type="button" class="btn btn-primary btn-sm">Modificar</button></a><br>
                    <a class="text-center" href="/viajes/verViajesDetalle/{{$viaje->id_grupo}}"><button type="button" class="btn btn-info mt-2 btn-sm">Ver detalles de viajes @if($postuPorGrupo[$viaje->id_grupo] > 0)({{$postuPorGrupo[$viaje->id_grupo]}})@endif</button></a><br> 
                    <a class= 'text-center' href="/viajes/eliminarViaje/{{ $viaje->id_grupo }}"> <button type="button" class="btn btn-danger mt-2 btn-sm">Eliminar</button> </a>
                    </td>
                    
                </tr>
            @endforeach
        </table>
    </div>
    </li>

</div>
@endsection