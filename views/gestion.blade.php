@extends ('LayoutsSD.Layout')

@section('ContenidoSite-01')
<div class="container">
	@foreach($gestion as $gestion)
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	{!!$gestion->descripcion_car!!}
	</div>
	@endforeach



	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<!--

		@foreach($gestioncar as $gestioncar)
			<div class="media">
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<a class="pull-left" href="/gestiones/{{$gestioncar->slug_car}}">
					<img class="media-object" src="{{$gestioncar->imagen_car}}" style="width:100%" alt="Image">
				</a>
			   </div>
				<div class="media-body">
					<h4 class="media-heading">{{$gestioncar->titulo_car}}</h4>
					<p>{!!substr($gestioncar->descripcionweb_car, 0, 110)!!} ...</p>
				</div>
			</div>
	    @endforeach

 -->


<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
  	@foreach($collapse as $collapsed)
  	@foreach($identificador as $identificadorsa)
  	@if($collapsed->page_id == $identificadorsa->page_id)
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$collapsed->slugcon}}" aria-expanded="true" aria-controls="collapseOne">
          {{$collapsed->title}}
        </a>
      </h4>
    </div>
    @else
    @endif
    @endforeach
    @foreach($identificador as $identificadors)
    @if($collapsed->id == $identificadors->content_id)
    <div id="{{$collapsed->slugcon}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
    	@else
    	<div id="{{$collapsed->slugcon}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
    	@endif
    	@endforeach
      <div class="panel-body">

       @foreach($gestioncarta as $gestioncars)
       @if($collapsed->id == $gestioncars->content_id)
			<div class="media">
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<a class="pull-left" href="/gestiones/{{$gestioncars->slug_car}}">
					<img class="media-object" src="{{$gestioncars->imagen_car}}" style="width:100%" alt="Image">
				</a>
			   </div>
				<div class="media-body">
					<h4 class="media-heading"><b>{{$gestioncars->titulo_car}}</b></h4>
					<p>{!!substr($gestioncars->descripcionweb_car, 0, 110)!!} ...</p>
				</div>
			</div>
		@endif
	    @endforeach
      </div>
    </div>
    @endforeach



  </div>
</div>



</div></div>












</div>














	</div>
</div>







@stop