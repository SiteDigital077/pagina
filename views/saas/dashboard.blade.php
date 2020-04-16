@extends ('adminsite.layoutsaas')

@section('ContenidoSite-01')
@foreach($infosaas as $infosaas)
@foreach($website as $website)
<div class="row">
  

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

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
                                            <img src="img/placeholders/avatars/avatar4@2x.jpg" alt="avatar" class="img-circle">
                                        </a>
                                        <h3>
                                            <strong>Jonathan Taylor</strong><br><small></small>
                                        </h3>
                                    </div>
                                    <table class="table table-borderless table-striped table-vcenter" >
                                        <tbody>
                                            <tr>
                                                <td class="text-right" style="width: 50%;"><strong>Hostname</strong></td>
                                                <td><a href="//{{$infosaas->fqdn}}" target="_blank">{{$infosaas->fqdn}}</a></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>ingresao administación</strong></td>
                                                <td><a href="//{{$infosaas->fqdn}}/login" target="_blank">{{$infosaas->fqdn}}/login</a></td>
                                            </tr>
                                             <tr>
                                                <td class="text-right"><strong>Email</strong></td>
                                                <td>{{$website->email}}</td>
                                            </tr>
                                             <tr>
                                                <td class="text-right"><strong>Password</strong></td>
                                                <td>{{$website->password}}</td>
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
                                                <td class="text-right"><strong>Estado</strong></td>
                                                @if($resp == 'true')
                                    <td><span class="label label-success"><i class="fa fa-check"></i> Activo </span></td>
                                                @else
                                    <td><span class="label label-danger"><i class="fa fa-check"></i> Inactivo </span></td>
                                                @endif
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
                                            <th class="text-center">ID</th>
                                            <th class="text-center"><i class="gi gi-user"></i></th>
                                            <th>Client</th>
                                            <th>Email</th>
                                            <th>Subscription</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center"><img src="img/placeholders/avatars/avatar15.jpg" alt="avatar" class="img-circle"></td>
                                            <td><a href="javascript:void(0)">client1</a></td>
                                            <td>client1@company.com</td>
                                            <td><span class="label label-info">Business</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="text-center"><img src="img/placeholders/avatars/avatar2.jpg" alt="avatar" class="img-circle"></td>
                                            <td><a href="javascript:void(0)">client2</a></td>
                                            <td>client2@company.com</td>
                                            <td><span class="label label-primary">Personal</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td class="text-center"><img src="img/placeholders/avatars/avatar7.jpg" alt="avatar" class="img-circle"></td>
                                            <td><a href="javascript:void(0)">client3</a></td>
                                            <td>client3@company.com</td>
                                            <td><span class="label label-info">Business</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td class="text-center"><img src="img/placeholders/avatars/avatar2.jpg" alt="avatar" class="img-circle"></td>
                                            <td><a href="javascript:void(0)">client4</a></td>
                                            <td>client4@company.com</td>
                                            <td><span class="label label-info">Business</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><img src="img/placeholders/avatars/avatar6.jpg" alt="avatar" class="img-circle"></td>
                                            <td><a href="javascript:void(0)">client5</a></td>
                                            <td>client5@company.com</td>
                                            <td><span class="label label-info">Business</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">6</td>
                                            <td class="text-center"><img src="img/placeholders/avatars/avatar13.jpg" alt="avatar" class="img-circle"></td>
                                            <td><a href="javascript:void(0)">client6</a></td>
                                            <td>client6@company.com</td>
                                            <td><span class="label label-success">VIP</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                       
                                      
                                     
                                        <tr>
                                            <td class="text-center">60</td>
                                            <td class="text-center"><img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="img-circle"></td>
                                            <td><a href="javascript:void(0)">client60</a></td>
                                            <td>client60@company.com</td>
                                            <td><span class="label label-warning">Trial</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
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