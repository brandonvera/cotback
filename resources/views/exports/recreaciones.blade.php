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
		@foreach ($recreaciones as $r)
			<tr>
				<td>{{$r->id}}</td>
				<td>{{$r->razon_social}}</td>
				<td>{{$r->establecimientos}}</td>
				<td>{{$r->telefono}}</td>
				<td>{{$r->correo}}</td>
				<td>{{$r->direccion_principal}}</td>
				<td>{{$r->estado}}</td>
				<td>
					@if ($r->UsuarioCreador !== null)
						{{$r->UsuarioCreador['codigo']}}
					@else
						vacio
					@endif
				</td>
				<td>
					@if ($r->UsuarioModificador !== null)
						{{$r->UsuarioModificador['codigo']}}
					@else
						vacio
					@endif					
				</td>
				<td>{{$r->Municipio['nombre']}}</td>
				<td>
					@if ($r->Representante !== null)
						{{$r->Representante['codigo']}}
					@else
						vacio
					@endif					
				</td>
				<td>{{$r->created_at}}</td>
				<td>{{$r->updated_at}}</td>
			</tr>
		@endforeach
	</tbody>
</table>