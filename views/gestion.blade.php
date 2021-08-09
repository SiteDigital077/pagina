@extends ('LayoutsSD.Layout')

@section('ContenidoSite-01')
<style>
  .card-header{
    background: none
  }
</style>

<div class="container">
<div class="row">
 

@foreach($gestion as $gestion)
 <div class="col-xs-8 col-sm-8 col-md-7 col-lg-7 mt-5">
  <img src="{!!$gestion->imagen_car!!}" class="center-block img-fluid" alt="Image">
  <p class="text-justify mr-5 pr-5 ml-5 pl-6">{!!$gestion->descripcion_car!!}</p>
 </div>
@endforeach


<div class="col-xs-4 col-sm-4 col-md-5 col-lg-5 mt-5 mb-5">
 <div id="accordion">
  @foreach($collapse as $collapsed)
   @foreach($identificador as $identificadorsa)
    @if($collapsed->page_id == $identificadorsa->page_id)
  <div class="card">
    <div class="card-header" id="headingOne">
      <h6 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#{{$collapsed->slugcon}}" aria-expanded="true" aria-controls="collapseOne">
        <span style="font-size: 15px; color: #FF5E15"> {{$collapsed->description}}</span>
        </button>
      </h6>
    </div>
    
     @foreach($identificador as $identificadors)
     @if($collapsed->id == $identificadors->content_id)
    <div id="{{$collapsed->slugcon}}" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      @else
      <div id="{{$collapsed->slugcon}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      @endif
      @endforeach
      <div class="card-body">
        
         @foreach($gestioncarta as $gestioncars)
           @if($collapsed->id == $gestioncars->content_id)
            <div class="media">
             
             <div class="col-xs-3 col-sm-3 col-md-3 col-lg-4">
              <a class="pull-left" href="/gestiones/{{$gestioncars->slug_car}}">
               <img class="media-object" src="{{$gestioncars->imagen_car}}" style="width:100%" alt="Image">
              </a>
             </div>
            
             <div class="media-body">
              <h6 class="media-heading"><b>{{$gestioncars->titulo_car}}</b></h6>
              <p>{!!substr($gestioncars->descripcionweb_car, 0, 110)!!} ...</p>
             </div>
      
            </div>
            @else
           @endif
          @endforeach

      </div>
    </div>
  </div>
  @else
  @endif
  @endforeach
  @endforeach
</div>
 </div>


</div></div>


@stop