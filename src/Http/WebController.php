<?php

 namespace DigitalsiteSaaS\Pagina\Http;
 use DigitalsiteSaaS\Pagina\Page;
 use DigitalsiteSaaS\Pagina\Fichaje;
 use DigitalsiteSaaS\Pagina\Template;
 use DigitalsiteSaaS\Pagina\Estadistica;
 use DigitalsiteSaaS\Pagina\Maxo;
 use DigitalsiteSaaS\Pagina\Maxu;

 use DigitalsiteSaaS\Pagina\Maxe;
 use DigitalsiteSaaS\Pagina\Maxi;
 use DigitalsiteSaaS\Pagina\Muxu;
 use DigitalsiteSaaS\Pagina\Message;
 use DigitalsiteSaaS\Pagina\Messagema;
 use DigitalsiteSaaS\Pagina\Image;
 use DigitalsiteSaaS\Usuario\Usuario;
 use DigitalsiteSaaS\Pagina\Bloguero;
 use DigitalsiteSaaS\Pagina\Select;
 use DigitalsiteSaaS\Pagina\Zippera;
 use DigitalsiteSaaS\Pagina\Registrow;
 use DigitalsiteSaaS\Pagina\Product;
 use DigitalsiteSaaS\Pagina\OrderItem;
 use DigitalsiteSaaS\Pagina\Carousel;
 use DigitalsiteSaaS\Pagina\Empleo;
 use DigitalsiteSaaS\Pagina\Pais;
 use DigitalsiteSaaS\Pagina\Content;
 use DigitalsiteSaaS\Pagina\Ips;
 use DigitalsiteSaaS\Pagina\Diagrama;
  use DigitalsiteSaaS\Pagina\Formu;
 use Mail;
 use DB;
 use Hash;
 use File;
 use Zipper;
 use Redirect;
 use App\Http\Controllers\Controller;
 use App\Http\Requests\FicusuarioCreateRequest;
 use Input;
 use Illuminate\Support\Str;
 use Request;
 use App\Mail\Mensaje;
 use App\Mail\Mensajeficha;
 use App\Mail\Registro;
 use App\Mail\Mensajema;
 use App\Mail\SendMailable;
 use Validator;

 use App\Http\Requests\FormularioFormRequest;
 use Auth;
use Carbon\Carbon;
 use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use GuzzleHttp\Client;




 class WebController extends Controller {



 protected $tenantName = null;

public function __construct()
    {
        $this->middleware('web');

        $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
        if ($hostname){
            $fqdn = $hostname->fqdn;
            $this->tenantName = explode(".", $fqdn)[0];
        }
      
    }

  private function total(){
   $cart = session()->get('cart');
   $total = 0;
   if($cart == null){}
   else{
	foreach ($cart as $item) {
	 $total += $item->precioinivafin * $item->quantity;
   }}
   return $total;
  }

  private function subtotal(){
   $cart = session()->get('cart');
   $subtotal = 0;
   if($cart == null){}
   else{
	foreach($cart as $item){
	 $subtotal += $item->preciodescfin * $item->quantity;
   }}
   return $subtotal;
  }

  public function index(){

    $planessaas = DB::table('planes')->get();


    if(!$this->tenantName){
   $users = DB::table('pages')->where('posti', '1')->get();
	foreach ($users as $user){

     

     $cama = Page::find($user->id);
     $menu = Page::whereNull('page_id')->orderBy('posta', 'asc')->get();
     $meta = Page::where('id','=',$user->id)->get();
     $plantilla = Template::all();
     $plantillaes = Template::all();
     $paginations = Page::find($user->id)->Blogs()->paginate(9);
     $temawebs = Template::where('id','=','1')->get();
     $scroll = Template::where('id',1)->value('scroll');
     $temp = Template::where('id',1)->value('template');
     foreach($temawebs as $temaweb){
       if($scroll == 1){
      $contenido = Content::all();
      $diagramas = Diagrama::all();
       $formulario = Formu::join('contents','inputs.content_id','=','contents.id')
    ->select('inputs.*', 'inputs.id')
    ->orderBy('id','ASC')
    ->get();
      }else{
        $contenido = Content::where('page_id',"=",$user->id)
      /*->where('template',"=",$temaweb->template)*/
      ->orderBy('nivel','ASC')
      ->get();
       $formulario = Formu::join('contents','inputs.content_id','=','contents.id')
    ->select('inputs.*', 'inputs.id')
    ->orderBy('id','ASC')
    ->where('contents.page_id', '=' ,$user->id)->get();
      $diagramas = Diagrama::where('id', "=", $user->id)->get();
    }
     }
    
  
     $productsa = Product::inRandomOrder()->get();

     $eventos = DB::table('events')->orderBy('start_old', 'desc')->get();
     $start =  session()->get('start') ? session()->get('start') : 0;
	 $end = session()->get('end') ? session()->get('end') : 100000000000000;
	 $tipo = session()->get('tipo');
	 $totaleventos = DB::table('events')
	  ->whereBetween('start_old', array($start, $end))
	  ->where('class', 'like', '%' . $tipo . '%')
	  ->get();
	 $productse = Product::inRandomOrder()->get();
     $stock = DB::table('products')
      //->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
      //->select(DB::raw('SUM(quantity) as cantidad'),DB::raw('(products.id) as product'),DB::raw('(product_id) as productse'))
      //->groupBy('products.id')
      ->get();
      $terminos = \DigitalsiteSaaS\Pagina\Template::all();
		$categories = Pais::all();
     $banners = Page::find($user->id)->Banners()->orderByRaw("RAND()")->take(1)->get();
     $bannersback = Page::find($user->id)->Banners()->orderByRaw("RAND()")->take(1)->get();
     $fichones = Page::find($user->id)->Fichas()->orderBy(DB::raw('RAND()'))->paginate(6, ['*'], 'fichones');
     $contenidona = Maxo::join('contents','contents.id','=','collapse.content_id')
	  ->orderBy('position','ASC')
	  ->where('contents.page_id', '=' ,$user->id)->get();
	 $contenidonu = Maxu::join('contents','contents.id','=','tabs.content_id')
	  ->orderBy('position','ASC')
	  ->where('contents.page_id', '=' ,$user->id)->get();
	 $contenidonumas =  DB::table('ficha')->where('responsive', $user->id)->orderBy(DB::raw('RAND()'))->paginate(6, ['*'], 'contenidonumas');  
    
     $contenida = Maxi::join('contents','contents.id','=','images.content_id')
	  ->orderBy('position','ASC')
	  ->where('contents.page_id', '=' ,$user->id)->get();
    
     $cart = session()->get('cart');
     $min_price = Input::has('min_price') ? Input::get('min_price') : 0;
     $max_price = Input::has('max_price') ? Input::get('max_price') : 10000000;
     $clientes =  Input::get('clientes');
     $areafil = Input::get('area');
     $parametrofil = Input::get('parametro');
     $autorfil = Input::get('autor');
     $subcategoriafil = Input::get('subcategoria');
	 $products = DB::table('products')
      ->whereBetween('precio', array($min_price, $max_price))
      ->where('category_id', 'like', '%' . $clientes . '%')
      ->where('parametro_id', 'like', '%' . $parametrofil . '%')
      ->where('autor_id', 'like', '%' . $autorfil . '%')
      ->where('category_id', 'like', '%' . $subcategoriafil . '%')
      ->paginate(12);
      //dd($products);
	 $total = $this->total();
	 $subtotal = $this->subtotal();
	 $carousel = DB::table('contents')
	 ->join('carousel','contents.id','=','carousel.content_id')
	 ->get();
	 $carouselimg = DB::table('carousel_image')->get();
	 $filtros = DB::table('categoriessd')->get();
	 $subcategoria = DB::table('categoriapro')->get();
	 $parametro = DB::table('parametro')->get();
	 $autor = DB::table('autor')->get();
	 $area = DB::table('areas')->get();
	 $selectores = DB::table('selectors')->get();
	 $eventodig = DB::table('tipo_evento')->get();	
	 $venta = DB::table('venta')->get();	
	 $colors = DB::table('colors')->get();	
	 $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
     //dd($arr_ip);
     $ip = $arr_ip['ip'];

     $ciudad = $arr_ip['city'];
        
     $pais = $arr_ip['country'];
     $blogfoot = Bloguero::inRandomOrder()->take(6)->get();
     $empleos = Empleo::join('contents','contents.id','=','empleos.content_id')
	  ->orderBy('position','ASC')
	  ->where('contents.page_id', '=' ,$user->id)
	  ->get();

	 return view('Templates.'.$temp.'.desing')->with('contenido', $contenido)->with('contenidona', $contenidona)->with('contenidonu', $contenidonu)->with('contenidonus', $contenidonu)->with('menu', $menu)->with('galeria', $contenida)->with('mascar', $contenido)->with('pasto', $contenido)->with('casual', $contenido)->with('plantilla', $plantilla)->with('plantillaes', $plantillaes)->with('meta', $meta)->with('contenidu', $contenido)->with('paginations', $paginations)->with('fichones', $fichones)->with('contenidonumas', $contenidonumas)->with('cama', $cama)->with('banners', $banners)->with('bannersback', $bannersback)->with('selectores', $selectores)->with('cart', $cart)->with('products', $products)->with('productsa', $productsa)->with('productse', $productse)->with('total', $total)->with('subtotal', $subtotal)->with('diagramas', $diagramas)->with('subcategoria', $subcategoria)->with('autor', $autor)->with('parametro', $parametro)->with('area', $area)->with('stock', $stock)->with('filtros', $filtros)->with('eventodig', $eventodig)->with('eventos', $eventos)->with('totaleventos', $totaleventos)->with('colors', $colors)->with('ip', $ip)->with('ciudad', $ciudad)->with('pais', $pais)->with('carousel', $carousel)->with('carouselimg', $carouselimg)->with('blogfoot', $blogfoot)->with('empleos', $empleos)->with('terminos', $terminos)->with('categories', $categories)->with('planessaas', $planessaas)->with('formulario', $formulario);
     }}

     $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
  $infosaas = DB::table('tenancy.hostnames')
  ->join('tenancy.websites','websites.id','=','hostnames.website_id')
  ->where('hostnames.fqdn',  $hostname->fqdn)
  ->get();
  foreach ($infosaas as $infosaasweb) {
  $mihost =  ($infosaasweb->uuid.'.');
  $website = DB::table($mihost.'users')->get();
  $dias = date('Y-m-d');
  if($dias <=  $infosaasweb->presentacion){
  $resp = 'true';
  }else{
  $resp = 'false'; 
  }
}
     $users = DB::table('pages')->where('posti', '1')->get();
    
  foreach ($users as $user){
     $cama = \DigitalsiteSaaS\Pagina\Tenant\Page::find($user->id);
     $menu = \DigitalsiteSaaS\Pagina\Tenant\Page::whereNull('page_id')->orderBy('posta', 'asc')->get();
     $meta = \DigitalsiteSaaS\Pagina\Tenant\Page::where('id','=',$user->id)->get();
     $plantilla = \DigitalsiteSaaS\Pagina\Tenant\Template::all();
     $plantillaes = \DigitalsiteSaaS\Pagina\Tenant\Template::all();
     $paginations = \DigitalsiteSaaS\Pagina\Tenant\Page::find($user->id)->Blogs()->paginate(9);
     $diagramas = \DigitalsiteSaaS\Pagina\Tenant\Diagrama::where('id', "=", $user->id)->get();
     $temawebs = \DigitalsiteSaaS\Pagina\Tenant\Template::where('id','=','1')->get();
     foreach($temawebs as $temaweb){
      $contenido = \DigitalsiteSaaS\Pagina\Tenant\Content::where('page_id',"=",$user->id)
      /*->where('template',"=",$temaweb->template)*/
      ->orderBy('nivel','ASC')
      ->get();
     }
    
    

 
     $productsa = \DigitalsiteSaaS\Pagina\Tenant\Product::inRandomOrder()->get();
     $eventos = DB::table('events')->orderBy('start_old', 'desc')->get();
     $start =  session()->get('start') ? session()->get('start') : 0;
   $end = session()->get('end') ? session()->get('end') : 100000000000000;
   $tipo = session()->get('tipo');
   $totaleventos = DB::table('events')
    ->whereBetween('start_old', array($start, $end))
    ->where('class', 'like', '%' . $tipo . '%')
    ->get();
   $productse = \DigitalsiteSaaS\Pagina\Tenant\Product::inRandomOrder()->get();
     $stock = DB::table('products')
      //->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
      //->select(DB::raw('SUM(quantity) as cantidad'),DB::raw('(products.id) as product'),DB::raw('(product_id) as productse'))
      //->groupBy('products.id')
      ->get();
      $terminos = \DigitalsiteSaaS\Pagina\Template::all();
    $categories = \DigitalsiteSaaS\Pagina\Tenant\Pais::all();
     $banners = \DigitalsiteSaaS\Pagina\Tenant\Page::find($user->id)->Banners()->orderByRaw("RAND()")->take(1)->get();
     $bannersback = \DigitalsiteSaaS\Pagina\Tenant\Page::find($user->id)->Banners()->orderByRaw("RAND()")->take(1)->get();
     $fichones = \DigitalsiteSaaS\Pagina\Tenant\Page::find($user->id)->Fichas()->orderBy(DB::raw('RAND()'))->paginate(6, ['*'], 'fichones');
     $contenidona = \DigitalsiteSaaS\Pagina\Tenant\Maxo::join('contents','contents.id','=','collapse.content_id')
    ->orderBy('position','ASC')
    ->where('contents.page_id', '=' ,$user->id)->get();
   $contenidonu = \DigitalsiteSaaS\Pagina\Tenant\Maxu::join('contents','contents.id','=','tabs.content_id')
    ->orderBy('position','ASC')
    ->where('contents.page_id', '=' ,$user->id)->get();
   $contenidonumas =  DB::table('ficha')->where('responsive', $user->id)->orderBy(DB::raw('RAND()'))->paginate(6, ['*'], 'contenidonumas');  
  
     $contenida = \DigitalsiteSaaS\Pagina\Tenant\Maxi::join('contents','contents.id','=','images.content_id')
    ->orderBy('position','ASC')
    ->where('contents.page_id', '=' ,$user->id)->get();
     $formulario = \DigitalsiteSaaS\Pagina\Tenant\Formu::join('contents','inputs.content_id','=','contents.id')
    ->select('inputs.*', 'inputs.id')
    ->orderBy('id','ASC')
    ->where('contents.page_id', '=' ,$user->id)->get();
     $cart = session()->get('cart');
     $min_price = Input::has('min_price') ? Input::get('min_price') : 0;
     $max_price = Input::has('max_price') ? Input::get('max_price') : 10000000;
     $clientes =  Input::get('clientes');
     $areafil = Input::get('area');
     $parametrofil = Input::get('parametro');
     $autorfil = Input::get('autor');
     $subcategoriafil = Input::get('subcategoria');
   $products = DB::table('products')
      ->whereBetween('precio', array($min_price, $max_price))
      ->where('category_id', 'like', '%' . $clientes . '%')
      ->where('parametro_id', 'like', '%' . $parametrofil . '%')
      ->where('autor_id', 'like', '%' . $autorfil . '%')
      ->where('category_id', 'like', '%' . $subcategoriafil . '%')
      ->paginate(12);
      //dd($products);
   $total = $this->total();
   $subtotal = $this->subtotal();
   $carousel = DB::table('contents')
   ->join('carousel','contents.id','=','carousel.content_id')
   ->get();
   $carouselimg = DB::table('carousel_image')->get();
   $filtros = DB::table('categoriessd')->get();
   $subcategoria = DB::table('categoriapro')->get();
   $parametro = DB::table('parametro')->get();
   $autor = DB::table('autor')->get();
   $area = DB::table('areas')->get();
   $selectores = DB::table('selectors')->get();
   $eventodig = DB::table('tipo_evento')->get();  
   $venta = DB::table('venta')->get();  
   $colors = DB::table('colors')->get();  
   $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
     //dd($arr_ip);
     $ip = $arr_ip['ip'];

     $ciudad = $arr_ip['city'];
        
     $pais = $arr_ip['country'];
     $blogfoot = Bloguero::inRandomOrder()->take(6)->get();
     $empleos = Empleo::join('contents','contents.id','=','empleos.content_id')
    ->orderBy('position','ASC')
    ->where('contents.page_id', '=' ,$user->id)
    ->get();

    if($resp == 'true'){
   return view('desing')->with('contenido', $contenido)->with('contenidona', $contenidona)->with('contenidonu', $contenidonu)->with('contenidonus', $contenidonu)->with('menu', $menu)->with('galeria', $contenida)->with('mascar', $contenido)->with('pasto', $contenido)->with('casual', $contenido)->with('plantilla', $plantilla)->with('plantillaes', $plantillaes)->with('meta', $meta)->with('contenidu', $contenido)->with('paginations', $paginations)->with('fichones', $fichones)->with('contenidonumas', $contenidonumas)->with('cama', $cama)->with('banners', $banners)->with('bannersback', $bannersback)->with('selectores', $selectores)->with('cart', $cart)->with('products', $products)->with('productsa', $productsa)->with('productse', $productse)->with('total', $total)->with('subtotal', $subtotal)->with('diagramas', $diagramas)->with('subcategoria', $subcategoria)->with('autor', $autor)->with('parametro', $parametro)->with('area', $area)->with('stock', $stock)->with('filtros', $filtros)->with('eventodig', $eventodig)->with('eventos', $eventos)->with('totaleventos', $totaleventos)->with('colors', $colors)->with('ip', $ip)->with('ciudad', $ciudad)->with('pais', $pais)->with('carousel', $carousel)->with('carouselimg', $carouselimg)->with('blogfoot', $blogfoot)->with('empleos', $empleos)->with('terminos', $terminos)->with('categories', $categories)->with('formulario', $formulario);
    }else{
      dd('No ha pagado');
     }
    }

    }

    public function paginas($page){

   $planessaas = DB::table('planes')->get();
   if(!$this->tenantName){
     $plantilla = Template::all();
	 $plantillaes = Template::all();
	 $post = Page::where('slug','=',$page)->first();
	 $meta = Page::where('slug','=',$page)->get();
	 $menu = Page::whereNull('page_id')->orderBy('posta', 'asc')->get();
	 $masa = DB::table('pages')->count('page_id');
	 $cama = Page::find($post->id);

	 $filtros = DB::table('categoriessd')->get();
	 $productsa = Product::inRandomOrder()->get();

	 $stock = DB::table('products')
      //->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
      //->select(DB::raw('SUM(quantity) as cantidad'),DB::raw('(products.id) as product'),DB::raw('(product_id) as productse'))
      //->groupBy('products.id')
      ->get();
    

	 $diagramas = Diagrama::where('id',"=",$post->id)->get();
	 $fichones = Page::find($post->id)->Fichas()->orderBy(DB::raw('RAND()'))->paginate(6, ['*'], 'fichones');
	 
   $contenido = Content::where('page_id',"=",$post->id)
      /*->where('template',"=",$temaweb->template)*/
      ->orderBy('nivel','ASC')
      ->get();

	 $banners = Page::find($post->id)->Banners()->orderByRaw("RAND()")->take(1)->get();
	$terminos = \DigitalsiteSaaS\Pagina\Template::all();
$categories = Pais::all();
	 $bannersback = Page::find($post->id)->Banners()->orderByRaw("RAND()")->take(1)->get();
	 $contenidona = Maxo::join('contents','contents.id','=','collapse.content_id')
	  ->orderBy('position','ASC')
	  ->where('contents.page_id', '=' ,$post->id)->get();
     $contenidonu = Maxu::join('contents','contents.id','=','tabs.content_id')
	  ->orderBy('position','ASC')
	  ->where('contents.page_id', '=' ,$post->id)
	  ->get();

    $formulario = Formu::join('contents','inputs.content_id','=','contents.id')
    ->select('inputs.*', 'inputs.id')
    ->orderBy('id','ASC')
    ->where('contents.page_id', '=' ,$post->id)->get();

	  $empleos = Empleo::join('contents','contents.id','=','empleos.content_id')
	  ->orderBy('position','ASC')
	  ->where('contents.page_id', '=' ,$post->id)
	  ->get();
	 $contenidonumas = DB::table('ficha')->where('responsive', $post->id)->orderBy(DB::raw('RAND()'))->paginate(6, ['*'], 'contenidonumas');

   
     $paginations = Page::find($post->id)->Blogs()->paginate(9);
	 $contenida = Maxi::join('contents','contents.id','=','images.content_id')
	  ->orderBy('position','ASC')
	  ->where('contents.page_id', '=' ,$post->id)->get();
    
     $eventos = DB::table('events')->where('start_old', '>', date('m/d/Y'))->orderBy('start_old', 'asc')->take(3)->get();
     $start =  session()->get('start') ? session()->get('start') : 0;
	 $end = session()->get('end') ? session()->get('end') : 100000000000000;
	 $tipo = session()->get('tipo');
	 $totaleventos = DB::table('events')
	  ->whereBetween('start_old', array($start, $end))
	  ->where('class', 'like', '%' . $tipo . '%')
	  ->get();
     $cart = session()->get('cart');
	 $min_price = Input::has('min_price') ? Input::get('min_price') : 0;
     $max_price = Input::has('max_price') ? Input::get('max_price') : 10000000;
     $clientes =  session()->get('clientes');
     $bustext =  session()->get('bustext');
     $areafil = session()->get('area');
     $parametrofil = session()->get('parametro');
     $autorfil = session()->get('autor');
     $subcategoriafil = session()->get('subcategoria');
     if(DB::table('venta')->where('id', '1')->value('comunidad') == 1)
	 $products = DB::table('products')
      ->whereBetween('precio', array($min_price, $max_price))
      ->where('category_id', 'like', '%' . $clientes . '%')
      ->where('parametro_id', 'like', '%' . $parametrofil . '%')
      ->where('autor_id', 'like', '%' . $autorfil . '%')
      ->where('categoriapro_id', 'like', '%' . $subcategoriafil . '%')
      ->where('name','like','%'.$bustext.'%')->Where('description','like','%'.$bustext.'%')
      ->where('visible','=','1')
      ->orderByRaw("RAND()")
      ->paginate(12);
      else
      	 $products = DB::table('products')
      ->whereBetween('precio', array($min_price, $max_price))
      ->where('category_id', 'like', '%' . $clientes . '%')
      //->where('area_id', 'like', '%' . $areafil . '%')
      //->where('parametro_id', 'like', '%' . $parametrofil . '%')
      ->where('autor_id', 'like', '%' . $autorfil . '%')
      ->where('categoriapro_id', 'like', '%' . $subcategoriafil . '%')
      ->where('name','like','%'.$bustext.'%')->Where('description','like','%'.$bustext.'%')
      ->where('visible','=','1')
      ->orderByRaw("RAND()")
      ->paginate(12);

      //dd($products);
     $areadinamizador =  session()->get('areadina');
     $gradodinamizador = session()->get('gradodina');
     $campodinamizador = session()->get('campodina');
     $variabledinamizador = session()->get('variabledina');
     $casa =  session()->get('casa');
	  
	 
     $selectores = DB::table('selectors')->get();
	 $total = $this->total();
	 $subtotal = $this->subtotal();
	 $filtros = DB::table('categoriessd')->where('categoriapro_id','=',$subcategoriafil)->get();
	 $subcategoria = DB::table('categoriapro')->get();
	 $parametro = DB::table('parametro')->get();
	 $autor = DB::table('autor')->get();
	 $area = DB::table('areas')->get();



	 
	 
	 $eventodig = DB::table('tipo_evento')->get();
	 $carousel = DB::table('contents')
	 ->join('carousel','contents.id','=','carousel.content_id')
	 ->get();
	 $carouselimg = DB::table('carousel_image')->get();
	 $colors = DB::table('colors')->get();
	 $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
     //dd($arr_ip);
     $ip = $arr_ip['ip'];
     $ciudad = $arr_ip['city'];
     $pais = $arr_ip['country'];
     $blogfoot = Bloguero::inRandomOrder()->take(6)->get();
	 return view('desing')->with('contenido', $contenido)->with('contenidona', $contenidona)->with('contenidonu', $contenidonu)->with('contenidonus', $contenidonu)->with('menu', $menu)->with('galeria', $contenida)->with('mascar', $contenido)->with('pasto', $contenido)->with('casual', $contenido)->with('plantilla', $plantilla)->with('plantillaes', $plantillaes)->with('meta', $meta)->with('contenidu', $contenido)->with('paginations', $paginations)->with('fichones', $fichones)->with('contenidonumas', $contenidonumas)->with('cama', $cama)->with('banners', $banners)->with('bannersback', $bannersback)->with('selectores', $selectores)->with('cart', $cart)->with('products', $products)->with('productsa', $productsa)->with('clientes', $clientes)->with('total', $total)->with('subtotal', $subtotal)->with('filtros', $filtros)->with('diagramas', $diagramas)->with('subcategoria', $subcategoria)->with('autor', $autor)->with('parametro', $parametro)->with('area', $area)->with('filtros', $filtros)->with('eventos', $eventos)->with('totaleventos', $totaleventos)->with('stock', $stock)->with('eventodig', $eventodig)->with('colors', $colors)->with('ip', $ip)->with('ciudad', $ciudad)->with('pais', $pais)->with('carousel', $carousel)->with('carouselimg', $carouselimg)->with('blogfoot', $blogfoot)->with('empleos', $empleos)->with('terminos', $terminos)->with('categories', $categories)->with('planessaas', $planessaas)->with('formulario', $formulario);
	 }
      $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
  $infosaas = DB::table('tenancy.hostnames')
  ->join('tenancy.websites','websites.id','=','hostnames.website_id')
  ->where('hostnames.fqdn',  $hostname->fqdn)
  ->get();
  foreach ($infosaas as $infosaasweb) {
  $mihost =  ($infosaasweb->uuid.'.');
  $website = DB::table($mihost.'users')->get();
  $dias = date('Y-m-d');
  if($dias <=  $infosaasweb->presentacion){
  $resp = 'true';
  }else{
  $resp = 'false'; 
  }
}


    $plantilla = \DigitalsiteSaaS\Pagina\Tenant\Template::all();
   $plantillaes = \DigitalsiteSaaS\Pagina\Tenant\Template::all();
   $post = \DigitalsiteSaaS\Pagina\Tenant\Page::where('slug','=',$page)->first();
   $meta = \DigitalsiteSaaS\Pagina\Tenant\Page::where('slug','=',$page)->get();
   $menu = \DigitalsiteSaaS\Pagina\Tenant\Page::whereNull('page_id')->orderBy('posta', 'asc')->get();
   $masa = \DigitalsiteSaaS\Pagina\Tenant\Page::count('page_id');
   $cama = \DigitalsiteSaaS\Pagina\Tenant\Page::find($post->id);
  
   $filtros = DB::table('categoriessd')->get();


   $stock = DB::table('products')
      //->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
      //->select(DB::raw('SUM(quantity) as cantidad'),DB::raw('(products.id) as product'),DB::raw('(product_id) as productse'))
      //->groupBy('products.id')
      ->get();
     
  
   
   $diagramas = \DigitalsiteSaaS\Pagina\Tenant\Diagrama::where('id',"=",$post->id)->get();
   $fichones = \DigitalsiteSaaS\Pagina\Tenant\Page::find($post->id)->Fichas()->orderBy(DB::raw('RAND()'))->paginate(6, ['*'], 'fichones');
   
   $contenido = \DigitalsiteSaaS\Pagina\Tenant\Content::where('page_id',"=",$post->id)
      /*->where('template',"=",$temaweb->template)*/
      ->orderBy('nivel','ASC')
      ->get();
$productsa = \DigitalsiteSaaS\Pagina\Tenant\Product::inRandomOrder()->get();
   $banners = \DigitalsiteSaaS\Pagina\Tenant\Page::find($post->id)->Banners()->orderByRaw("RAND()")->take(1)->get();
  $terminos = \DigitalsiteSaaS\Pagina\Tenant\Template::all();
$categories = \DigitalsiteSaaS\Pagina\Tenant\Pais::all();
   $bannersback = \DigitalsiteSaaS\Pagina\Tenant\Page::find($post->id)->Banners()->orderByRaw("RAND()")->take(1)->get();
   $contenidona = \DigitalsiteSaaS\Pagina\Tenant\Maxo::join('contents','contents.id','=','collapse.content_id')
    ->orderBy('position','ASC')
    ->where('contents.page_id', '=' ,$post->id)->get();
     $contenidonu = \DigitalsiteSaaS\Pagina\Tenant\Maxu::join('contents','contents.id','=','tabs.content_id')
    ->orderBy('position','ASC')
    ->where('contents.page_id', '=' ,$post->id)
    ->get();

    $empleos = \DigitalsiteSaaS\Pagina\Tenant\Empleo::join('contents','contents.id','=','empleos.content_id')
    ->orderBy('position','ASC')
    ->where('contents.page_id', '=' ,$post->id)
    ->get();
   $contenidonumas = DB::table('ficha')->where('responsive', $post->id)->orderBy(DB::raw('RAND()'))->paginate(6, ['*'], 'contenidonumas');

    
     $paginations = \DigitalsiteSaaS\Pagina\Tenant\Page::find($post->id)->Blogs()->paginate(9);
   $contenida = \DigitalsiteSaaS\Pagina\Tenant\Maxi::join('contents','contents.id','=','images.content_id')
    ->orderBy('position','ASC')
    ->where('contents.page_id', '=' ,$post->id)->get();
   
     $eventos = DB::table('events')->where('start_old', '>', date('m/d/Y'))->orderBy('start_old', 'asc')->take(3)->get();
     $start =  session()->get('start') ? session()->get('start') : 0;
   $end = session()->get('end') ? session()->get('end') : 100000000000000;
   $tipo = session()->get('tipo');
   $totaleventos = DB::table('events')
    ->whereBetween('start_old', array($start, $end))
    ->where('class', 'like', '%' . $tipo . '%')
    ->get();
     $formulario = \DigitalsiteSaaS\Pagina\Tenant\Formu::join('contents','inputs.content_id','=','contents.id')
    ->select('inputs.*', 'inputs.id')
    ->orderBy('id','ASC')
    ->where('contents.page_id', '=' ,$post->id)->get();
     $cart = session()->get('cart');
   $min_price = Input::has('min_price') ? Input::get('min_price') : 0;
     $max_price = Input::has('max_price') ? Input::get('max_price') : 10000000;
     $clientes =  session()->get('clientes');
     $bustext =  session()->get('bustext');
     $areafil = session()->get('area');
     $parametrofil = session()->get('parametro');
     $autorfil = session()->get('autor');
     $subcategoriafil = session()->get('subcategoria');
     if(DB::table('venta')->where('id', '1')->value('comunidad') == 1)
   $products = \DigitalsiteSaaS\Pagina\Tenant\Product::whereBetween('precio', array($min_price, $max_price))
      ->where('category_id', 'like', '%' . $clientes . '%')
      ->where('parametro_id', 'like', '%' . $parametrofil . '%')
      ->where('autor_id', 'like', '%' . $autorfil . '%')
      ->where('categoriapro_id', 'like', '%' . $subcategoriafil . '%')
      ->where('name','like','%'.$bustext.'%')->Where('description','like','%'.$bustext.'%')
      ->where('visible','=','1')
      ->orderByRaw("RAND()")
      ->paginate(12);
      else
         $products =  \DigitalsiteSaaS\Pagina\Tenant\Product::whereBetween('precio', array($min_price, $max_price))
      ->where('category_id', 'like', '%' . $clientes . '%')
      //->where('area_id', 'like', '%' . $areafil . '%')
      //->where('parametro_id', 'like', '%' . $parametrofil . '%')
      ->where('autor_id', 'like', '%' . $autorfil . '%')
      ->where('categoriapro_id', 'like', '%' . $subcategoriafil . '%')
      ->where('name','like','%'.$bustext.'%')->Where('description','like','%'.$bustext.'%')
      ->where('visible','=','1')
      ->orderByRaw("RAND()")
      ->paginate(12);

      //dd($products);
     $areadinamizador =  session()->get('areadina');
     $gradodinamizador = session()->get('gradodina');
     $campodinamizador = session()->get('campodina');
     $variabledinamizador = session()->get('variabledina');
     $casa =  session()->get('casa');
    
    
  
   
     $selectores = DB::table('selectors')->get();
   $total = $this->total();
   $subtotal = $this->subtotal();
   $filtros = DB::table('categoriessd')->where('categoriapro_id','=',$subcategoriafil)->get();
   $subcategoria = DB::table('categoriapro')->get();
   $parametro = DB::table('parametro')->get();
   $autor = DB::table('autor')->get();
   $area = DB::table('areas')->get();
  
   



   
   $eventodig = DB::table('tipo_evento')->get();
   $carousel = DB::table('contents')
   ->join('carousel','contents.id','=','carousel.content_id')
   ->get();
   $carouselimg = DB::table('carousel_image')->get();
   $colors = DB::table('colors')->get();
   $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
     //dd($arr_ip);
     $ip = $arr_ip['ip'];
     $ciudad = $arr_ip['city'];
     $pais = $arr_ip['country'];
     $blogfoot = Bloguero::inRandomOrder()->take(6)->get();
     if($resp == 'true'){
   return view('desing')->with('contenido', $contenido)->with('contenidona', $contenidona)->with('contenidonu', $contenidonu)->with('contenidonus', $contenidonu)->with('menu', $menu)->with('galeria', $contenida)->with('mascar', $contenido)->with('pasto', $contenido)->with('casual', $contenido)->with('plantilla', $plantilla)->with('plantillaes', $plantillaes)->with('meta', $meta)->with('contenidu', $contenido)->with('paginations', $paginations)->with('fichones', $fichones)->with('contenidonumas', $contenidonumas)->with('cama', $cama)->with('banners', $banners)->with('bannersback', $bannersback)->with('selectores', $selectores)->with('cart', $cart)->with('products', $products)->with('productsa', $productsa)->with('clientes', $clientes)->with('total', $total)->with('subtotal', $subtotal)->with('filtros', $filtros)->with('diagramas', $diagramas)->with('subcategoria', $subcategoria)->with('autor', $autor)->with('parametro', $parametro)->with('area', $area)->with('filtros', $filtros)->with('eventos', $eventos)->with('totaleventos', $totaleventos)->with('stock', $stock)->with('eventodig', $eventodig)->with('colors', $colors)->with('ip', $ip)->with('ciudad', $ciudad)->with('pais', $pais)->with('carousel', $carousel)->with('carouselimg', $carouselimg)->with('blogfoot', $blogfoot)->with('empleos', $empleos)->with('terminos', $terminos)->with('categories', $categories)->with('formulario', $formulario);
 }else{
  dd('No ha pagaf');
 }
    }



    public function gestion($page){

    	$plantilla = Template::all();
    	$collapse = DB::table('contents')
    	->where('type','=','carousel')
    	->get();
    	$identificador = DB::table('carousel_image')->where('slug_car','=',$page)->get();
    	$menu = Page::whereNull('page_id')->orderBy('posta', 'desc')->get();
    	$gestion = DB::table('carousel_image')->where('slug_car','=',$page)->get();
    	$gestioncar = Carousel::inRandomOrder()->take(6)->get();
    	$gestioncarta = Carousel::get();
    	$colors = DB::table('colors')->get();
    	$blogfoot = Bloguero::inRandomOrder()->take(6)->get();
    	 $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
     //dd($arr_ip);
     $ip = $arr_ip['ip'];

     $ciudad = $arr_ip['city'];
        
     $pais = $arr_ip['country'];
    	return view('pagina::gestion')->with('gestion', $gestion)->with('plantilla', $plantilla)->with('menu', $menu)->with('gestioncar', $gestioncar)->with('colors', $colors)->with('collapse', $collapse)->with('blogfoot', $blogfoot)->with('ip', $ip)->with('ciudad', $ciudad)->with('pais', $pais)->with('gestioncarta', $gestioncarta)->with('identificador', $identificador);

      }


    public function ingresar(){
      if(!$this->tenantName){
	 $plantilla = \DigitalsiteSaaS\Pagina\Template::all();
	 $cart = session()->get('cart');
	 $total = $this->total();
	 $subtotal = $this->subtotal();
	 $colors = DB::table('colors')->get();
	 $menu = \DigitalsiteSaaS\Pagina\Page::whereNull('page_id')->orderBy('posta', 'asc')->get();
  }else{

       $plantilla = \DigitalsiteSaaS\Pagina\Tenant\Template::all();
   $cart = session()->get('cart');
   $total = $this->total();
   $subtotal = $this->subtotal();
   $colors = DB::table('colors')->get();
   $menu = \DigitalsiteSaaS\Pagina\Tenant\Page::whereNull('page_id')->orderBy('posta', 'asc')->get();

  }
	 return view('auth.logina')->with('plantilla', $plantilla)->with('menu', $menu)->with('cart', $cart)->with('total', $total)->with('subtotal', $subtotal)->with('colors', $colors);
  }




    public function blog($id){
	 $plantilla = Template::all();
	 $subtotal = $this->subtotal();
	 $total = $this->total();
	 $contenido = Bloguero::where('slug','=',$id)->get();	
	 $menu = Page::whereNull('page_id')->orderBy('posta', 'asc')->get();
	 $cart = session()->get('cart');
	 $colors = DB::table('colors')->get();
	 $blogfoot = Bloguero::inRandomOrder()->take(6)->get();
	 return view('pagina::blog')->with('contenido', $contenido)->with('plantilla', $plantilla)->with('menu', $menu)->with('cart', $cart)->with('subtotal', $subtotal)->with('total', $total)->with('colors', $colors)->with('blogfoot', $blogfoot);
	}

    public function crearusuario(){
	 $price = DB::table('users')->max('id');
	 $suma = $price + 1;
	 $path = public_path() . '/fichaimg/clientes/'.$suma;
	 File::makeDirectory($path, 0777, true);
	 $passwordwe = Input::get('password');
	 $remember = Input::get('_token');
     $userma = Usuario::create([
	  'compania' => Input::get('compania'),
	  'tipo_documento' => Input::get('tdocumento'),
	  'documento' => Input::get('documento'),
	  'name' => Input::get('name'),
	  'email' => Input::get('email'),
	  'phone' => Input::get('phone'),
	  'celular' => Input::get('celular'),
	  'address' => Input::get('address'),
	  'pais' => Input::get('pais'),
	  'ciudad' => Input::get('ciudad'),
	  'rol_id' => Input::get('rol'),
	  'remember_token' => Hash::make($remember),
	  'password' => Hash::make($passwordwe),
     ]);

    
    $datas = DB::table('datos')->where('id','1')->get();
     foreach ($datas as $user){
      Mail::to(Input::get('email'))
      ->bcc($user->correo)
	  ->send(new Registro($userma));
	 }
	 return Redirect('/login')->with('status', 'ok_create');
    }

    public function tempalte(){
     $file = Input::file('file');
	 $destinoPath = public_path().'/testcon';
	 $url_imagen = $file->getClientOriginalName();
	 $url = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);  
     $subir=$file->move($destinoPath,$file->getClientOriginalName());
     $zipper = new Zipper();
	 Zipper::make($url_imagen)->extractTo('test');
	 $zippera = new Zippera;
	 $zippera->nombre = $url;
	 $zippera->slug = Str::slug($zippera->nombre);
	 $zippera->save();
    }

    public function installHellovista(){
     return view('pagina::zip');
    }

    public function viola(){
	 $contenido = DB::table('templa')->get();
	 return view('pagina::zipper')->with('contenido', $contenido);
	}

    public function checkUsernameAvailability(){
     $user = DB::table('users')->where('email', Input::get('email'))->count();
      if($user > 0) {
      $isAvailable = FALSE;
     } else {
        $isAvailable = TRUE;
     }
     echo json_encode(
     array(
     'valid' => $isAvailable
     )); 
    }

    public function checkUsernameAvailabilityinput($id){
      if(!$this->tenantName){
     $user = Formu::orWhere('content_id','=', $id)->where('nombreinput', Input::get('nombreinput'))->count();
     }
     else{
       $user = \DigitalsiteSaaS\Pagina\Tenant\Formu::orWhere('content_id','=', $id)->where('nombreinput', Input::get('nombreinput'))->count();
     }
     if($user > 0){
      $isAvailable = FALSE;
     }else{
      $isAvailable = TRUE;
     }
     echo json_encode(
     array(
     'valid' => $isAvailable
     )); 
    }

    public function checkUsernameAvailabilitydocument(){
     $user = DB::table('clientes')->where('documento', Input::get('documento'))->count();
     if($user > 0) {
      $isAvailable = FALSE;
     }else{
     $isAvailable = TRUE;}
     echo json_encode(
      array(
      'valid' => $isAvailable
     )); 
    }

    public function registrara(){
	 $contenido = new Registrow;
	 $contenido->evento_id = Input::get('evento');
	 $contenido->usuario_id = Input::get('usuario');
	 $contenido->redireccion = Input::get('redireccion');
	 $contenido->save();
     return Redirect($contenido->redireccion)->with('status', 'ok_create');
	}

    public function crearmensajeinput(FormularioFormRequest $request){

       if(!$this->tenantName){
     $userma = Messagema::create([
	 'campo1' => Input::get('campo1'),
	 'campo2' => Input::get('campo2'),
	 'campo3' => Input::get('campo3'),
	 'campo4' => Input::get('campo4'),
	 'campo5' => Input::get('campo5'),
	 'campo6' => Input::get('campo6'),
	 'campo7' => Input::get('campo7'),
	 'campo8' => Input::get('campo8'),
	 'campo9' => Input::get('campo9'),
	 'campo10' => Input::get('campo10'),
	 'campo11' => Input::get('campo11'),
	 'campo12' => Input::get('campo12'),
	 'campo13' => Input::get('campo13'),
	 'campo14' => Input::get('campo14'),
	 'campo15' => Input::get('campo15'),
	 'campo16' => Input::get('campo16'),
	 'campo17' => Input::get('campo17'),
	 'campo18' => Input::get('campo18'),
	 'campo19' => Input::get('campo19'),
	 'campo20' => Input::get('campo20'),
	 'form_id' => Input::get('form_id'),
	 'email' => Input::get('email'),
	 'radio' => Input::get('radio'),
	 'estado' => '0',
	 'remember_token' => Hash::make('_token'),
     ]);

      $envio =  Input::get('form_id');
     $redireccion = Input::get('redireccion');
     $ema = Input::get('email');
      if($ema == ''){
      return Redirect::to($redireccion)->with('status', 'ok_create');
     }
     else{
      $datas = Content::where('id',$envio)->get();
       foreach ($datas as $user){
       Mail::to(Input::get('email'))
       ->bcc($user->video)
     ->send(new Mensajema($userma));
     }
     return Redirect::to($redireccion)->with('status', 'ok_create');
   }
    }

         $userma = \DigitalsiteSaaS\Pagina\Tenant\Messagema::create([
   'campo1' => Input::get('campo1'),
   'campo2' => Input::get('campo2'),
   'campo3' => Input::get('campo3'),
   'campo4' => Input::get('campo4'),
   'campo5' => Input::get('campo5'),
   'campo6' => Input::get('campo6'),
   'campo7' => Input::get('campo7'),
   'campo8' => Input::get('campo8'),
   'campo9' => Input::get('campo9'),
   'campo10' => Input::get('campo10'),
   'campo11' => Input::get('campo11'),
   'campo12' => Input::get('campo12'),
   'campo13' => Input::get('campo13'),
   'campo14' => Input::get('campo14'),
   'campo15' => Input::get('campo15'),
   'campo16' => Input::get('campo16'),
   'campo17' => Input::get('campo17'),
   'campo18' => Input::get('campo18'),
   'campo19' => Input::get('campo19'),
   'campo20' => Input::get('campo20'),
   'form_id' => Input::get('form_id'),
   'email' => Input::get('email'),
   'radio' => Input::get('radio'),
   'estado' => '0',
   'remember_token' => Hash::make('_token'),
]);
     $envio =  Input::get('form_id');
     $redireccion = Input::get('redireccion');
     $ema = Input::get('email');
      if($ema == ''){
      return Redirect::to($redireccion)->with('status', 'ok_create');
     }
     else{
      $datas =\DigitalsiteSaaS\Pagina\Tenant\Content::where('id',$envio)->get();
       foreach ($datas as $user){
       Mail::to(Input::get('email'))
       ->bcc($user->video)
     ->send(new Mensajema($userma));
     }
     return Redirect::to($redireccion)->with('status', 'ok_create');
   }
    
    }

  public function estadistica(){
    if(!$this->tenantName){
 	 $user = Ips::where('ip', Input::get('ip'))->first();
    }else{
    $user = \DigitalsiteSaaS\Pagina\Tenant\Ips::where('ip', Input::get('ip'))->first();
    }	
 	 if ($user){} else{
   if(!$this->tenantName){
   $pagina = new Estadistica;
   }else{
   $pagina = new \DigitalsiteSaaS\Pagina\Tenant\Estadistica;
   }
	 $pagina->ip = Input::get('ip');
	 $pagina->host = Input::get('host');
	 $pagina->navegador = Input::get('navegador');
	 $pagina->referido = Input::get('referido');
	 $pagina->ciudad = Input::get('ciudad');
	 $pagina->pais = Input::get('pais');
	 $pagina->pagina = Input::get('pagina');
	 $pagina->mes = Input::get('mes');
	 $pagina->ano = Input::get('ano');
	 $pagina->hora = Input::get('hora');
	 $pagina->dia = Input::get('dia');
	 $pagina->idioma = Input::get('idioma');
	 $pagina->cp = Input::get('cp');
	 $pagina->longitud = Input::get('longitud');
	 $pagina->latitud = Input::get('latitud');
	 $pagina->fecha = Input::get('fecha');
	 $pagina->cp = Input::get('meses');
	 $pagina->remember_token = Input::get('_token');
	 $pagina->save();
     $redireccion = Input::get('redireccion');
     return Redirect::to($redireccion)->with('status', 'ok_create');
    }
   }
  }