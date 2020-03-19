 
 @if($contenido->level == 1)
<a href="banner-clic/{{$contenido->id}}"><img src="{{$contenido->image}}" class="img-responsive" alt="Image"></a>

<input type="hidden" name="" id="input" class="form-control" value="{{DB::table('contents')->where('id',$contenido->id)->limit(1)->update(['imageal'=> DB::raw('imageal + 1')])}}" required="required" pattern="" title="">
@else

@endif
