<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>NOMBRE</th>
			<th>DIRECCION</th>
			<th>ESTADO</th>
			<th>USURIO CREADOR</th>
			<th>USURIO MODIFICADOR</th>
			<th>MUNICIPIO</th>
			<th>FECHA DE CREACION</th>
			<th>FECHA DE MODIFICACION</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($naturales as $n)
			<tr>
				<td>{{$n->id}}</td>
				<td>{{$n->nombre}}</td>
				<td>{{$n->direccion}}</td>
				<td>{{$n->estado}}</td>
				<td>{{$n->UsuarioCreador['codigo']}}</td>
				<td>{{$n->UsuarioModificador['codigo']}}</td>
				<td>{{$n->Municipio['nombre']}}</td>
				<td>{{$n->created_at}}</td>
				<td>{{$n->updated_at}}</td>
			</tr>
		@endforeach
	</tbody>
</table>