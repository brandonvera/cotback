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
		@foreach ($alimentos as $a)
			<tr>
				<td>{{$a->id}}</td>
				<td>{{$a->razon_social}}</td>
				<td>{{$a->establecimientos}}</td>
				<td>{{$a->telefono}}</td>
				<td>{{$a->correo}}</td>
				<td>{{$a->direccion_principal}}</td>
				<td>{{$a->estado}}</td>
				<td>
					@if ($a->UsuarioCreador !== null)
						{{$a->UsuarioCreador['codigo']}}
					@else
						vacio
					@endif
				</td>
				<td>
					@if ($a->UsuarioModificador !== null)
						{{$a->UsuarioModificador['codigo']}}
					@else
						vacio
					@endif					
				</td>
				<td>{{$a->Municipio['nombre']}}</td>
				<td>
					@if ($a->Representante !== null)
						{{$a->Representante['codigo']}}
					@else
						vacio
					@endif					
				</td>
				<td>{{$a->created_at}}</td>
				<td>{{$a->updated_at}}</td>
			</tr>
		@endforeach
	</tbody>
</table>