 @if($contenido->level == 1)
 @if($contenido->slugcon == Request::segment(1))
@if($contenido->content == 1)
<a href="{{$contenido->url}}" class="btn {{$contenido->contents}} btn-block desing {{$contenido->image}} {{$contenido->imageal}} active" style="margin-top:4px" target="{{$contenido->video}}">{{$contenido->title}}</a>
@else
<a href="{{$contenido->url}}" class="btn {{$contenido->contents}} desing {{$contenido->image}} {{$contenido->imageal}} active" target="{{$contenido->video}}" style="margin-top:4px">{{$contenido->title}}</a>
@endif
@else
@if($contenido->content == 1)
<a href="{{$contenido->url}}" class="btn {{$contenido->contents}} btn-block desing {{$contenido->image}} {{$contenido->imageal}}" target="{{$contenido->video}}" style="margin-top:4px">{{$contenido->title}}</a>
@else
<a href="{{$contenido->url}}" class="btn {{$contenido->contents}} desing {{$contenido->image}} {{$contenido->imageal}}" target="{{$contenido->video}}" style="margin-top:4px">{{$contenido->title}}</a>
@endif
@endif

@else
@endif    

