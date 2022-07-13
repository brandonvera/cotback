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
		@foreach ($culturales as $c)
			<tr>
				<td>{{$c->id}}</td>
				<td>{{$c->nombre}}</td>
				<td>{{$c->direccion}}</td>
				<td>{{$c->estado}}</td>
				<td>{{$c->UsuarioCreador['codigo']}}</td>
				<td>{{$c->UsuarioModificador['codigo']}}</td>
				<td>{{$c->Municipio['nombre']}}</td>
				<td>{{$c->created_at}}</td>
				<td>{{$c->updated_at}}</td>
			</tr>
		@endforeach
	</tbody>
</table>