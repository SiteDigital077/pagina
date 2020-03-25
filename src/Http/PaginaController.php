<?php

 namespace DigitalsiteSaaS\Pagina\Http;
 use DigitalsiteSaaS\Pagina\Page;
 use DB;
 use Auth;
 use Zipper;
 use File;
 use Storage;
 use DigitalsiteSaaS\Pagina\Zippera;
 use DigitalsiteSaaS\Pagina\Color;
 use App\Http\Controllers\Controller;
 use Input;
 use DigitalsiteSaaS\Pagina\Diagrama;
 use Illuminate\Support\Str;
 use Illuminate\Filesystem\Filesystem;
 use Illuminate\Http\Request;
 use Hyn\Tenancy\Models\Hostname;
 use Hyn\Tenancy\Models\Website;
 use Hyn\Tenancy\Repositories\HostnameRepository;
 use Hyn\Tenancy\Repositories\WebsiteRepository;

 class PaginaController extends Controller{

protected $tenantName = null;

 public function __construct(){
  $this->middleware('auth');

  $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
        if ($hostname){
            $fqdn = $hostname->fqdn;
            $this->tenantName = explode(".", $fqdn)[0];
        }

 }

 public function index(){
  if(!$this->tenantName){
  $paginas = Page::all();
  $menu = Page::whereNull('page_id')->get();
  $casta = Page::count();
  $user = Page::where('posti','=','1')->count();
  }
  else{
  $paginas = \DigitalsiteSaaS\Pagina\Tenant\Page::all();
  $menu = \DigitalsiteSaaS\Pagina\Tenant\Page::whereNull('page_id')->get();
  $casta = \DigitalsiteSaaS\Pagina\Tenant\Page::count();
  $user = \DigitalsiteSaaS\Pagina\Tenant\Page::where('posti','=','1')->count();
  }
  return view('pagina::paginas.paginas')->with('paginas', $paginas)->with('user', $user)->with('casta', $casta)->with('menu', $menu);
 
}



 public function show(){
  $number = Auth::user()->id;
  $user = Page::where('posti','=','1')->count();
  return View('pagina::paginas.crear-pagina')->with('user', $user)->with('number', $number);
 }

 public function registrosaas(){
  $tenantName = $this->tenantName;
  return View('auth.register')->with('tenantName', $tenantName);
 }

  public function editardiagrama($id){
  if(!$this->tenantName){
  $diagramas = Diagrama::where('id', "=", $id)->get();
  }else{
  $diagramas = \DigitalsiteSaaS\Pagina\Tenant\Diagrama::where('id', "=", $id)->get();
  }
  return View('pagina::actualizar-diagrama')->with('diagramas', $diagramas);
 }



 public function crearpagina(){

  if(!$this->tenantName){
  $pagina = new Page;
  $pagina->page = Input::get('pagina');
  $pagina->slug = Str::slug($pagina->page);
  $pagina->description = Input::get('descripcion');
  $pagina->visualizafoot = Input::get('visualizafoot');
  $pagina->titulo = Input::get('titulo');
  $pagina->palabras = Input::get('palabras');
  $pagina->posti = Input::get('posti');
  $pagina->nivel = Input::get('nivel');
  $pagina->categoria = Input::get('categoria');
  $pagina->sitio = Input::get('sitio');
  $pagina->page_id = Input::get('DNI');
  $pagina->save();
  $diagrama = new Diagrama;
  $diagrama->posicionSD01 = 'row';
  $diagrama->posicionSD1 = 'container';
  $diagrama->posicionSD2 = 'row';
  $diagrama->posicionSD02 = 'container';
  $diagrama->posicionSD3 = 'container';
  $diagrama->bloque = 'container';
  $diagrama->bloqueSD1 = 'container';
  $diagrama->bloqueSD2 = 'container';
  $diagrama->bloqueSD3 = 'container';
  $diagrama->bloqueSD4 = 'container';
  $diagrama->bloqueSD5 = 'container';
  $diagrama->bloqueSD6 = 'container';
  $diagrama->bloqueSD7 = 'container';
  $diagrama->bloqueSD8 = 'container';
  $diagrama->bloqueSD9 = 'container';
  $diagrama->posicionSD4 = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
  $diagrama->posicionSD5 = 'col-xs-12 col-sm-12 col-md-6 col-lg-6';
  $diagrama->posicionSD6 = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
  $diagrama->posicionSD7 = 'container';
  $diagrama->posicionSD8 = 'container';
  $diagrama->posicionSD9 = 'row';
  $diagrama->bloqueblog = 'container';
  $diagrama->posicionSD03 = 'container';
  $diagrama->bloqueficha1 = 'container';
  $diagrama->bloqueficha2 = 'container';
  $diagrama->save();
 }
 else{
  $pagina = new \DigitalsiteSaaS\Pagina\Tenant\Page;
  $pagina->page = Input::get('pagina');
  $pagina->slug = Str::slug($pagina->page);
  $pagina->description = Input::get('descripcion');
  $pagina->visualizafoot = Input::get('visualizafoot');
  $pagina->titulo = Input::get('titulo');
  $pagina->palabras = Input::get('palabras');
  $pagina->posti = Input::get('posti');
  $pagina->nivel = Input::get('nivel');
  $pagina->categoria = Input::get('categoria');
  $pagina->sitio = Input::get('sitio');
  $pagina->page_id = Input::get('DNI');
  $pagina->save();
  $diagrama = new \DigitalsiteSaaS\Pagina\Tenant\Diagrama;
  $diagrama->posicionSD01 = 'row';
  $diagrama->posicionSD1 = 'container';
  $diagrama->posicionSD2 = 'row';
  $diagrama->posicionSD02 = 'container';
  $diagrama->posicionSD3 = 'container';
  $diagrama->bloque = 'container';
  $diagrama->bloqueSD1 = 'container';
  $diagrama->bloqueSD2 = 'container';
  $diagrama->bloqueSD3 = 'container';
  $diagrama->bloqueSD4 = 'container';
  $diagrama->bloqueSD5 = 'container';
  $diagrama->bloqueSD6 = 'container';
  $diagrama->bloqueSD7 = 'container';
  $diagrama->bloqueSD8 = 'container';
  $diagrama->bloqueSD9 = 'container';
  $diagrama->posicionSD4 = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
  $diagrama->posicionSD5 = 'col-xs-12 col-sm-12 col-md-6 col-lg-6';
  $diagrama->posicionSD6 = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
  $diagrama->posicionSD7 = 'container';
  $diagrama->posicionSD8 = 'container';
  $diagrama->posicionSD9 = 'row';
  $diagrama->bloqueblog = 'container';
  $diagrama->posicionSD03 = 'container';
  $diagrama->bloqueficha1 = 'container';
  $diagrama->bloqueficha2 = 'container';
  $diagrama->save();
  }
  return Redirect('gestion/paginas')->with('status', 'ok_create');
 }

 public function actualizar($id){
  $input = Input::all();
  if(!$this->tenantName){
  $pagina = Page::find($id);
  }
  else{
  $pagina = \DigitalsiteSaaS\Pagina\Tenant\Page::find($id);
  }
  $pagina->page = Input::get('pagina');
  $pagina->slug = Str::slug($pagina->page);
  $pagina->visualizafoot = Input::get('visualizafoot');
  $pagina->description = Input::get('descripcion');
  $pagina->titulo = Input::get('titulo');
  $pagina->nivel = Input::get('nivel');
  $pagina->categoria = Input::get('categoria');
  $pagina->sitio = Input::get('sitio');
  $pagina->palabras = Input::get('palabras');	
  $pagina->save();
  return Redirect('gestion/paginas')->with('status', 'ok_update');
 }

 public function editar($id){
  if(!$this->tenantName){
  $number = Auth::user()->id;
  $paginas = Page::find($id);
}
else{
  $number = Auth::user()->id;
  $paginas = \DigitalsiteSaaS\Pagina\Tenant\Page::find($id);
}
  return view('pagina::paginas.editar-pagina')->with('paginas', $paginas)->with('number', $number);
 }

 public function subpagina(){
  $user = Page::where('posti','=','1')->count();
  return View('pagina::paginas.crear-subpagina')->with('user', $user);
 }

 public function eliminar($id){
 if(!$this->tenantName){
  $res = Diagrama::where('id',$id)->delete();
  $conteo = Page::where('page_id','=',$id)->count();
  if($conteo == 0){
  $pagina = Page::find($id);
  $pagina->delete();
    return Redirect('/gestion/paginas')->with('status', 'ok_delete');
  }
  else{
    return Redirect('/gestion/paginas')->with('status', 'ok_nodelete');
  }
 }else{
  $res = \DigitalsiteSaaS\Pagina\Tenant\Diagrama::where('id',$id)->delete();
  $conteo = \DigitalsiteSaaS\Pagina\Tenant\Page::where('page_id','=',$id)->count();
  if($conteo == 0){
  $pagina = \DigitalsiteSaaS\Pagina\Tenant\Page::find($id);
  $pagina->delete();
    return Redirect('/gestion/paginas')->with('status', 'ok_delete');
  }
  else{
    return Redirect('/gestion/paginas')->with('status', 'ok_nodelete');
  }
  }
 }

}