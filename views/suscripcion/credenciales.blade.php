@extends ('adminsite.layout')

 @section('ContenidoSite-01')
 <div class="content-header">
  <ul class="nav-horizontal text-center">
   <li>
    <a href="/gestion/usuario"><i class="gi gi-parents"></i> Usuarios</a>
   </li>
   <li class="active">
    <a href="/gestion/crear-usuario"><i class="fa fa-user-plus"></i> Crear Usuario</a>
   </li>
  </ul>
 </div>

 <div class="container">

 <?php $status=Session::get('status');?>
  

    @if($status=='ok_update')
      <div class="alert alert-warning">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <strong>Usuario actualizado con exito</strong> US ...
      </div>
    @endif

  <div class="row">
   <div class="col-md-12">
    <div class="block">
     
     <div class="block-title">
      <div class="block-options pull-right">
      </div>
      <h2><strong>Editar</strong> credenciales</h2>
     </div>
     @foreach($credenciales as $credenciales)
     {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('suscripcion/editarcredenciales'))) }}
      
      <div class="form-group">
       <label class="col-md-3 control-label" for="example-text-input">Public key</label>
        <div class="col-md-9">
         {{Form::text('public_key', $credenciales->public_key, array('class' => 'form-control','placeholder'=>'Ingrese nombre'))}}
        </div>
      </div>
      
      <div class="form-group">
       <label class="col-md-3 control-label" for="example-email-input">Private key</label>
        <div class="col-md-9">
         {{Form::text('private_key', $credenciales->private_key, array('class' => 'form-control','placeholder'=>'Ingrese apellido'))}}
        </div>
      </div>

      <div class="form-group form-actions">
       <div class="col-md-9 col-md-offset-3">
        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-angle-right"></i> Editar credenciales</button>
       </div>
      </div>
     
     {{ Form::close() }}
     

     @endforeach
    
    </div>
   </div>
  </div>                         
 </div>


 <footer>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   {{ Html::script('modulo-saas/editar-usuario.js') }}
  {{ Html::script('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js') }} 
 </footer>
 
@stop
