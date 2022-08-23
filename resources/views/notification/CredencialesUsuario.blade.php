<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

	<title>COTATUR</title>
  </head>
  <body>
  	<div class="container-xl">
  		<div class="row d-flex justify-content-center">
  		<div class="col-md-6"> 
  		<div class="card mb-3 mt-3">
		  <img 
  			src="https://www.cotatur.com.ve/wp-content/uploads/2022/02/Logo-cotatur-2.png"
  			class="rounded mx-auto d-block img-fluid"
  			width="360">
		  <div class="card-body text-center">
		    <h5 class="card-title">
		    	Bienvenido {{$usuario['nombre']}}! 
			</h5>
		    <p class="card-text">
		    	Has sido registrado para ingresar al sistema, da click en el boton de abajo para ingresar e iniciar sesión.
		    </p>
		    <p class="card-text">
		    	Tus credenciales son:
		    	<br>
		    	Correo: <strong>{{$usuario['email']}}</strong>
		    	<br>
		    	Contraseña: <strong>{{$pw}}</strong>
		    </p>
		    <p class="card-text">
		    	<a 
		    		class="btn btn-outline-success" 
		    		href="https://brandonvera.github.io/cotfront" 
		    		role="button">
		    		Ingresar
		    	</a>
		    </p>
		    <p class="card-text">
		    	<small class="text-muted">
		    		Corporación Tachirense de Turismo © COTATUR 2022
		    	</small>
		    </p>
		  </div>
		</div>
		</div>
		</div>
  	</div>
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>
