@extends ('adminsite.layoutsaas')

@section('ContenidoSite-01')
@foreach($infosaas as $infosaas)
@foreach($website as $website)
<div class="row">
  



<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

  <?php $status=Session::get('status');?>
    @if($status=='ok_create')
      <div class="alert alert-success">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <strong>Se ha cancelado la suscripción correctamente</strong> US ...
      </div>
    @endif

    @if($status=='ok_delete')
      <div class="alert alert-danger">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <strong>No se ha cancelado la suscripción verifique e intente de nuevo</strong> US ...
      </div>
    @endif

 <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- Customer Info Block -->
                                <div class="block">
                                    <!-- Customer Info Title -->
                                    <div class="block-title">
                                        <h2><i class="fa fa-file-o"></i> <strong>Información</strong> cuenta</h2>
                                    </div>
                                    <!-- END Customer Info Title -->

                                    <!-- Customer Info -->
                                    <div class="block-section text-center">
                                        <a href="javascript:void(0)">
                                            <img src="/modulo-saas/img/avatar4@2x.jpg" alt="avatar" class="img-circle">
                                        </a>
                                        <h3>
                                            <strong>{{Auth::user()->name}} {{Auth::user()->last_name}}</strong><br><small></small>
                                        </h3>
                                    </div>
                                    <table class="table table-borderless table-striped table-vcenter" >
                                        <tbody>
                                             <tr>
                                                <td class="text-right"><strong>Estado</strong></td>
                                                @if($resp == 'true')
                                    <td><span class="label label-success"><i class="fa fa-check"></i> Activo </span></td>
                                                @else
                                    <td><span class="label label-danger"><i class="fa fa-check"></i> Inactivo </span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-right" style="width: 50%;"><strong>Hostname</strong></td>
                                                <td><a href="//{{$infosaas->fqdn}}" target="_blank">{{$infosaas->fqdn}}</a></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>ingresao administación</strong></td>
                                                <td><a href="//{{$infosaas->fqdn}}/login" target="_blank">{{$infosaas->fqdn}}/sd/login</a></td>
                                            </tr>
                                             <tr>
                                                <td class="text-right"><strong>Email</strong></td>
                                                <td>{{$website->email}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>Base de datos</strong></td>
                                                <td>{{$infosaas->uuid}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>Fecha registro</strong></td>
                                                <td>{{$infosaas->created_at}}</td>
                                            </tr>

                                            <tr>
                                                <td class="text-right"><strong>Suscripción</strong></td>
                                            <td>
                                            {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('/usuario/cancelarplan'))) }}
                                            <input type="hidden" class="form-control" name="idsuscripcion" id="" placeholder="Input field" value="{{$idsuscripcion}}">
                                             <script language="JavaScript">
                                             function confirmar ( mensaje ) {
                                             return confirm( mensaje );}
                                            </script>
                                            <button onclick="return confirmar('¿Está seguro que desea cancelar la suscripción?')" type="submit" class="btn btn-primary">Cancelar suscripción</button>
                                            {{ Form::close() }}
                                            </td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                    <!-- END Customer Info -->
                                </div>
                              </div>
                            </div>
  
</div>
                 

@endforeach
@endforeach
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  

                           <div class="block full">
                            <div class="block-title">
                                <h2><strong>Facturación</strong> host</h2>
                            </div>
                            

                            <div class="table-responsive">
                                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Referencia</th>
                                            <th class="text-center">Fecha</th>
                                            <th  class="text-center">Valor</th>
                                              <th  class="text-center">Autorización</th>
                                               <th class="text-center">Franquicia</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($facturas as $facturas)
                                        <tr>
                                            <td class="text-center">{{$facturas->ref_payco}}</td>
                                            <td class="text-center">{{$facturas->fecha_trans}}</td>
                                            <td class="text-center"><b>$ {{number_format($facturas->valor,0,",",".")}}</b></td>
                                            <td class="text-center">{{$facturas->autorizacion}}</a></td>
                                            <td class="text-center">{{$facturas->franquicia}}</a></td>
                                            <td class="text-center">{{$facturas->email}}</td>
                                            <td class="text-center"><span class="label label-success">{{$facturas->respuesta}}</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                     @endforeach
                                    
                                      
                                     
                            
                                    </tbody>
                                </table>
                            </div>
                      </div>
</div>
</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
   <script src="/adminsite/js/pages/tablesDatatables.js"></script>
        <script>$(function(){ TablesDatatables.init(); });</script>
@stop