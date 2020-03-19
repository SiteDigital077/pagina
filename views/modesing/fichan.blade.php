 @if($contenido->level == 1)

@foreach($contenidonumas as $contenidonuma)
  @if($contenidonuma->imageal =='fichan')
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 wow {{$contenidonuma->animacion}}">
    @if($contenidonuma->level == 1)
	<div class="thumbnail">
		<img src="fichaimg/clientes/{{$contenidonuma->usuario_id}}/{!!$contenidonuma->image!!}" alt="">
		<div class="caption">
			<h3>{!!$contenidonuma->title!!}</h3>
			<p class="text-justify">
				{!!substr($contenidonuma->position, 0, 200)!!}...
			</p>
			<p>
				<a href="empresa/{!!$contenidonuma->slug!!}" class="btn btn-primary btn-md" role="button">Ver Empresa</a>
		
			</p>
		</div>
	</div>
@else
@endif 
   </div>
  @endif 
 @endforeach     
 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
  {{$contenidonumas->links()}}
 </div>


@else
@endif