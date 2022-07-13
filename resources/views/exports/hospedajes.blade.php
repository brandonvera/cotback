<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>RAZON SOCIAL</th>
			<th>ESTABLECIMIENTOS</th>
			<th>TELEFONO</th>
			<th>CORREO</th>
			<th>DIRECCION PRINCIPAL</th>
			<th>ESTADO</th>
			<th>USURIO CREADOR</th>
			<th>USURIO MODIFICADOR</th>
			<th>MUNICIPIO</th>
			<th>REPRESENTANTE LEGAL</th>
			<th>FECHA DE CREACION</th>
			<th>FECHA DE MODIFICACION</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($hospedajes as $h)
			<tr>
				<td>{{$h->id}}</td>
				<td>{{$h->razon_social}}</td>
				<td>{{$h->establecimientos}}</td>
				<td>{{$h->telefono}}</td>
				<td>{{$h->correo}}</td>
				<td>{{$h->direccion_principal}}</td>
				<td>{{$h->estado}}</td>
				<td>
					@if ($h->UsuarioCreador !== null)
						{{$h->UsuarioCreador['codigo']}}
					@else
						vacio
					@endif
				</td>
				<td>
					@if ($h->UsuarioModificador !== null)
						{{$h->UsuarioModificador['codigo']}}
					@else
						vacio
					@endif					
				</td>
				<td>{{$h->Municipio['nombre']}}</td>
				<td>
					@if ($h->Representante !== null)
						{{$h->Representante['codigo']}}
					@else
						vacio
					@endif					
				</td>
				<td>{{$h->created_at}}</td>
				<td>{{$h->updated_at}}</td>
			</tr>
		@endforeach
	</tbody>
</table>