@extends ('adminsite.layout')
 
 @section('ContenidoSite-01')
  {{ Html::style('//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.css') }}

  <div class="content-header">
    <ul class="nav-horizontal text-center">
      <li>
       <a href="/gestor/planes-saas"><i class="fa fa-file-text"></i>Planes</a>
      </li>
      <li class="active">
       <a href="/suscripcion/ver-clientes"><i class="fa fa-file-o"></i>Clientes</a>
      </li> 
      <li>
        <a href="/suscripcion/ver-suscripciones"><i class="fa fa-file-o"></i>Suscripciones</a>
      </li>
     </ul>
    </div>
<div role="tabpanel" class="tab-pane active" id="contenido">
 <div class="container">
  <?php $name=Session::get('name');?>


    <div class="block full">
                            <div class="block-title">
                                <h2><strong>Clientes</strong> registrados</h2>
                            </div>
                           

                            <div class="table-responsive">
                                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th class="text-center">Fecha creación</th>
                                            <th class="text-center">Tarea</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($xmls['data'] as $data)
                                        <tr>
                                         <td>{{$data['id_customer']}}</td>
                                         <td>{{$data['name']}}</td>
                                         <td>{{$data['email']}}</td>
                                         <td>{{$data['phone']}}</td>
                                         <td class="text-center">{{$data['created']}}</td>
                                 
                                         <td class="text-center">
                                     
                                          <script language="JavaScript">
                                            function confirmar ( mensaje ) {
                                            return confirm( mensaje );}
                                          </script>
                                          <a href="<?=URL::to('/suscripcion/eliminar-plan/');?>/" onclick="return confirmar('¿Está seguro que desea eliminar el registro?')"><span id="tup" data-toggle="tooltip" data-placement="bottom" title="Eliminar contenido" class="btn btn-danger"><i class="hi hi-trash sidebar-nav-icon"></i></span></a>
                                         </td>
                                        </tr>
                                       @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
 </div>
    </div>

  {{ HTML::script('//code.jquery.com/jquery-1.11.1.min.js') }}
 {{ HTML::script('//cdn.datatables.net/1.10.1/js/jquery.dataTables.min.js') }}
   {{ HTML::script('//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.js') }}
 <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
 @stop
