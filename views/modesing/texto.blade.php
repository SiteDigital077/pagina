 @if($contenido->level == 1)
@if($contenido->url == NULL)
<div class="texto desing">
 {!!$contenido->content!!}
</div> 
@else
<div class="texto desing">
 {!!$contenido->content!!}
</div> 
<button type="button" class="btn btn-primary btn-lg">Ver más</button>
@endif
@else
@endif    
