@extends ('LayoutsSD.Layout')
  @section('cabecera')
    @parent
   
     {{ Html::style('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css') }}
    @stop

 @section('ContenidoSite-01')
<div class="container">
	

 	<div class="col-lg-8">
		{{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('suscripcion/suscripcion'))) }}
	
			<legend>Form title</legend>
		
			<div class="form-group">
				<label for="">Card number</label>
				<input type="text" name="card_number" class="form-control">
			</div>
			<div class="form-group">
				<label for="">Año expiración</label>
				<input type="text" name="exp_year" class="form-control">
			</div>
			<div class="form-group">
				<label for="">Mes de expiración</label>
				<input type="text" name="exp_month" class="form-control">
			</div>
			<div class="form-group">
				<label for="">cvc</label>
				<input type="text" name="cvc" class="form-control">
			</div>
		
			<div class="form-group">
				<label for="">Plan selecionado</label>
				<input type="text" name="id_plan" class="form-control" value="{{Session::get('suscripcion')}}">
			</div>
			
			<div class="form-group">
				<label for="">Nombre</label>
				<input type="text" name="name" id="name" class="form-control">
			</div>

			<div class="form-group">
				<label for="">Email</label>
				<input type="email" name="email" class="form-control">
			</div>

			<div class="form-group">
				<label for="">Nombre empresa o Hostanme</label>
				<input type="text" name="fqdn" class="form-control">
			</div>

			<div class="form-group">
				<label for="">Teléfono</label>
				<input type="text" name="phone" class="form-control">
			</div>
			<div class="form-group">
				<label for="">Contraseña</label>
				<input type="password" name="password" class="form-control">
			</div>

			<div class="form-group">
				<label for="">Confirmar contraeña</label>
				<input type="password" name="password_confirmation" class="form-control">
			</div>
	
		
			<button type="submit" class="btn btn-primary">Submit</button>
		{{ Form::close() }}
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		
		 <div class="box">
    <div class="container">
     	<div class="row">

			 @foreach($xmls['data'] as $data)
			 @if($data['id_plan'] == Session::get('suscripcion'))
			    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               
					<div class="box-part text-center">
                        
                        <i class="fa fa-instagram fa-3x" aria-hidden="true"></i>
                        
						<div class="title">
							<h4>{{$data['name']}}</h4>
						</div>
                        
						<div class="text">
							<span>Lorem ipsum dolor sit amet, id quo eruditi eloquentiam. Assum decore te sed. Elitr scripta ocurreret qui ad.</span>
						</div>
                        
						<form action="/suscripcioneli/session" method="post">
                        	<button type="submit" class="btn btn-danger btn-md">Cancelar suscripción</button>
                          </form>
                        
					 </div>
				</div>	
				@else

			@endif 	
			 @endforeach
		</div>		
    </div>
</div>

	</div>
</div>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
{{ Html::script('modulo-saas/valida.js') }}
  {{ Html::script('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js') }} 

@stop

