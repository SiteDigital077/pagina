<?php

 namespace DigitalsiteSaaS\Pagina\Http;
 use DigitalsiteSaaS\Pagina\Page;
 use DigitalsiteSaaS\Pagina\Registro;
 use DigitalsiteSaaS\Pagina\Maxi;
 use DigitalsiteSaaS\Pagina\Maxicar;
 use DigitalsiteSaaS\Pagina\Maxo;
 use DigitalsiteSaaS\Pagina\Maxu;
 use DigitalsiteSaaS\Pagina\Maxe;
 use DigitalsiteSaaS\Pagina\Conte;
 use DigitalsiteSaaS\Pagina\Baner;
 use DigitalsiteSaaS\Pagina\Formu;
 use DigitalsiteSaaS\Pagina\Date;
 use DigitalsiteSaaS\Pagina\Bloguero;
 use DigitalsiteSaaS\Pagina\Venta;
 use DigitalsiteSaaS\Pagina\Select;
 use DigitalsiteSaaS\Pagina\Content;
 use DigitalsiteSaaS\Pagina\Template;
 use DigitalsiteSaaS\Pagina\Message;
 use DigitalsiteSaaS\Pagina\Muxu;
 use DigitalsiteSaaS\Pagina\Diagrama;
 use DigitalsiteSaaS\Pagina\Carousel;
 use DigitalsiteSaaS\Pagina\Empleo;
 use DigitalsiteSaaS\Pagina\Shuffleweb;
 use App\Http\Requests\FichaCreateRequest;
 use App\Http\Requests\FichaUpdateRequest;
 use App\Http\Requests\FichaUpdateimgRequest;
 use DB;
 use Auth;
 use Hash;
 use App\Http\Controllers\Controller;
 use Input;
 use Illuminate\Support\Str;
 use Illuminate\Http\Request;
 use Hyn\Tenancy\Models\Hostname;
 use Hyn\Tenancy\Models\Website;
 use Hyn\Tenancy\Repositories\HostnameRepository;
 use Hyn\Tenancy\Repositories\WebsiteRepository;

 class ContenidoController extends Controller{

    protected $tenantName = null;

 public function __construct(){
  $this->middleware('auth');

  $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
        if ($hostname){
            $fqdn = $hostname->fqdn;
            $this->tenantName = explode(".", $fqdn)[0];
        }
        dd($this->tenantName);
 }

 public function index(){
  $contenido = Content::all();
  return View('pagina::contenidos')->with('contenido', $contenido);
 }

 public function digitales($id){
  $master = Page::find($id);
  $contenido = Page::find($id)->Contents;
  $banners = Page::find($id)->Contents;

  $paginations = Page::find($id)->Blogs;
  $collapses = Page::find($id)->Contents;
  $carousel = Page::find($id)->Contents;
  $tabs = Page::find($id)->Contents;
  $shuffle = Page::find($id)->Contents;
  $formula = Page::find($id)->Contents;
  return view('pagina::contenidos')->with('contenido', $contenido)->with('galeria', $contenido)->with('master', $master)->with('paginations', $paginations)->with('collapses', $collapses)->with('tabs', $tabs)->with('shuffle', $shuffle)->with('banners', $banners)->with('formula', $formula)->with('carousel', $carousel);
 }

 public function diagrama($id){
  $diagramacion = DB::table('diagramas')->where('id', '=', $id)->get();
  return view('pagina::diagramas')->with('diagramacion', $diagramacion);
 }

 public function graficos($id){
  $contenido = Page::find($id);
  return view('pagina::crear-contenido')->with('contenido', $contenido);
 }

 public function creargrafico(){
  $notaweb = Input::get('tagsa');
  $data = json_encode($notaweb, true);
  $vowels = array('"', '[', ']');
  $onlyconsonants = str_replace($vowels, '', $data);
  $contenido = new Content;
  $contenido->title = Input::get('titulo');
  $contenido->slugcon = Str::slug($contenido->title);
  $contenido->description = Input::get('descripcion');
  $contenido->content = Input::get('contenido');
  $contenido->contents = Input::get('contenidos');
  $contenido->position = Input::get('posicion');
  $contenido->level = Input::get('nivel');
  $contenido->video = Input::get('video');
  $contenido->responsive = Input::get('responsive');
  $contenido->animacion = Input::get('animacion');
  $contenido->image = Input::get('FilePath');
  $contenido->imageal = Input::get('imageal');
  $contenido->url = Input::get('enlace');
  if($onlyconsonants == 'null'){
  $contenido->roles_id = Auth::user()->id;
  }
  else{
  $contenido->roles_id = $onlyconsonants;
  }
  $contenido->type = Input::get('tipo');
  $contenido->num = Input::get('num');
  $contenido->page_id = Input::get('peca');
  $contenido->template = Input::get('template');
  $contenido->nivel = Input::get('nivelpos');
  $contenido->save();
  return Redirect('gestion/contenidos/digitales/'.$contenido->page_id)->with('status', 'ok_create');
 }

 public function crearinput(){
  $contenido = new Formu;
  $contenido->tipo = Input::get('tipo');
  $contenido->nombre = Input::get('nombre');
  $contenido->content_id = Input::get('content_id');
  $contenido->respon = Input::get('responsive');
  $contenido->nombreinput = Input::get('nombreinput');
  $contenido->requerido = Input::get('requerido');
  $contenido->save();
  return Redirect('gestion/contenidos/camposformulario/'.$contenido->content_id)->with('status', 'ok_create');
 }

 public function registrar(){
  $contenido = new Registro;
  $contenido->evento_id = Input::get('evento');
  $contenido->usuario_id = Input::get('usuario');
  $contenido->redireccion = Input::get('redireccion');
  $contenido->save();
  return Redirect('gestion/calendario/'.$contenido->redireccion)->with('status', 'ok_create');
 }

 public function crearselector(){
  $contenido = new Select;
  $contenido->nombre = Input::get('nombre');
  $contenido->input_id = Input::get('input_id');
  $contenido->save();
  return Redirect('gestion/contenidos/selectores/'.$contenido->input_id)->with('status', 'ok_create');
 }

 public function crearbaner(){
  $contenido = new Baner;
  $contenido->nombre = Input::get('nombre');
  $contenido->url_imagen = Input::get('FilePath');
  $contenido->empresa = Input::get('empresa');
  $contenido->page_id = Input::get('peca');
  $contenido->impresiones = Input::get('impresiones');
  $contenido->clics = Input::get('clics');
  $contenido->visitas = Input::get('visitas');
  $contenido->position = Input::get('position');
  $contenido->destino = Input::get('destino');
  $contenido->type = Input::get('tipo');
  $contenido->responsive = Input::get('responsive');
  $contenido->save();
  return Redirect('gestion/contenidos/digitales/'.$contenido->page_id)->with('status', 'ok_create');
 }

 public function editar($id){
  $contenido = Content::find($id);
  $roles = DB::table('roles_comunidad')->get();
  $notador = DB::table('contents')->where('id','=',$id)->get();
   foreach ($notador as $notadores){
    $ideman = $notadores->roles_id;
    $id_str = explode(',', $ideman);
    $rols = DB::table('roles_comunidad')->whereIn('id', $id_str)->get();
   }
  $notas = DB::table('contents')
   ->join('categoria_comunidades', 'contents.contents', '=', 'categoria_comunidades.id')
   ->where('contents.id', '=' ,$id)->get();
  $posicion = DB::table('posicion')->pluck('posicion');
  $categoria = DB::table('categoria_comunidades')->where('webtipodev','=','1')->get();
  $categoriadina = DB::table('categoria_comunidades')->where('webtipodev','=','2')->get();
  return view('pagina::editar-contenido')->with('contenido', $contenido)->with('posicion', $posicion)->with('categoria', $categoria)->with('categoriadina', $categoriadina)->with('notas', $notas)->with('notador', $notador)->with('roles', $roles)->with('rols', $rols);
 }

 public function editarbanner($id){
  $banners = Baner::find($id);
  return view('pagina::editar-baner')->with('banners', $banners);
 }

 public function actualizar($id){
  $notaweb = Input::get('tagsa');
  $data = json_encode($notaweb, true);
  $vowels = array('"', '[', ']');
  $onlyconsonants = str_replace($vowels, '', $data);
  $input = Input::all();
  $contenido = Content::find($id);
  $contenido->title = Input::get('titulo');
  $contenido->slugcon = Str::slug($contenido->title);
  $contenido->description = Input::get('descripcion');
  $contenido->content = Input::get('contenido');
  $contenido->contents = Input::get('contenidos');
  $contenido->position = Input::get('posicion');
  $contenido->image = Input::get('FilePath');
  $contenido->imageal = Input::get('imageal');
  $contenido->video = Input::get('video');
  $contenido->responsive = Input::get('responsive');
  $contenido->animacion = Input::get('animacion');
  $contenido->url = Input::get('enlace');
  if($onlyconsonants == 'null'){
  $contenido->roles_id = Auth::user()->id;;
  }
  else{
  $contenido->roles_id = $onlyconsonants;
  }
  $contenido->type = Input::get('tipo');
  $contenido->level = Input::get('nivel');
  $contenido->nivel = Input::get('nivelpos');
  $contenido->template = Input::get('template');
  $contenido->save();
  return Redirect('gestion/contenidos/digitales/'.$contenido->page_id)->with('status', 'ok_update');
 }

 public function creardiagrama(){
  $pagina = new Diagrama;
  $pagina->posicionSD1 = Input::get('posicionsd1');
  $pagina->posicionSD2 = Input::get('posicionsd2');
  $pagina->posicionSD3 = Input::get('posicionsd3');
  $pagina->posicionSD4 = Input::get('posicionsd4');
  $pagina->posicionSD5 = Input::get('posicionsd5');
  $pagina->posicionSD6 = Input::get('posicionsd6');
  $pagina->posicionSD7 = Input::get('posicionsd7');
  $pagina->posicionSD8 = Input::get('posicionsd8');
  $pagina->posicionSD9 = Input::get('posicionsd9');
  $pagina->posicionSD01 = Input::get('posicionsd01');
  $pagina->posicionSD02 = Input::get('posicionsd02');
  $pagina->page_id = Input::get('page');
  $pagina->save();
  return Redirect('gestion/paginas')->with('status', 'ok_create');
 }

 public function actualizardiagrama($id){
  $input = Input::all();
  $pagina = Diagrama::find($id);
  $pagina->posicionSD01 = Input::get('posicionsd01');
  $pagina->posicionSD1 = Input::get('posicionsd1');
  $pagina->posicionSD2 = Input::get('posicionsd2');
  $pagina->posicionSD02 = Input::get('posicionsd02');
  $pagina->posicionSD3 = Input::get('posicionsd3');
  $pagina->bloque = Input::get('bloque');
  $pagina->posicionSD4 = Input::get('posicionsd4');
  $pagina->posicionSD5 = Input::get('posicionsd5');
  $pagina->posicionSD6 = Input::get('posicionsd6');
  $pagina->posicionSD7 = Input::get('posicionsd7');
  $pagina->posicionSD8 = Input::get('posicionsd8');
  $pagina->posicionSD9 = Input::get('posicionsd9');
  $pagina->bloqueblog = Input::get('bloqueblog');
  $pagina->posicionSD03 = Input::get('posicionsd03');
  $pagina->bloqueficha1 = Input::get('bloqueficha1');
  $pagina->bloqueficha2 = Input::get('bloqueficha2');
  $pagina->bloqueSD1 = Input::get('bloquesd1');
  $pagina->bloqueSD2 = Input::get('bloquesd2');
  $pagina->bloqueSD3 = Input::get('bloquesd3');
  $pagina->bloqueSD4 = Input::get('bloquesd4');
  $pagina->bloqueSD5 = Input::get('bloquesd5');
  $pagina->bloqueSD6 = Input::get('bloquesd6');
  $pagina->bloqueSD7 = Input::get('bloquesd7');
  $pagina->bloqueSD8 = Input::get('bloquesd8');
  $pagina->bloqueSD9 = Input::get('bloquesd9');
  $pagina->save();
  return Redirect('gestion/paginas')->with('status', 'ok_create');
 }

 public function actualizarbanner($id){
  $input = Input::all();
  $contenido = Baner::find($id);
  $contenido->nombre = Input::get('nombre');
  $contenido->url_imagen = Input::get('FilePath');
  $contenido->empresa = Input::get('empresa');
  $contenido->page_id = Input::get('peca');
  $contenido->impresiones = Input::get('impresiones');
  $contenido->clics = Input::get('clics');
  $contenido->visitas = Input::get('visitas');
  $contenido->position = Input::get('position');
  $contenido->destino = Input::get('destino');
  $contenido->page_id = Input::get('page_id');
  $contenido->type = Input::get('tipo');
  $contenido->responsive = Input::get('responsive');
  $contenido->save();
  return Redirect('gestion/contenidos/digitales/'.$contenido->page_id)->with('status', 'ok_create');
 }

 public function eliminar($id){
  $contenido = Content::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/digitales/'.$contenido->page_id)->with('status', 'ok_delete');
 }

 public function crearblog(){
  $contenido = new Bloguero;
  $contenido->title = Input::get('titulo');
  $contenido->slug = Str::slug($contenido->title);
  $contenido->description = Input::get('descripcion');
  $contenido->content = Input::get('contenido');
  $contenido->position = Input::get('posicion');
  $contenido->level = Input::get('nivel');
  $contenido->responsive = Input::get('responsive');
  $contenido->image = Input::get('FilePath');
  $contenido->imageal = Input::get('imageal');
  $contenido->url = Input::get('enlace');
  $contenido->type = Input::get('tipo');
  $contenido->num = Input::get('num');
  $contenido->page_id = Input::get('peca');
  $contenido->save();
  return Redirect('gestion/contenidos/digitales/'.$contenido->page_id)->with('status', 'ok_create');
 }

 public function creargaleria(){
  $contenido = new Maxi;
  $contenido->titlesd = Input::get('titulo');
  $contenido->imagesd = Input::get('FilePath');
  $contenido->descriptionsd = Input::get('descripcion');
  $contenido->contentsd = Input::get('contenido');
  $contenido->state = Input::get('estado');
  $contenido->animacionsd = Input::get('animacion');
  $contenido->urlsd = Input::get('url');
  $contenido->boton = Input::get('boton');
  $contenido->urlsduno = Input::get('urluno');
  $contenido->botonuno = Input::get('botonuno');
  $contenido->content_id = Input::get('id');
  $contenido->save();
  return Redirect('gestion/contenidos/imagenesgaleria/'.$contenido->content_id)->with('status', 'ok_create');
 }


  public function crearcarouselimgslide(){
  $contenido = new Maxicar;
  $contenido->titulo_ca = Input::get('titulo');
  $contenido->descripcion_ca = Input::get('descripcion');
  $contenido->estado = Input::get('estado');
  $contenido->content_id = Input::get('content_id');
  $contenido->save();
  return Redirect('gestion/contenidos/imagenescarousel/'.$contenido->content_id)->with('status', 'ok_create');
 }

  public function crearcarouselimg(){
  $contenido = new Carousel;
  $contenido->imagen_car = Input::get('FilePath');
  $contenido->titulo_car = Input::get('titulo');
  $contenido->descripcionweb_car = Input::get('descripcionweb');
  $contenido->slug_car =  Str::slug($contenido->titulo_car);
  $contenido->descripcion_car = Input::get('descripcion');
  $contenido->url_car = Input::get('url');
  $contenido->content_id = Input::get('content_id');
  $contenido->page_id = Input::get('page_id');
  $contenido->save();
  return Redirect('gestion/contenidos/imagenescarousel/'.$contenido->content_id)->with('status', 'ok_create');
 }


 public function crearshufflemen(){
  $contenido = new Shuffleweb;
  $contenido->categoria = Input::get('categoria');
  $contenido->categoria_slug = Str::slug($contenido->categoria);
  $contenido->content_id = Input::get('identificador');
  $contenido->save();
  return Redirect('gestion/contenidos/shuffle-menu/'.$contenido->content_id)->with('status', 'ok_create');
 }

 public function crearcollapse(){
  $contenido = new Maxo;
  $contenido->titlecl = Input::get('titulo');
  $contenido->slug = Str::slug($contenido->titlecl);
  $contenido->descriptioncl = Input::get('descripcion');
  $contenido->contentcl = Input::get('contentcl');
  $contenido->state = Input::get('state');
  $contenido->content_id = Input::get('id');
  $contenido->save();
  return Redirect('gestion/contenidos/subcollapse/'.$contenido->content_id)->with('status', 'ok_create');
 }

 public function creartab(){
  $contenido = new Maxu;
  $contenido->titlecl = Input::get('titlecl');
  $contenido->slug = Str::slug($contenido->titlecl);
  $contenido->descriptioncl = Input::get('descriptioncl');
  $contenido->contentcl = Input::get('contentcl');
  $contenido->posicion = Input::get('posicion');
  $contenido->urlsd = Input::get('enlace');
  $contenido->imagecl = Input::get('FilePath');
  $contenido->state = Input::get('state');
  $contenido->content_id = Input::get('id');
  $contenido->save();
  return Redirect('gestion/contenidos/subtab/'.$contenido->content_id)->with('status', 'ok_create');
 }

  public function crearempleo(){
  $contenido = new Empleo;
  $contenido->titulo_emp = Input::get('titulo');
  $contenido->titulo_empslug = Str::slug($contenido->titulo_emp);
  $contenido->descripcion_emp = Input::get('descripcion');;
  $contenido->requisitos_emp = Input::get('requisito');
  $contenido->area_emp = Input::get('area');
  $contenido->nivel_emp = Input::get('nivel');
  $contenido->ciudad_emp = Input::get('ciudad');
  $contenido->salario_emp = Input::get('salario');
  $contenido->fecha_emp = Input::get('fecha');
  $contenido->content_id = Input::get('id');
  $contenido->save();
  return Redirect('gestion/contenidos/subempleo/'.$contenido->content_id)->with('status', 'ok_create');
 }

 public function crearshuffle(){
  $contenido = new Maxe;
  $contenido->titlecl = Input::get('titlecl');
  $contenido->descriptioncl = Input::get('descriptioncl');
  $contenido->imagealcl = Input::get('FilePath');
  $contenido->shuffle_id = Input::get('shuffleid');
  $contenido->shuffleid = Input::get('shufflewebsite');
  $contenido->save();
  return Redirect('gestion/contenidos/shuffle-crear/'.$contenido->shuffle_id)->with('status', 'ok_create');
 }
	
 public function actualizarblog($id){
  $input = Input::all();
  $contenido = Bloguero::find($id);
  $contenido->title = Input::get('titulo');
  $contenido->description = Input::get('descripcion');
  $contenido->content = Input::get('contenido');
  $contenido->position = Input::get('posicion');
  $contenido->level = Input::get('nivel');
  $contenido->responsive = Input::get('responsive');
  $contenido->animacion = Input::get('animacion');
  $contenido->image = Input::get('FilePath');
  $contenido->imageal = Input::get('imageal');
  $contenido->url = Input::get('enlace');
  $contenido->type = Input::get('tipo');
  $contenido->num = Input::get('num');
  $contenido->page_id = Input::get('peca');
  $contenido->save();
  return Redirect('gestion/contenidos/digitales/'.$contenido->page_id)->with('status', 'ok_update');
 }

 public function editarshufflemen($id){
  $sinslug = Input::get('categoria');
  $conslug = Str::slug($sinslug);
  $editar = DB::table('shuffle')
   ->where('shuffleid','=',$id)
   ->update(array('shuffle_id' => $conslug));
  $input = Input::all();
  $contenido = Shuffleweb::find($id);
  $contenido->categoria = Input::get('categoria');
  $contenido->categoria_slug = Str::slug($contenido->categoria);
  $contenido->content_id = Input::get('identificador');
  $contenido->save();
  return Redirect('gestion/contenidos/shuffle-menu/'.$contenido->content_id)->with('status', 'ok_update');
 }

 public function actualizargaleria($id){
  $input = Input::all();
  $contenido = Maxi::find($id);
  $contenido->state = Input::get('estado');
  $contenido->titlesd = Input::get('titulo');
  $contenido->imagesd = Input::get('FilePath');
  $contenido->descriptionsd = Input::get('descripcion');
  $contenido->animacionsd = Input::get('animacion');
  $contenido->contentsd = Input::get('contenido');
  $contenido->urlsd = Input::get('url');
  $contenido->boton = Input::get('boton');
  $contenido->urlsduno = Input::get('urluno');
  $contenido->botonuno = Input::get('botonuno');
  $contenido->save();
  return Redirect('gestion/contenidos/imagenesgaleria/'.$contenido->content_id)->with('status', 'ok_update');
 }

  public function actualizarcarousel($id){
  $input = Input::all();
  $contenido = Maxicar::find($id);
  $contenido->estado = Input::get('estado');
  $contenido->titulo_ca = Input::get('titulo');
  $contenido->descripcion_ca= Input::get('descripcion');
  $contenido->content_id = Input::get('content_id');
  $contenido->save();
  return Redirect('gestion/contenidos/imagenescarousel/'.$contenido->content_id)->with('status', 'ok_update');
 }


 public function actualizarcarouselimg($id){
  $input = Input::all();
  $contenido = Carousel::find($id);
  $contenido->titulo_car = Input::get('titulo');
  $contenido->slug_car =  Str::slug($contenido->titulo_car);
  $contenido->descripcionweb_car = Input::get('descripcionweb');
  $contenido->imagen_car = Input::get('FilePath');
  $contenido->descripcion_car = Input::get('descripcion');
  $contenido->url_car = Input::get('url');
  $contenido->content_id = Input::get('content_id');
  $contenido->page_id = Input::get('page_id');
  $contenido->save();
  return Redirect('/gestion/contenidos/imagenescarousel/'.$contenido->content_id)->with('status', 'ok_update');
 }



 
 public function actualizarinput($id){
  $input = Input::all();
  $contenido = Formu::find($id);
  $contenido->tipo = Input::get('tipo');
  $contenido->nombre = Input::get('nombre');
  $contenido->respon = Input::get('responsive');
  $contenido->nombreinput = Input::get('nombreinput');
  $contenido->requerido = Input::get('requerido');
  $contenido->save();
  return Redirect('gestion/contenidos/camposformulario/'.$contenido->content_id)->with('status', 'ok_update');
 }

 public function actualizarselector($id){
  $input = Input::all();
  $contenido = Select::find($id);
  $contenido->nombre = Input::get('nombre');
  $contenido->input_id = Input::get('input_id');
  $contenido->save();
  return Redirect('/gestion/contenidos/selectores/'.$contenido->input_id)->with('status', 'ok_update');
 }

 public function actualizarcollapse($id){
  $input = Input::all();
  $contenido = Maxo::find($id);
  $contenido->titlecl = Input::get('titulo');
  $contenido->slug = Str::slug($contenido->titlecl);
  $contenido->state = Input::get('state');
  $contenido->contentcl = Input::get('contentcl');
  $contenido->descriptioncl = Input::get('descripcion');
  $contenido->save();
  return Redirect('gestion/contenidos/subcollapse/'.$contenido->content_id)->with('status', 'ok_update');
 }

 public function actualizartab($id){
  $input = Input::all();
  $contenido = Maxu::find($id);
  $contenido->state = Input::get('state');
  $contenido->titlecl = Input::get('titlecl');
  $contenido->slug = Str::slug($contenido->titlecl);
  $contenido->contentcl = Input::get('contentcl');
  $contenido->posicion = Input::get('posicion');
  $contenido->urlsd = Input::get('enlace');
  $contenido->imagecl = Input::get('FilePath');
  $contenido->descriptioncl = Input::get('descriptioncl');
  $contenido->save();
  return Redirect('gestion/contenidos/subtab/'.$contenido->content_id)->with('status', 'ok_update');
 }

  public function actualizarempleo($id){
  $input = Input::all();
  $contenido = Empleo::find($id);
  $contenido->titulo_emp = Input::get('titulo');
  $contenido->titulo_empslug = Str::slug($contenido->titulo_emp);
  $contenido->descripcion_emp = Input::get('descripcion');;
  $contenido->requisitos_emp = Input::get('requisito');
  $contenido->area_emp = Input::get('area');
  $contenido->nivel_emp = Input::get('nivel');
  $contenido->ciudad_emp = Input::get('ciudad');
  $contenido->salario_emp = Input::get('salario');
  $contenido->fecha_emp = Input::get('fecha');
  $contenido->content_id = Input::get('id');
  $contenido->save();
  return Redirect('gestion/contenidos/subempleo/'.$contenido->content_id)->with('status', 'ok_update');
 }


 public function actualizarshuffle($id){
  $input = Input::all();
  $contenido = Maxe::find($id);
  $contenido->titlecl = Input::get('titlecl');
  $contenido->descriptioncl = Input::get('descriptioncl');
  $contenido->imagealcl = Input::get('FilePath');
  $contenido->shuffle_id = Input::get('shuffleid');
  $contenido->shuffleid = Input::get('shufflewebsite');
  $contenido->save();
  return Redirect('gestion/contenidos/shuffle-crear/'.$contenido->shuffle_id)->with('status', 'ok_update');
 }  

 public function editargaleria($id){
  $contenido = Maxi::find($id);
  return view('pagina::editar-galeria')->with('contenido', $contenido);
 }

  public function editarcarousel($id){
  $contenido = Maxicar::find($id);
  return view('pagina::editar-carousel')->with('contenido', $contenido);
 }

   public function editarcarouselimg($id){
  $contenido = Carousel::find($id);
  return view('pagina::editar-carouselimg')->with('contenido', $contenido);
 }

 public function editarinput($id){
  $contenido = DB::table('inputs')->where('id','=',$id)->get();
  return view('pagina::editar-input')->with('contenido', $contenido);
 }

 public function editarselector($id){
  $contenido = Select::find($id);
  return view('pagina::editar-selector')->with('contenido', $contenido);
 }

 public function editarcollapse($id){
  $contenido = Maxo::find($id);
  return view('pagina::editar-collapse')->with('contenido', $contenido);
 }

 public function editartab($id){
  $contenido = Maxu::find($id);
  return view('pagina::editar-tabs')->with('contenido', $contenido);
 }

public function editarempleo($id){
  $contenido = DB::table('empleos')->where('id','=', $id)->get();
  return view('pagina::editar-empleo')->with('contenido', $contenido);
 }

 public function editarshuffle($id){
  $contenido = Maxe::find($id);
  return view('pagina::editar-shuffle')->with('contenido', $contenido);
 }

 public function editarblog($id){
  $contenido = Bloguero::find($id);
  return View('pagina::editar-blog')->with('contenido', $contenido);
 }

 public function eliminarblog($id){
  $contenido = Bloguero::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/digitales/'.$contenido->page_id)->with('status', 'ok_delete');
 }

 public function eliminarshufflemen($id){
  $contenido = Shuffleweb::find($id);
  $contenido->delete();
  $eliminar = DB::table('shuffle')->where('shuffle_id','=',$contenido->categoria)->delete();
		return Redirect('gestion/contenidos/shuffle-menu/'.$contenido->content_id)->with('status', 'ok_delete');
 }

 public function eliminarinput($id){
  $contenido = Formu::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/camposformulario/'.$contenido->content_id)->with('status', 'ok_delete');
 }

 public function eliminarselector($id){
  $contenido = Select::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/selectores/'.$contenido->input_id)->with('status', 'ok_delete');
 }

 public function eliminarbanner($id){
  $contenido = Baner::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/digitales/'.$contenido->page_id)->with('status', 'ok_delete');
 }

 public function eliminarshuffle($id){
  $contenido = Maxe::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/subshuffle/'.$contenido->content_id)->with('status', 'ok_delete');
 }

 public function eliminarcollapse($id){
  $contenido = Maxo::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/subcollapse/'.$contenido->content_id)->with('status', 'ok_delete');
 }

 public function eliminartab($id){
  $contenido = Maxu::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/subtab/'.$contenido->content_id)->with('status', 'ok_delete');
 }

  public function eliminarempleo($id){
  $contenido = Empleo::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/subempleo/'.$contenido->content_id)->with('status', 'ok_delete');
 }

 public function eliminargaleria($id){
  $contenido = Maxi::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/imagenesgaleria/'.$contenido->content_id)->with('status', 'ok_delete');
 }

  public function eliminarcarousel($id){
  $contenido = Maxicar::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/imagenescarousel/'.$contenido->content_id)->with('status', 'ok_delete');
 }

 public function eliminarcarouselimg($id){
  $contenido = Carousel::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/imagenescarousel/'.$contenido->content_id)->with('status', 'ok_delete');
 }

 public function eliminarcontshuffle($id){
  $contenido = Maxe::find($id);
  $contenido->delete();
  return Redirect('gestion/contenidos/shuffle-crear/'.$contenido->shuffle_id)->with('status', 'ok_delete');
 }

 public function show(){
  $roles = DB::table('pages')->orderBy('posti')->get();
  $rolesa = DB::table('pages')->orderBy('posta')->get();
  $datos = DB::table('datos')->where('id','=',1)->get();
  $datosa = DB::table('templa')->get();
  $plantilla = DB::table('template')->get();	
  $plantillaes = DB::table('template')->get();	
  return view('pagina::configurar')->with('roles', $roles)->with('rolesa', $rolesa)->with('plantilla', $plantilla)->with('plantillaes', $plantillaes)->with('datos', $datos)->with('datosa', $datosa);
 }

 public function imagenesgaleria($id){
  $contenido = Content::find($id)->Images;
  $contenida = Content::find($id)->Images;
  $conteni = Content::find($id);
  return view('pagina::modulo-galeria')->with('contenido', $contenido)->with('contenida', $contenida)->with('amour', $contenido)->with('conteni', $conteni)->with('face', $contenido);
 }


public function imagenescarousel($id){
  $contenido = Content::find($id)->Imagescar;
  $contenida = Content::find($id)->Imagescar;
  $conteni = Content::find($id);
  return view('pagina::modulo-carousel')->with('contenido', $contenido)->with('contenida', $contenida)->with('amour', $contenido)->with('conteni', $conteni)->with('face', $contenido);
 }

 public function carouselimg($id){
  $contenido = DB::table('carousel_image')->where('content_id', '=', $id)->get();
  $conteo = DB::table('carousel_image')->where('content_id', '=', $id)->count();
  return view('pagina::modulo-carouselimg')->with('amour', $contenido)->with('conteo', $conteo);
 }


 public function shufflemenu($id){
  $categorias = DB::table('shuffleweb')->where('content_id','=',$id)->get();
  return view('pagina::modulo-shuffle')->with('categorias', $categorias);
 }

 public function shufflecrear($id){
  $contenido = Content::find($id);
  $contenida = Content::find($id);
  $conteni = Content::find($id);
  $categorias = DB::table('shuffle')->where('shuffle_id','=',$id)->get();
  return view('pagina::shuffle-crear')->with('categorias', $categorias)->with('contenido', $contenido)->with('contenida', $contenida)->with('amour', $contenido)->with('conteni', $conteni)->with('face', $contenido);;
 }

 public function camposformulario($id){
  $contenido = Formu::where('content_id', '=', $id)->get();
  return view('pagina::modulo-formulario')->with('contenido', $contenido)->with('amour', $contenido)->with('face', $contenido);
 }

 public function subcollapse($id){
  $contenido = Content::find($id)->Collapses;
  $contenida = Content::find($id)->Collapses;
  $conteni = Content::find($id);
  return view('pagina::modulo-collapse')->with('contenido', $contenido)->with('contenida', $contenida)->with('amour', $contenido)->with('conteni', $conteni)->with('face', $contenido);
 }

  public function carouseledit($id){
  $contenido = Content::find($id)->Collapses;
  $contenida = Content::find($id)->Collapses;
  $conteni = Content::find($id);
  return view('pagina::modulo-carousel')->with('contenido', $contenido)->with('contenida', $contenida)->with('amour', $contenido)->with('conteni', $conteni)->with('face', $contenido);
 }

 public function subtab($id){
  $contenido = Content::find($id)->Tabs;
  $contenida = Content::find($id)->Tabs;
  $conteni = Content::find($id);
  return view('pagina::modulo-tabs')->with('contenido', $contenido)->with('contenida', $contenida)->with('amour', $contenido)->with('conteni', $conteni)->with('face', $contenido);
 }

  public function subempleo($id){
  $contenido = Content::find($id)->Empleo;
  $contenida = Content::find($id)->Empleo;
  $conteni = Content::find($id);
  return view('pagina::modulo-empleo')->with('contenido', $contenido)->with('contenida', $contenida)->with('amour', $contenido)->with('conteni', $conteni)->with('face', $contenido);
 }

 public function subshuffle($id){
  $contenido = Content::find($id)->Shuffles;
  $contenida = Content::find($id)->Shuffles;
  $conteni = Content::find($id);
  return view('pagina::modulo-shuffle')->with('contenido', $contenido)->with('contenida', $contenida)->with('amour', $contenido)->with('conteni', $conteni)->with('face', $contenido);
 }

 public function texto($id){
  $temp = DB::table('template')->where('id','=','1')->get();
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-texto')->with('posicion', $posicion)->with('temp', $temp);
 }

 public function boton($id){
  $temp = DB::table('template')->where('id','=','1')->get();
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-boton')->with('posicion', $posicion)->with('temp', $temp);
 }

 public function ficha($id){
  $temp = DB::table('template')->where('id','=','1')->get();
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-ficha')->with('posicion', $posicion)->with('temp', $temp);
 }

 public function fichan($id){
  $temp = DB::table('template')->where('id','=','1')->get();
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-fichan')->with('posicion', $posicion)->with('temp', $temp);
 }

 public function collapse($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-collapse')->with('posicion', $posicion);
 }

 public function listas($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-listas')->with('posicion', $posicion);
 }

 public function thumbail($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-thumbail')->with('posicion', $posicion);
 }

 public function parallax($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-parallax')->with('posicion', $posicion);
 }

 public function imagenes($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-imagen')->with('posicion', $posicion);
 }

 public function blog($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-blog')->with('posicion', $posicion);
 }

 public function jumbotron($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-jumbutron')->with('posicion', $posicion);
 }

 public function mapa($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-mapa')->with('posicion', $posicion);
 }

 public function mailing($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-mailing')->with('posicion', $posicion);
 }

 public function mediaobject($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-media-object')->with('posicion', $posicion);
 }

 public function subservicios($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-subservicios')->with('posicion', $posicion);
 }

 public function clientes($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-clientes')->with('posicion', $posicion);
 }

 public function titulo($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-titulo')->with('posicion', $posicion);
 }

 public function shuffleweb($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-Shufflesub')->with('posicion', $posicion);
 }

 public function hover($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-hover')->with('posicion', $posicion);
 }

 public function video($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-video')->with('posicion', $posicion);
 }

 public function responsive($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-responsive')->with('posicion', $posicion);
 }

 public function collapsum($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-collapsum')->with('posicion', $posicion);
 }

 public function modal($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-modal')->with('posicion', $posicion);
 }

 public function galeria($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-galeria')->with('posicion', $posicion);
 }

 public function busqueda($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-busqueda')->with('posicion', $posicion);
 }

 public function filtroevento($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-filtroevento')->with('posicion', $posicion);
 }	

 public function tab($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-tabas')->with('posicion', $posicion);
 }

 public function shuffle($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-shuffle')->with('posicion', $posicion);
 }

 public function imagen($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-imagenes')->with('posicion', $posicion);
 }	

  public function imagencarou($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-imagenescarou')->with('posicion', $posicion);
 }  

  public function imagencarouslide($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-imagenescarouslide')->with('posicion', $posicion);
 }  

 public function formu($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-formu')->with('posicion', $posicion);
 }	

 public function menus($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-menu')->with('posicion', $posicion);
 }	

 public function baner($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-baner')->with('posicion', $posicion);
 }	

 public function collapsable($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-collapsable')->with('posicion', $posicion);
 }		

 public function subtabs($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-subtabs')->with('posicion', $posicion);
 }

  public function subempleos($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-subempleos')->with('posicion', $posicion);
 }	

 public function subshuffleweb($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-subshuffle')->with('posicion', $posicion);
 }	

 public function formulario($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-formulario')->with('posicion', $posicion);
 }

 public function formulas($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-formulas')->with('posicion', $posicion);
 }

 public function productos($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-productos')->with('posicion', $posicion);
 }

 public function filtros($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-filtros')->with('posicion', $posicion);
 }

 public function filtrosdinami($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-filtrosdinami')->with('posicion', $posicion);
 }

 public function rondaproductos($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-ronda')->with('posicion', $posicion);
 }

  public function carousel($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-carousel')->with('posicion', $posicion);
 }

 public function rondacomunidad($id){
  $categoria = DB::table('categoria_comunidades')->where('webtipodev','=','1')->get();
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-rondacom')->with('posicion', $posicion)->with('categoria', $categoria);
 }

 public function rondacomunidadina($id){
  $categoria = DB::table('categoria_comunidades')->where('webtipodev','=','2')->get();
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-rondacomina')->with('posicion', $posicion)->with('categoria', $categoria);
 }

 public function videoclips($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-videoclip')->with('posicion', $posicion);
 }

 public function documento($id){
  $roles = DB::table('roles_comunidad')->get();
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-documento')->with('posicion', $posicion)->with('roles', $roles);
 }

 public function vimeoback($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-vimeoback')->with('posicion', $posicion);
 }

 public function eventos($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-eventos')->with('posicion', $posicion);
 }

 public function calendario($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-calendario')->with('posicion', $posicion);
 }

 public function totaleventos($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-totaleventos')->with('posicion', $posicion);
 }

 public function empleos($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-empleo')->with('posicion', $posicion);
 }

 public function backimage($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-backimage')->with('posicion', $posicion);
 }

 public function cuenta($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-cuenta')->with('posicion', $posicion);
 }

 public function mediamini($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-mediamini')->with('posicion', $posicion);
 }	

 public function galeriavideo($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-galeriavideo')->with('posicion', $posicion);
 }

 public function imgaleriavideo($id){
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-imgaleriavideo')->with('posicion', $posicion);
 }

 public function imgshuffleweb($id){
  $categoria = DB::table('shuffleweb')->get();
  $posicion = Conte::Orderby('id', 'asc')->take(10)->pluck('posicion','posicion');
  return view('pagina::contenidos/crear-imagenshuffle')->with('posicion', $posicion)->with('categoria', $categoria);
 }

}


