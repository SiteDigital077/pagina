@extends ('adminsite.layout')


 @section('cabecera')
    @parent
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>  
    <script src="/vendors/ckeditor/ckeditor.js"></script>  
    @stop


 @section('ContenidoSite-01')


 <div class="container">
  <div class="row">
                            <div class="col-md-12">
                                <!-- Basic Form Elements Block -->
                                <div class="block">
                                    <!-- Basic Form Elements Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class">No Borders</a>
                                        </div>
                                        <h2><strong>Editar</strong> Tabs</h2>
                                    </div>
                                    <!-- END Form Elements Title -->
                                    
                                    <!-- Basic Form Elements Content -->
                                   {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('gestion/contenidos/actualizartab',$contenido->id))) }}

                                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-text-input">Título</label>
                                            <div class="col-md-9">
                                                {{Form::text('titlecl', $contenido->titlecl, array('class' => 'form-control','placeholder'=>'Ingrese titulo'))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Descripción</label>
                                            <div class="col-md-9">
                                                 {{Form::text('descriptioncl', $contenido->descriptioncl, array('class' => 'form-control','placeholder'=>'Ingrese descripción'))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Contenido</label>
                                            <div class="col-md-9">
                                                  {{Form::textarea('contentcl', $contenido->contentcl, array('class' => 'ckeditor','id' => 'editor','placeholder'=>'Ingrese descripción'))}}
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Url</label>
                                            <div class="col-md-9">
                                                 {{Form::text('enlace', $contenido->urlsd, array('class' => 'form-control','placeholder'=>'Ingrese URL'))}}
                                            </div>
                                        </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Imagen</label>
                                            <div class="col-md-9">
                                                 <input type="text" name="FilePath" readonly="readonly" onclick="openKCFinder(this)" value="{{$contenido->imagecl}}" class="form-control" />
                                            </div>
                                        </div>
                       
                                           @if($contenido->posicion == 'pull-right')

                                             <div class="form-group">
                                            <label class="col-md-3 control-label">Alinear Imagen</label>
                                            <div class="col-md-9">
                                             {{Form::radio('posicion', 'pull-left')}}Alinear izquierda<br>
                                             {{Form::radio('posicion', 'pull-right', true)}}Alinear derecha<br>
                                             {{Form::radio('posicion', 'center-block')}}Centrar
                                            </div>
                                        </div> 
                                         @elseif($contenido->posicion == 'pull-left')
                                           <div class="form-group">
                                            <label class="col-md-3 control-label">Alinear Imagen</label>
                                            <div class="col-md-9">
                                             {{Form::radio('posicion', 'pull-left', true)}}Alinear izquierda<br>
                                             {{Form::radio('posicion', 'pull-right')}}Alinear derecha<br>
                                             {{Form::radio('posicion', 'center-block')}}Centrar
                                            </div>
                                        </div> 
                                         @elseif($contenido->posicion == 'center-block')
                                           <div class="form-group">
                                            <label class="col-md-3 control-label">Alinear Imagen</label>
                                            <div class="col-md-9">
                                             {{Form::radio('posicion', 'pull-left')}}Alinear izquierda<br>
                                             {{Form::radio('posicion', 'pull-right')}}Alinear derecha<br>
                                             {{Form::radio('posicion', 'center-block', true)}}Centrar
                                            </div>
                                        </div> 
                                         @endif

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado</label>
                                            <div class="col-md-9">
                                                {{Form::text('state', $contenido->state, array('class' => 'form-control','placeholder'=>'Ingrese estado'))}}
                                            </div>
                                        </div>

                                       
                                     
                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                
                                </div>
                                <!-- END Basic Form Elements Block -->
                            </div>
                          </div>
                          
</div>



<footer>
<script type="text/javascript">  
       CKEDITOR.replace( 'editor' );  
    </script>  

<script src="/vendors/ckeditor/config.js?t=HBDD" type="text/javascript"></script>

<script type="text/javascript">
function openKCFinder(field) {
    window.KCFinder = {
        callBack: function(url) {
            field.value = url;
            window.KCFinder = null;
        }
    };
    window.open('/vendors/kcfinder/browse.php?type=images&dir=files/public', 'kcfinder_textbox',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
    );
}
</script>
</footer>
 @stop