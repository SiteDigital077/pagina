@extends ('LayoutsSD.Layout')
  @section('cabecera')
    @parent
   
     {{ Html::style('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css') }}
    @stop

 @section('ContenidoSite-01')
  <br><br><br><br>
 @if(Session::get('suscripcion') == '')
 <h1 class="text-center">No tiene planes seleccionados</h1>
 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
 <a class="btn btn-primary" href="/">regresar al sitio</a>
 </div>
 @else
<div class="container">
	 
 	<div class="col-lg-8">
 		<?php $status=Session::get('status'); ?>
  @if($status=='ko_datos')
   <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Los datos de tarjeta ingresados no son validos verifique e intente de nuevo</strong>
   </div>
  @endif
		{{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('suscripcion/suscripcion'))) }}
	
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background: #f4f4f4">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 25px">			

			
		
			<div class="form-group col-lg-12">
				<h5 for="" class="text-primary">Información personal</h5>
				<hr>		
			</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group col-lg-6">
				<label for="">Nombre</label>
				<input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nombre">
			</div>

			<div class="form-group col-lg-6">
				<label for="">Apellido</label>
				<input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Apellido">
			</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<div class="form-group col-lg-6">
				<label for="">Tipo Documento</label>
				 <select id="tipo" name="tipo" class="form-control">
                  <option value="" selected>Seleccione tipo documento</option>
                  <option value="1">Cédula ciudadania</option>
                  <option value="2">Cédula extranjeria</option>
                  <option value="4">Tarjeta identidad</option>
                  <option value="5">Pasaporte</option>
                 </select>
			</div>

			<div class="form-group col-lg-6">
				<label for="">Documento</label>
				<input type="text" name="documento" class="form-control" value="{{ old('documento') }}" placeholder="Documento">
			</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group col-lg-6">
				<label for="">Email</label>
				<input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
			</div>

			<div class="form-group col-lg-6">
				<label for="">Número contacto</label>
				<input type="text" name="numero" class="form-control" value="{{ old('numero') }}" placeholder="Número de contacto">
			</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group col-lg-6">
				<label for="">Empresa</label>
				<input type="text" name="empresa" class="form-control" value="{{ old('phone') }}" placeholder="Teléfono">
			</div>
			<div class="form-group col-lg-6">
				<label for="">NIT</label>
				<input type="text" name="nit" class="form-control" value="{{ old('nit') }}" placeholder="NIT">
			</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group col-lg-12">
				<label for="">País</label>
				 <select id="pais" name="pais" class="form-control">
                  <option value="" selected>Seleccione país</option>
                  @foreach($pais as $pais)
                  <option value="{{$pais->id}}">{{$pais->pais}}</option>
                  @endforeach
                 </select>
			</div>
			<div class="form-group col-lg-12">
				<label for="">Contraseña</label>
				<input type="password" name="password" class="form-control" placeholder="Contraseña">
			</div>

			<div class="form-group col-lg-12">
				<label for="">Confirmar contraeña</label>
				<input type="password" name="password_confirmation" class="form-control" placeholder="Repetir contraseña">
			</div>
		</div>
			<div class="form-group col-lg-12">
			<button type="submit" class="btn btn-primary btn-md btn-block">crear cuenta</button>
		</div>
	</div>

	
		{{ Form::close() }}
	</div>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

   @foreach($planes as $planes)
	@if($planes->id_plan == Session::get('suscripcion'))	
     <div class="panel panel-primary">
      <div class="panel-heading text-center"><h3 class="text-center">{{$planes->name}}</h3></div>
       <div class="panel-body">
	   <h3 class="text-center"> ${{number_format($planes->amount,0,",",".")}}/Mensual</h3>
	   <h3 class="text-center text-primary"></h3>
	  <form action="/suscripcioneli/session" method="post">
       <button type="submit" class="btn btn-danger btn-md center-block">Cancelar suscripción</button>
      </form>
      </div>
	</div>
@else

			@endif 	
			 @endforeach

	</div>
</div>

  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
{{ Html::script('modulo-saas/valida.js') }}
  {{ Html::script('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js') }} 
@endif
 <br><br>
@stop

