 @if($contenido->level == 1)
<div class="grid">
 <figure class="effect-zoe">
  <img src="{{$contenido->image}}" class="img-responsive" alt="img25"/>
   <figcaption>
	<h2>Creative <span>Zoe</span></h2>
     <p class="icon-links">
	  <a href="#"><i class="glyphicon glyphicon-star"></i></a>
   	  <a href="#"><i class="glyphicon glyphicon-th"></i></a>
	  <a href="#"><i class="glyphicon glyphicon-phone"></i></a>
	 </p>
	 <p class="description">Zoe never had the patience of her sisters. She deliberately punched the bear in his face.</p>
   </figcaption>	
  </figure>		
 </div>
@else
@endif