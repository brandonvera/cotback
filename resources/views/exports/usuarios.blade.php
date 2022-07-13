<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>CODIGO</th>
			<th>NOMBRE</th>
			<th>APELLIDO</th>
			<th>CORREO</th>
			<th>CONTRASEÑA</th>
			<th>ESTADO</th>
			<th>USURAIO CREADOR</th>
			<th>USUARIO MODIFICADOR</th>
			<th>ROL</th>
			<th>FECHA DE CREACION</th>
			<th>FECHA DE MODIFICACION</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $user)
			<tr>
				<td>{{$user->id}}</td>
				<td>{{$user->codigo}}</td>
				<td>{{$user->nombre}}</td>
				<td>{{$user->apellido}}</td>
				<td>{{$user->email}}</td>
				<td>{{$user->password}}</td>
				<td>{{$user->estado}}</td>
				<td>
					@if ($user->UsuarioCreador !== null)
						{{$user->UsuarioCreador['codigo']}}
					@else
						vacio
					@endif
				</td>
				<td>
					@if ($user->UsuarioModificador !== null)
						{{$user->UsuarioModificador['codigo']}}
					@else
						vacio
					@endif					
				</td>
				<td>{{$user->TipoUsuario['tipo_usuario']}}</td>
				<td>{{$user->created_at}}</td>
				<td>{{$user->updated_at}}</td>
			</tr>
		@endforeach
	</tbody>
</table>