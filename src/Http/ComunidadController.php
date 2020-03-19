<?php

 namespace DigitalsiteSaaS\Pagina\Http;
 use App\Http\Controllers\Controller;
 use DigitalsiteSaaS\Pagina\Nota;
 use DigitalsiteSaaS\Pagina\Tema;
 use DigitalsiteSaaS\Pagina\Template;
 use DigitalsiteSaaS\Pagina\Catecom;
 use DigitalsiteSaaS\Pagina\Areacom;
 use DigitalsiteSaaS\Pagina\Gradocom;
 use DigitalsiteSaaS\Pagina\Subtema;
 use DigitalsiteSaaS\Pagina\Rols;
 use DigitalsiteSaaS\Pagina\Page;
 use DigitalsiteSaaS\Pagina\Interes;
 use DigitalsiteSaaS\Pagina\Documento;
 use DB;
 use Input;
 use GuzzleHttp\Client;
 use Illuminate\Support\Str;
 use Session;
 use Illuminate\Http\Request;

 class ComunidadController extends Controller{
   
 public function __construct(){
  if(!session()->has('cart')) session()->has('cart', array());
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

 public function create($id){
  return view('pagina::comunidad.crear')->with('areas', $areas)->with('parametros', $parametros);
 }

 public function vernotas($id){
  $notas = DB::table('notas_comunidades')->where('nota_comunidad_id', '=', $id)->get();
  $notascol = DB::table('categoria_comunidades')->where('id', '=', $id)->get();
  $documentos = DB::table('comunidad_documentos')->where('notas_id', '=', $id)->get();
  return view('pagina::comunidad.notas')->with('notas', $notas)->with('notascol', $notascol);
 }

 public function verdocumentos($id){
  $notas = DB::table('comunidad_documentos')->where('notas_id', '=', $id)->get();
  return view('pagina::comunidad.documentos')->with('notas', $notas);
 }

 public function crearnota(){
  $notaweb = Input::get('tagsa');
  $saberweb = Input::get('saber_eva');
  $recursowebeva = Input::get('recursos_eva');
  $data = json_encode($notaweb, true);
  $dataweb = json_encode($saberweb, true);
  $recursoweb = json_encode($recursowebeva, true);
  $recurweb = array('"', '[', ']');
  $onlyconsonantswebrec = str_replace($recurweb, '', $recursoweb);
  $vowelsweb = array('"', '[', ']');
  $onlyconsonantsweb = str_replace($vowelsweb, '', $dataweb);
  $vowels = array('"', '[', ']');
  $onlyconsonants = str_replace($vowels, '', $data);
  $nota = new Nota;
  $nota->titulo = Input::get('titulo');
  $nota->slugg = Str::slug($nota->titulo);
  $nota->descripcion = Input::get('descripcion');
  $nota->keywords = Input::get('keywords');
  $nota->contenido = Input::get('contenido');
  $nota->imagen = Input::get('FilePath');
  $nota->visualizacion = Input::get('nivel');
  $nota->tipo = Input::get('tipo');
  $nota->nota_comunidad_id = Input::get('peca');
  $nota->responsive = Input::get('responsive');
  $nota->area_id = Input::get('area');
  $nota->roles = $onlyconsonants;
  $nota->saber_eva = $onlyconsonantsweb;
  $nota->recurso_eva = $onlyconsonantswebrec;
  $nota->tema_id = Input::get('tema');
  $nota->subtema_id = Input::get('subtema');
  $nota->webtipo = Input::get('webtipo');
  $nota->parametro_id = Input::get('parametro');
  $nota->video = Input::get('video');
  $nota->interes_id = Input::get('interes');
  $nota->area_eva = Input::get('area_eva');
  $nota->grado_eva = Input::get('grado_eva');
  $nota->save();
  return Redirect('/gestion/comunidad/notas/'.$nota->nota_comunidad_id)->with('status', 'ok_create');
 }

 public function eliminarnota($id){
  $nota = Nota::find($id);
  $nota->delete();
  return Redirect('gestion/comunidad/notas/'.$nota->nota_comunidad_id)->with('status', 'ok_delete');
 }

 public function eliminararea($id){
  $nota = Areacom::find($id);
  $nota->delete();
  return Redirect('gestion/comunidad/areas/')->with('status', 'ok_delete');
 }

 public function eliminargrado($id){
  $nota = Gradocom::find($id);
  $nota->delete();
  return Redirect('gestion/comunidad/grados/'.$nota->area_id)->with('status', 'ok_delete');
 }

 public function eliminarinteres($id){
  $nota = Interes::find($id);
  $nota->delete();
  return Redirect('gestion/comunidad/interes/')->with('status', 'ok_delete');
 }

 public function editarnota($id){
  $notaweb = Input::get('tagsa');
  $data = json_encode($notaweb, true);
  $vowels = array('"', '[', ']');
  $onlyconsonants = str_replace($vowels, '', $data);
  $input = Input::all();
  $nota = Nota::find($id);
  $nota->titulo = Input::get('titulo');
  $nota->slugg = Str::slug($nota->titulo);
  $nota->descripcion = Input::get('descripcion');
  $nota->keywords = Input::get('keywords');
  $nota->contenido = Input::get('contenido');
  $nota->imagen = Input::get('FilePath');
  $nota->visualizacion = Input::get('nivel');
  $nota->nota_comunidad_id = Input::get('peca');
  $nota->tipo = Input::get('tipo');
  $nota->responsive = Input::get('responsive');
  $nota->area_id = Input::get('area');
  $nota->roles = $onlyconsonants;
  $nota->parametro_id = Input::get('parametro');
  $nota->tema_id = Input::get('tema');
  $nota->subtema_id = Input::get('subtema');
  $nota->interes_id = Input::get('interes');
  $nota->video = Input::get('video');
  $nota->webtipo = Input::get('webtipo');
  $nota->save();
  return Redirect('/gestion/comunidad/notas/'.$nota->nota_comunidad_id)->with('status', 'ok_update');
 }

 public function temas(){
  $areatema = session()->get('areatema');
  $gradotema = session()->get('gradotema');
  $area = DB::table('area_comunidades')->get();
  $temas = DB::table('temas_comunidades')
   ->where('area_id', 'LIKE', $areatema)
   ->where('grado_id', 'LIKE', $gradotema)
   ->get();
  return view('pagina::comunidad.temas')->with('temas', $temas)->with('area', $area);
 }

 public function subtemas($id){
  $temas = DB::table('subtemas_comunidades')->where('subtemaid','=', $id)->get();
  return view('pagina::comunidad.subtemas')->with('temas', $temas);
 }

 public function login(Request $request){ 
  $plantilla = \DigitalsiteSaaS\Pagina\Template::all();
  $cart = session()->get('cart');
  $total = $this->total();
  $subtotal = $this->subtotal();
  $menu = \DigitalsiteSaaS\Pagina\Page::whereNull('page_id')->orderBy('posta', 'desc')->get();
  $client = new Client(['http_errors' => false]);
  $redireccion = Input::get('redireccion');
  $response = $client->post('https://evaback.lyl.com.co:8000/api/ws/evaauthservice', [
  'form_params' => [
  'username' => Input::get('email'),
  'password' => Input::get('password'),
  'action' => 'login',],
  ]);
  $xml = json_decode($response->getBody()->getContents(), true);
  $estado = $xml['status'];
  if($estado == 0){
  $urlprocess = $xml['status'];
  $urlprocessa = $xml['data']['email'];
  $urlprocessb = $xml['data']['school_type'];
  $urlprocessc = $xml['data']['user_name'];
  Session::put('miSesionTextoaaaa',$urlprocessa);
  Session::put('miSesionTextoaaac',$urlprocessb);
  Session::put('miSesionTextoaaad',$urlprocessc);
  return Redirect($redireccion);
  }
  else{
  $message = $xml['message'];
  return view('auth.loginacomunidad')->with('plantilla', $plantilla)->with('menu', $menu)->with('cart', $cart)->with('total', $total)->with('subtotal', $subtotal)->with('message', $message);
  }
 }

 public function creartemas(){
  $tema = new Tema;
  $tema->tema = Input::get('tema');
  $tema->slugtema = Str::slug($tema->tema);
  $tema->descripciontema = Input::get('descripcion');
  $tema->area_id = Input::get('area');
  $tema->grado_id = Input::get('grado');
  $tema->color_tema = Input::get('color');
  $tema->save();
  return Redirect('/gestion/comunidad/temas/')->with('status', 'ok_create');
 }

 public function creardocumento(){
  $tema = new Documento;
  $tema->titulo_des = Input::get('titulo');
  $tema->slug = Str::slug($tema->titulo_des);
  $tema->descripcion_des = Input::get('descripcion');
  $tema->contenido_des = Input::get('contenido');
  $tema->icono = Input::get('imageal');
  $tema->orden = Input::get('nivelpos');
  $tema->documento = Input::get('FilePath');
  $tema->notas_id = Input::get('peca');
  $tema->visible = Input::get('nivel');
  $tema->responsive = Input::get('responsive');
  $tema->save();
  return Redirect('/gestion/comunidad/documentos/'.$tema->notas_id)->with('status', 'ok_create');
 }

 public function editardocumento($id){
  $input = Input::all();
  $tema = Documento::find($id);
  $tema->titulo_des = Input::get('titulo');
  $tema->slug = Str::slug($tema->titulo_des);
  $tema->descripcion_des = Input::get('descripcion');
  $tema->contenido_des = Input::get('contenido');
  $tema->icono = Input::get('imageal');
  $tema->orden = Input::get('nivelpos');
  $tema->documento = Input::get('FilePath');
  $tema->notas_id = Input::get('peca');
  $tema->visible = Input::get('nivel');
  $tema->responsive = Input::get('responsive');
  $tema->save();
  return Redirect('/gestion/comunidad/documentos/'.$tema->notas_id)->with('status', 'ok_update');
 }

 public function eliminardocumento($id){
  $tema = Documento::find($id);
  $tema->delete();
  return Redirect('/gestion/comunidad/documentos/'.$tema->notas_id)->with('status', 'ok_delete');
 }

 public function subcreartemas(){
  $tema = new Subtema;
  $tema->subtema = Input::get('tema');
  $tema->slugca = Str::slug($tema->subtema);
  $tema->subdescripcion = Input::get('descripcion');
  $tema->des_orientacion = Input::get('descorientacion');
  $tema->des_evaluacion = Input::get('descevaluacion');
  $tema->subtemaid = Input::get('tema_id');
  $tema->orientacion = Input::get('FilePath');
  $tema->evaluacion = Input::get('FilePatha');
  $tema->save();
  return Redirect('/gestion/comunidad/subtemas/'.$tema->subtemaid)->with('status', 'ok_create');
 }

 public function editartema($id){
  $input = Input::all();
  $tema = Tema::find($id);
  $tema->tema = Input::get('tema');
  $tema->slugtema = Str::slug($tema->tema);
  $tema->descripciontema = Input::get('descripcion');
  $tema->area_id = Input::get('area');
  $tema->grado_id = Input::get('grado');
  $tema->color_tema = Input::get('color');
  $tema->save();
  return Redirect('/gestion/comunidad/temas/')->with('status', 'ok_update');
 }

 public function editarsubtema($id){
  $input = Input::all();
  $tema = Subtema::find($id);
  $tema->subtema = Input::get('tema');
  $tema->subdescripcion = Input::get('descripcion');
  $tema->subtemaid = Input::get('tema_id');
  $tema->slugca = Str::slug($tema->subtema);
  $tema->orientacion = Input::get('FilePath');
  $tema->evaluacion = Input::get('FilePatha');
  $tema->des_orientacion = Input::get('descorientacion');
  $tema->des_evaluacion = Input::get('descevaluacion');
  $tema->save();
  return Redirect('/gestion/comunidad/subtemas/'.$tema->subtemaid)->with('status', 'ok_update');
 }

 public function eliminartema($id){
  $tema = Tema::find($id);
  $tema->delete();
  return Redirect('/gestion/comunidad/temas/')->with('status', 'ok_delete');
 }

 public function eliminarrols($id){
  $tema = Rols::find($id);
  $tema->delete();
  return Redirect('/gestion/comunidad/roles')->with('status', 'ok_delete');
 }

 public function eliminarsubtema($id){
  $tema = Subtema::find($id);
  $tema->delete();
  return Redirect('/gestion/comunidad/subtemas/'.$tema->subtemaid)->with('status', 'ok_delete');
 }

 public function crearcatecomunidad(){
  $nota = new Catecom;
  $nota->com_nombre = Input::get('nombre');
  $nota->slug = Str::slug($nota->com_nombre);
  $nota->com_descripcion = Input::get('descripcion');
  $nota->webtipodev = Input::get('webtipo');
  $nota->color = Input::get('color');
  $nota->save();
  return Redirect('/gestion/comunidad')->with('status', 'ok_create');
 }

 public function eliminarcategoria($id){
  $tema = Catecom::find($id);
  $tema->delete();
  return Redirect('/gestion/comunidad')->with('status', 'ok_delete');
 }

 public function editarcategoria($id){
  $input = Input::all();
  $nota = Catecom::find($id);
  $nota->com_nombre = Input::get('nombre');
  $nota->slug = Str::slug($nota->com_nombre);
  $nota->com_descripcion = Input::get('descripcion');
  $nota->color = Input::get('color');
  $nota->save();
  return Redirect('/gestion/comunidad')->with('status', 'ok_update');
 }

 public function creararea(){
  $nota = new Areacom;
  $nota->area = Input::get('area');
  $nota->colorcom = Input::get('color');    
  $nota->save();
  return Redirect('gestion/comunidad/areas')->with('status', 'ok_create');
 }

 public function creargrado(){
  $nota = new Gradocom;
  $nota->grado_comunidad = Input::get('grado');
  $nota->area_id = Input::get('area_id');    
  $nota->save();
  return Redirect('gestion/comunidad/grados/'.$nota->area_id)->with('status', 'ok_create');
 }

 public function crearinteres(){
  $nota = new Interes;
  $nota->interes = Input::get('interes');
  $nota->color = Input::get('color');    
  $nota->save();
  return Redirect('gestion/comunidad/interes')->with('status', 'ok_create');
 }

 public function crearrols(){
  $nota = new Rols;
  $nota->nombre = Input::get('nombre');
  $nota->rol_comunidad = Input::get('rol_id');    
  $nota->save();
  return Redirect('gestion/comunidad/roles')->with('status', 'ok_create');
 }

 public function editararea($id){
  $input = Input::all();
  $nota = Areacom::find($id);
  $nota->area = Input::get('area');
  $nota->colorcom = Input::get('color');    
  $nota->save();
  return Redirect('gestion/comunidad/areas')->with('status', 'ok_update');
 }

 public function editargrado($id){
  $input = Input::all();
  $nota = Gradocom::find($id);
  $nota->grado_comunidad = Input::get('grado');
  $nota->area_id = Input::get('area_id');
  $nota->save();
  return Redirect('gestion/comunidad/grados/'.$nota->area_id)->with('status', 'ok_update');
 }
 
 public function editarinteres($id){
  $input = Input::all();
  $nota = Interes::find($id);
  $nota->interes = Input::get('area');
  $nota->color = Input::get('color');    
  $nota->save();
  return Redirect('gestion/comunidad/interes')->with('status', 'ok_update');
 }

 public function editarroles($id){
  $input = Input::all();
  $nota = Rols::find($id);
  $nota->nombre = Input::get('nombre');
  $nota->rol_comunidad = Input::get('rol_id');    
  $nota->save();
  return Redirect('gestion/comunidad/roles')->with('status', 'ok_update');
 }



 public function nota($id){
  $plantilla = Template::all();
  $taka = Nota::where('slugg','=',$id)->get();
   foreach($taka as $taka){
	$media = Nota::inRandomOrder()->where('subtema_id','=',$taka->subtema_id)->take(6)->get();
   }
  $menu = Page::whereNull('page_id')->orderBy('posta', 'desc')->get();
  $total = $this->total();
  $notascol = DB::table('categoria_comunidades')->where('id', '=', $id)->get();
  $documentos = DB::table('notas_comunidades')
   ->join('comunidad_documentos','comunidad_documentos.notas_id','=','notas_comunidades.id')
   ->where('notas_comunidades.slugg', '=', $id)->get();
  $cart = session()->get('cart');
  $subtotal = $this->subtotal();
  $notas = DB::table('notas_comunidades')
   ->leftJoin('area_comunidades','area_comunidades.id','=','notas_comunidades.area_id')
   ->leftJoin('parametro','parametro.id','=','notas_comunidades.parametro_id')
   ->leftJoin('temas_comunidades','temas_comunidades.id','=','notas_comunidades.tema_id')
   ->leftJoin('subtemas_comunidades','subtemas_comunidades.id','=','notas_comunidades.subtema_id')
   ->where('notas_comunidades.slugg','=',$id)
   ->get();
  return view('pagina::comunidad-notas')->with('notas', $notas)->with('plantilla', $plantilla)->with('menu', $menu)->with('media', $media)->with('subtotal', $subtotal)->with('total', $total)->with('cart', $cart)->with('documentos', $documentos);
 }

 public function notaweb($page){
  $plantilla = Template::all();
  $taka = Nota::where('slugg','=',$page)->get();
   foreach($taka as $taka){
	$media = Nota::inRandomOrder()->where('nota_comunidad_id','=',$taka->nota_comunidad_id)->take(6)->get();
   }
  $total = $this->total();
  $cart = session()->get('cart');
  $subtotal = $this->subtotal();
  $menu = Page::whereNull('page_id')->orderBy('posta', 'desc')->get();
  $notas = DB::table('notas_comunidades')
   ->join('interes_comunidades', 'notas_comunidades.interes_id', '=', 'interes_comunidades.id')
   ->where('notas_comunidades.slugg','=',$page)
   ->get();
  return view('pagina::comunidad-notasweb')->with('notas', $notas)->with('plantilla', $plantilla)->with('menu', $menu)->with('media', $media)->with('subtotal', $subtotal)->with('total', $total)->with('cart', $cart);
 }

 public function creareva($id){
 $client = new Client(['http_errors' => false]);
 $response = $client->post('https://evaback.lyl.com.co:8000/api/ws/evaauthservice', [
 'form_params' => [
 'username' => 'sitedigital@sitedigital.com',
 'password' => 'Colombia2018',
 'action' => 'login',
 'token' => 'true',],
 ]);
 $xml = json_decode($response->getBody()->getContents(), true);
 $token = $xml['data']['token'];
 $tok = "JWT"." ".$token;
 $responsed = $client->get('https://evaback.lyl.com.co:8000/api/ws/eva_get_subjects', [
 'headers' => [
 'authorization' =>  $tok,],
 ]);
 $xmls = json_decode($responsed->getBody()->getContents(), true);
 $valor = []; 
 $data = [];
 $data1 = [];
 foreach($xmls['data'] as $index => $valor){
  $data[$valor['id']] = $valor['name'];
 }
 $responsedg = $client->get('https://evaback.lyl.com.co:8000/api/ws/eva_get_resources', [
 'headers' => [
 'authorization' =>  $tok,],
 ]);
 $xmlsg = json_decode($responsedg->getBody()->getContents(), true);
 $valorg = []; 
 $recursos = [];
 $data1g = [];
 foreach($xmlsg['resources'] as $index => $valorg){
  $recursos[$valorg['id']] = $valorg['name'];
 }
 $responsedd = $client->get('https://evaback.lyl.com.co:8000/api/ws/eva_get_tiers', [
 'headers' => [
 'authorization' =>  $tok,],
 ]);
 $xmlsd = json_decode($responsedd->getBody()->getContents(), true);
 $valor = []; 
 $grado = [];
 foreach($xmlsd['data'] as $index => $valor){
  $grado[$valor['id']] = $valor['name'];
 }
 $client = new Client();
 $responsede = $client->request('GET', "https://evaback.lyl.com.co:8000/api/ws/eva_get_knowledges", [
  "query" => [
  "subject_id" => session()->get('area_eva') ? session()->get('area_eva'):0,
  "tier_id"=> session()->get('grado_eva') ? session()->get('grado_eva'):0,], 
  'headers' => [
  'authorization' =>  $tok,],
 ]);
 $xmlse = json_decode($responsede->getBody()->getContents(), true);
 $valor = []; 
 $sabers = [];
 foreach($xmlse['knowledges'] as $web => $valor){
  $sabers[$valor['id']] = $valor['text'];
 }
 $saber = preg_replace('/<[^>]*>/', '', $sabers);;
 $areas = DB::table('area_comunidades')->get();
 $roles = DB::table('roles_comunidad')->get();
 $parametros = DB::table('parametro')->get();
 $temas = DB::table('temas_comunidades')->get();
 $retorno = DB::table('notas_comunidades')->where('id','=',2)->get();
 return view('pagina::comunidad.crear', compact('areas','parametros','temas','roles','data','grado','saber','clean','retorno','evas','recursos'));

	}

public function editareva($id){
 $client = new Client(['http_errors' => false]);
 $response = $client->post('https://evaback.lyl.com.co:8000/api/ws/evaauthservice', [
  'form_params' => [
  'username' => 'sitedigital@sitedigital.com',
  'password' => 'Colombia2018',
  'action' => 'login',
  'token' => 'true',],
 ]);
 $xml = json_decode($response->getBody()->getContents(), true);
 $token = $xml['data']['token'];
 $tok = "JWT"." ".$token;
 $responsed = $client->get('https://evaback.lyl.com.co:8000/api/ws/eva_get_subjects', [
  'headers' => [
  'authorization' =>  $tok,],
 ]);
 $xmls = json_decode($responsed->getBody()->getContents(), true);
 $valor = []; 
 $data = [];
 $data1 = [];
 foreach($xmls['data'] as $index => $valor){
  $data[$valor['id']] = $valor['name'];
 }
 $responsedg = $client->get('https://evaback.lyl.com.co:8000/api/ws/eva_get_resources', [
  'headers' => [
  'authorization' =>  $tok,
 ],
 ]);
 $xmlsg = json_decode($responsedg->getBody()->getContents(), true);
 $valorg = []; 
 $recursos = [];
 $data1g = [];
 foreach($xmlsg['resources'] as $index => $valorg){
  $recursos[$valorg['id']] = $valorg['name'];
 }
 $responsedd = $client->get('https://evaback.lyl.com.co:8000/api/ws/eva_get_tiers', [
  'headers' => [
  'authorization' =>  $tok,],
 ]);
 $xmlsd = json_decode($responsedd->getBody()->getContents(), true);
 $valor = []; 
 $grado = [];
 foreach($xmlsd['data'] as $index => $valor){
  $grado[$valor['id']] = $valor['name'];
 }
 $client = new Client();
 $responsede = $client->request('GET', "https://evaback.lyl.com.co:8000/api/ws/eva_get_knowledges", [
 "query" => [
 "subject_id" => session()->get('area_eva') ? session()->get('area_eva'):0,
 "tier_id"=> session()->get('grado_eva') ? session()->get('grado_eva'):0,], 
 'headers' => [
 'authorization' =>  $tok,],
 ]);
 $xmlse = json_decode($responsede->getBody()->getContents(), true);
 $valor = []; 
 $sabers = [];
 foreach($xmlse['knowledges'] as $web => $valor){
  $sabers[$valor['id']] = $valor['text'];
 }
 $saber = preg_replace('/<[^>]*>/', '', $sabers);  
 $areas = DB::table('area_comunidades')->get();
 $parametros = DB::table('parametro')->get();
 $roles = DB::table('roles_comunidad')->get();
 $notador = DB::table('notas_comunidades')->where('id','=',$id)->get();
 foreach ($notador as $notadores){
 $ideman = $notadores->roles;
 $id_str = explode(',', $ideman);
 $rols = DB::table('roles_comunidad')->whereIn('id', $id_str)->get();}
 $rolsas = DB::table('rols')->get();
 $notas = DB::table('notas_comunidades')
  ->leftJoin('area_comunidades', 'notas_comunidades.area_id', '=', 'area_comunidades.id')
  ->leftJoin('temas_comunidades', 'notas_comunidades.tema_id', '=', 'temas_comunidades.id')
  ->leftJoin('subtemas_comunidades', 'notas_comunidades.subtema_id', '=', 'subtemas_comunidades.id')
  ->leftJoin('grado_comunidades', 'notas_comunidades.parametro_id', '=', 'grado_comunidades.id')
  ->where('notas_comunidades.id', '=' ,$id)->get();
 $temas = DB::table('temas_comunidades')->get();
 $retorno = DB::table('notas_comunidades')->where('id','=',2)->get();
 return view('pagina::comunidad.editar', compact('areas','parametros','notas','temas','rols','notador','rolsas','roles','data','grado','saber','clean','retorno','evas','recursos'));

}
}