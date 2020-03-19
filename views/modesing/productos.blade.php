 @if($contenido->level == 1)

           @foreach($products as $product)
      
           <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 procar">
              <div class="thumb-wrapper">
                <span class="wish-icon"><i class="fa fa-heart-o"></i></span>
                <div class="img-box">
                  <img src="{{$product->image}}" class="img-responsive img-fluid center-block" alt="" style="height: 140px">                 
                </div>
                <div class="thumb-content">
                  @if(strlen($product->name) < 22)
                  <h4>{{$product->name}}</h4>
                  @else
                  <h4 data-toggle="tooltip" title="{{$product->name}}">{!!substr($product->name, 0, 22)!!} ...  </h4>
                  @endif   
                  <div class="star-rating text-center">
                    <ul class="list-inline">
                      <li class="list-inline-item"><i class="fa fa-star"></i></li>
                      <li class="list-inline-item"><i class="fa fa-star"></i></li>
                      <li class="list-inline-item"><i class="fa fa-star"></i></li>
                      <li class="list-inline-item"><i class="fa fa-star"></i></li>
                      <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                    </ul>
                 
           
                   @if($product->stock == '0')
                   <p class="text-primary text-center"><b>cantidad disponible : ∞</b></p>
                   @else
                   <p class="text-primary text-center"><b>cantidad disponible : {{$product->stock}}</b></p>
                   @endif
              
        
                 
                  </div>

                
                  @if($product->precioivafin == $product->precioinivafin)
                  <p class="item-price text-center text-primary"><b>${{number_format($product->precioinivafin,0,",",".")}}</b></p>
                  @else
                  <p class="item-price text-center"><strike>${{number_format($product->precioivafin,0,",",".")}}</strike> <b><span class="text-primary">${{number_format($product->precioinivafin,0,",",".")}}</span></b></p>
                  @endif
                  
           
        

                 <a href="{{ route('product-detail', $product->slug)}}" class="btn btn-default animated fadeIn infinite">Ver detalle</a>
                  @if($product->position == '0')
                  <a href="{{ route('cart-add', $product->slug)}}" class="btn btn-primary animated fadeIn infinite">Agregar al carrito</a>
                  @else
                 <a class="btn btn-danger disabled">No disponible</a>
                 @endif

          


              
        


                </div>            
              </div>
            </div>
       
          @endforeach

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
          {{ $products->links() }}
          </div>

<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@else
@endif