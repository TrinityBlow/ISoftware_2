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
                                    <th>Precio</th>
                                    <th>Fecha</th>
                                    <th>Tipo de viaje</th>
                                    <th>Vehículo a utilizar</th>
                                    <th>Acciones</th>
                                </tr>
                                @foreach ($mis_viajes as $viaje)
                                    <tr>
                                        <td> {{ $viaje -> origen }} </td> 
                                        <td> {{ $viaje -> destino }} </td>
                                        <td> {{ $viaje -> precio }} </td>
                                        <td> {{ $viaje -> fecha }} </td>
                                        <td> {{ $viaje -> tipo_viaje }} </td> 
                                        <td> Vehiculo </td>  
                                        <td>
                                            <a class="text-center" href="/viajes/verPostulacionesViaje/{{$viaje->id_viaje}}"><button type="button" class="btn btn-info mt-2 btn-sm">Ver postulaciones viaje @if($postulacionesViajes[$viaje->id_viaje] > 0) ({{$postulacionesViajes[$viaje->id_viaje]}}) @endif</button></a><br> 
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </li>

</div>
@endsection