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
		@foreach ($transportes as $t)
			<tr>
				<td>{{$t->id}}</td>
				<td>{{$t->razon_social}}</td>
				<td>{{$t->establecimientos}}</td>
				<td>{{$t->telefono}}</td>
				<td>{{$t->correo}}</td>
				<td>{{$t->direccion_principal}}</td>
				<td>{{$t->estado}}</td>
				<td>{{$t->UsuarioCreador['nombre']}}</td>
				<td>{{$t->UsuarioModificador['nombre']}}</td>
				<td>{{$t->Municipio['nombre']}}</td>
				<td>{{$t->Representante['nombre']}}</td>
				<td>{{$t->created_at}}</td>
				<td>{{$t->updated_at}}</td>
			</tr>
		@endforeach
	</tbody>
</table>