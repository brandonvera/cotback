<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>CODIGO</th>
			<th>PERSONA</th>			
			<th>CARGO</th>
			<th>TELEFONO</th>
			<th>CORREO</th>
			<th>DIRECCION</th>
			<th>ESTADO</th>
			<th>USURIO CREADOR</th>
			<th>USURIO MODIFICADOR</th>
			<th>FECHA DE CREACION</th>
			<th>FECHA DE MODIFICACION</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($representantes as $r)
			<tr>
				<td>{{$r->id}}</td>
				<td>{{$r->codigo}}</td>
				<td>{{$r->persona}}</td>			
				<td>{{$r->cargo}}</td>
				<td>{{$r->telefono}}</td>
				<td>{{$r->correo}}</td>
				<td>{{$r->direccion}}</td>
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
				<td>{{$r->created_at}}</td>
				<td>{{$r->updated_at}}</td>
			</tr>
		@endforeach
	</tbody>
</table>