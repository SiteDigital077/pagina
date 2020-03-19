 @if($contenido->level == 1)
 
<div id="counter" class="counter" style="text-align: center;">

	<div class="thumbnail">
		@if($contenido->image == '')
		<img src="{{$contenido->image}}" class="img-responsive center-block" alt="Image">
		@else
		 <i class="{{$contenido->image}}" aria-hidden="true"></i>
		@endif
		<div class="caption">
			  <p class="counter-value" style="text-align: center;" data-count="{{$contenido->imageal}}">0</p>
			  <h2>{{$contenido->title}}</h2>
		</div>
	</div>

</div>
@else
@endif




