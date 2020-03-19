 @if($contenido->level == 1)
 @if($contenido->slugcon == Request::segment(1))
@if($contenido->content == 1)
<a href="{{$contenido->url}}"><button type="button" class="btn {{$contenido->contents}} btn-block desing {{$contenido->image}} {{$contenido->imageal}} active" target="{{$contenido->video}}">{{$contenido->title}}</button></a>
@else
<a href="{{$contenido->url}}"><button type="button" class="btn {{$contenido->contents}} desing {{$contenido->image}} {{$contenido->imageal}} active" target="{{$contenido->video}}">{{$contenido->title}}</button></a>
@endif
@else
@if($contenido->content == 1)
<a href="{{$contenido->url}}"><button type="button" class="btn {{$contenido->contents}} btn-block desing {{$contenido->image}} {{$contenido->imageal}}" target="{{$contenido->video}}">{{$contenido->title}}</button></a>
@else
<a href="{{$contenido->url}}"><button type="button" class="btn {{$contenido->contents}} desing {{$contenido->image}} {{$contenido->imageal}}" target="{{$contenido->video}}">{{$contenido->title}}</button></a>
@endif
@endif

@else
@endif    
