@extends ('adminsite.layout')

    @section('cabecera')
    @parent
     {{ Html::style('//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.css') }}
     {{ Html::style('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css') }}
    @stop

@section('ContenidoSite-01')

 <div class="content-header">
      <ul class="nav-horizontal text-center">
      <li> 
       <a href="/gestor/ver-templates"><i class="fa fa-desktop"></i> Ver templates</a>
      </li>
      <li>
       <a href="/gestion/logo-head"><i class="fa fa-arrow-circle-up"></i> Logo encabezado</a>
      </li>
      <li>
       <a href="/gestion/logo-footer"><i class="fa fa-arrow-circle-down"></i> Logo pie página</a>
      </li>
      <li>
       <a href="/gestion/configurar-correo"><i class="fa fa-envelope"></i> Configurar correo</a>
      </li>
         <li>
       <a href="/gestion/redes-sociales"><i class="hi hi-bullhorn"></i> Redes sociales</a>
      </li>
      @if(Auth::user()->id == 1)
      <li class="active">
       <a href="/gestion/venta"><i class="gi gi-usd"></i> Ventas</a>
      </li>
      @else
      @endif
     </ul>
    </div>

 <div class="container topper">

  <?php $status=Session::get('status');?>
    @if($status=='ok_create')
      <div class="alert alert-success">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <strong>Opciones de compra registrada con exito</strong> US ...
      </div>
    @endif

    @if($status=='ok_delete')
      <div class="alert alert-danger">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <strong>Opciones de compra eliminada con exito</strong> US ...
      </div>
    @endif

    @if($status=='ok_update')
      <div class="alert alert-warning">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <strong>Opciones de compra actualizada con exito</strong> US ...
      </div>
    @endif
   
 </div>

<div class="container">
  <div class="row">
                            <div class="col-md-12">
                                <!-- Basic Form Elements Block -->
                                <div class="block">
                                    <!-- Basic Form Elements Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                           
                                        </div>
                                        <h2><strong>Posicionamiento</strong> SEO</h2>
                                    </div>
                                    <!-- END Form Elements Title -->
                            
                                    <!-- Basic Form Elements Content -->
                                   
                                      {{ Form::open(array('files' => true,'method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('gestion/contenidos/seoupdate'))) }}
                                         
                                      @foreach($seo as $seo)

                                      <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Idioma</label>
                                            <div class="col-md-9">
                                                 {{Form::text('idioma', $seo->idioma, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Canonical</label>
                                            <div class="col-md-9">
                                                 {{Form::text('canonical', $seo->canonical, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div> 

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Robots</label>
                                            <div class="col-md-9">
                                                 {{Form::textarea('robot', $seo->robots, array('class' => 'form-control','placeholder'=>'Ingrese estrcturacion robot'))}}
                                            </div>
                                        </div>
                            
                                       
                                     	Etiquetas Open Graph
                                      <hr>
                                       <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Og:type</label>
                                            <div class="col-md-9">
                                                 {{Form::text('og_type', $seo->og_type, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div>	

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Og:url</label>
                                            <div class="col-md-9">
                                                 {{Form::text('og_url', $seo->og_url, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div>  

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Og:title</label>
                                            <div class="col-md-9">
                                                 {{Form::text('og_title', $seo->og_title, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div>  
                                       
                                       <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Og:description</label>
                                            <div class="col-md-9">
                                                 {{Form::text('og_description', $seo->og_description, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div>  
                                       
                                        <div class="form-group">
                                          <label class="col-md-3 control-label" for="example-password-input">Og:imagen</label>
                                          <div class="col-md-9">
                                           <div class="input-group">
                                            <input type="text" id="image_label" class="form-control" name="FilePath" placeholder="Seleccionar imagen" aria-label="Image" aria-describedby="button-image" value="{{$seo->og_image}}">
                                            <span class="input-group-btn"><button class="btn btn-primary" type="button" id="button-image">Seleccionar imagen</button></span>
                                           </div>
                                          </div>
                                         </div>
                                        Etiquetas Twitter Card
                                        <hr>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Twitter:card</label>
                                            <div class="col-md-9">
                                                 {{Form::text('twitter_card', $seo->twitter_card, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div> 

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Twitter:site</label>
                                            <div class="col-md-9">
                                                 {{Form::text('twitter_site', $seo->twitter_site, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div> 

                                      <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Twitter:creator</label>
                                            <div class="col-md-9">
                                                 {{Form::text('twitter_creator', $seo->twitter_creator, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div> 

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Twitter:title</label>
                                            <div class="col-md-9">
                                                 {{Form::text('twitter_title', $seo->twitter_title, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div> 

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Twitter:description</label>
                                            <div class="col-md-9">
                                                 {{Form::text('twitter_description', $seo->twitter_description, array('class' => 'form-control', 'placeholder'=>'Ingrese sujeto'))}}
                                            </div>
                                        </div> 

                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Editar</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>

                                        
                                     @endforeach
                                      {{ Form::close() }} 
                                   

                                 
                                </div>
                                <!-- END Basic Form Elements Block -->
                            </div>
                          </div>
                          
                      </div>




  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

  {{ Html::script('Usuario/js/valida.js') }}
  {{ Html::script('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js') }} 
 
  {{ Html::script('//cdn.datatables.net/1.10.1/js/jquery.dataTables.min.js') }}
  {{ Html::script('//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.js') }}
  


<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('button-image').addEventListener('click', (event) => {
      event.preventDefault();
      window.open('/file-manager/fm-button', 'fm', 'width=900,height=500');
    });
  });
  // set file link
  function fmSetLink($url) {
    document.getElementById('image_label').value = $url;
  }
</script>

  <script>
     $(document).ready (function () {
   $('.nodelete').click (function () {
     alert("No puede eliminar todas las paginas del site si desea eliminar esta pagina debe crear una nueva");
   });});
</script>

  
  <script type="text/javascript" language="javascript" class="init">
   $(document).ready(function() {
   $('#example').dataTable();} );
  </script>

  <script>
   $(document).ready (function () {
   $('.delete').click (function () {
   if (confirm("¿ Está seguro de que desea eliminar ?")) {
   var id = $(this).attr ("title");
   document.location.href='paginas/delete/'+id;}});});
  </script> 

  <script type="text/javascript">
$(document).on("click", ".open-Modal", function () {
var myDNI = $(this).data('id');
$(".modal-body #DNI").val( myDNI );
});
</script>

<SCRIPT language="JavaScript" type="text/javascript"> 

function contador (campo, cuentacampo, limite) { 
if (campo.value.length > limite) campo.value = campo.value.substring(0, limite); 
else cuentacampo.value = limite - campo.value.length; 
} 

</script>


@stop