<?php

 namespace DigitalsiteSaaS\Pagina\Http;



use App\Providers\RouteServiceProvider;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\User;
use Input;
use File;
use Redirect;
use DigitalsiteSaaS\Carrito\Transaccion;
use DigitalsiteSaaS\Pagina\Credencial;
use GuzzleHttp\Client;

 class SuscripcionController extends Controller
 {
  
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

  public function crearplanessaas(){
    return view('pagina::configuracion.crear-plansaas');
  }
  
   public function editarcredenciales(){
    $credenciales = Credencial::where('id', '=', '1')->get();

    return view('pagina::suscripcion.credenciales')->with('credenciales', $credenciales);
  }

   public function editarcredencialesweb(){
     $input = Input::all();
     $user = Credencial::find(1);
     $user->public_key = Input::get('public_key');
     $user->private_key = Input::get('private_key');
     $user->save();
    return Redirect('/suscripcion/credenciales')->with('status', 'ok_update');
  }




  public function planessaas(){
    $credenciales = Credencial::where('id', 1)->get();
    foreach ($credenciales as $credencialesw) {
        $public_key = $credencialesw->public_key;
        $private_key = $credencialesw->private_key;
    }
    $client = new Client(['http_errors' => false]);
    $response = $client->post('https://api.secure.payco.co/v1/auth/login', [
    'form_params' => [
    'public_key' => $public_key,
    'private_key' =>  $private_key,
     ],
    ]);
    $xml = json_decode($response->getBody()->getContents(), true);
    $token = $xml['bearer_token'];
    $tok = "Bearer"." ".$token;
    $responsed = $client->get('https://api.secure.payco.co/recurring/v1/plans/public_key/', [
    'headers' => [
    'Authorization' =>  $tok,
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
    'Type' => 'sdk-jwt',
    ],
    ]);
    $xmls = json_decode($responsed->getBody()->getContents(), true);
    return view('pagina::configuracion.planes-saas')->with('xmls', $xmls);
  }


  public function eliminarplan($id){
    $credenciales = Credencial::where('id', 1)->get();
    foreach ($credenciales as $credencialesw) {
        $public_key = $credencialesw->public_key;
        $private_key = $credencialesw->private_key;
    }
    $client = new Client(['http_errors' => false]);
    $response = $client->post('https://api.secure.payco.co/v1/auth/login', [
    'form_params' => [
    'public_key' => $public_key,
    'private_key' => $private_key,
    ],
    ]);
    $xml = json_decode($response->getBody()->getContents(), true);
    $token = $xml['bearer_token'];
    $tok = "Bearer"." ".$token;
    $responsed = $client->post('https://api.secure.payco.co/recurring/v1/plan/remove/public_key/'.$id, [
    'headers' => [
    'Authorization' =>  $tok,
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
    'Type' => 'sdk-jwt',
    ],
    ]);
    $xmls = json_decode($responsed->getBody()->getContents(), true);
    return Redirect('/gestor/planes-saas')->with('status', 'ok_create');
  }

  public function listaclientes(){
    $credenciales = Credencial::where('id', 1)->get();
    foreach ($credenciales as $credencialesw) {
        $public_key = $credencialesw->public_key;
        $private_key = $credencialesw->private_key;
    }

    $public_key = $public_key;
    $client = new Client(['http_errors' => false]);
    $response = $client->post('https://api.secure.payco.co/v1/auth/login', [
    'form_params' => [
    'public_key' => $public_key,
    'private_key' => $private_key,
    ],
    ]);
    $xml = json_decode($response->getBody()->getContents(), true);
    $token = $xml['bearer_token'];
    $tok = "Bearer"." ".$token;
    $responsed = $client->get('https://api.secure.payco.co/payment/v1/customers/'.$public_key, [
    'headers' => [
    'Authorization' =>  $tok,
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
    'Type' => 'sdk-jwt',
    ],
    ]);
    $xmls = json_decode($responsed->getBody()->getContents(), true);

    return view('pagina::suscripcion.clientes')->with('xmls', $xmls);
  }

  public function listasuscripciones(){

    $credenciales = Credencial::where('id', 1)->get();
    foreach ($credenciales as $credencialesw) {
        $public_key = $credencialesw->public_key;
        $private_key = $credencialesw->private_key;
    }
    $public_key = $public_key;
    $client = new Client(['http_errors' => false]);
    $response = $client->post('https://api.secure.payco.co/v1/auth/login', [
    'form_params' => [
    'public_key' => $public_key,
    'private_key' => $private_key,
    ],
    ]);
    $xml = json_decode($response->getBody()->getContents(), true);
    $token = $xml['bearer_token'];
    $tok = "Bearer"." ".$token;
    $responsed = $client->get('https://api.secure.payco.co/recurring/v1/subscriptions/'.$public_key, [
    'headers' => [
    'Authorization' =>  $tok,
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
    'Type' => 'sdk-jwt',
    ],
    ]);
    $xmls = json_decode($responsed->getBody()->getContents(), true);

    return view('pagina::suscripcion.suscripciones')->with('xmls', $xmls);
  }


  public function crearplan(Request $request){
    $credenciales = Credencial::where('id', 1)->get();
    foreach ($credenciales as $credencialesw) {
        $public_key = $credencialesw->public_key;
        $private_key = $credencialesw->private_key;
    }
    $name = $request->input('name');
    $id_plan = Str::slug($name);
    $description = $request->input('description');
    $amount = $request->input('amount');
    $moneda = $request->input('moneda');
    $intervalo = $request->input('intervalo');
    $int_conteo = $request->input('int_conteo');
    $trial = $request->input('trial');
    $client = new Client(['http_errors' => false]);
    $response = $client->post('https://api.secure.payco.co/v1/auth/login', [
    'form_params' => [
    'public_key' => $public_key,
    'private_key' => $private_key,
    ],
    ]);
    $xml = json_decode($response->getBody()->getContents(), true);
    $token = $xml['bearer_token'];
    $tok = "Bearer"." ".$token;
    $responsed = $client->post('https://api.secure.payco.co/recurring/v1/plan/create', [
    'headers' => [
    'Authorization' =>  $tok,
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
    'Type' => 'sdk-jwt',
    ],
    'json' => [
    'id_plan' => $id_plan,
    'name' => $name,
    'description' => $description,
    'amount' => $amount,
    'currency' => $moneda,
    'interval' => $intervalo,
    'interval_count' => $int_conteo,
    'trial_days' => $trial,
    ],
    ]);
    $xmls = json_decode($responsed->getBody()->getContents(), true);
    return Redirect('/gestor/planes-saas')->with('status', 'ok_create');
  }

  public function formulario(){
    $credenciales = Credencial::where('id', 1)->get();
    foreach ($credenciales as $credencialesw) {
        $public_key = $credencialesw->public_key;
        $private_key = $credencialesw->private_key;
    }
    $client = new Client(['http_errors' => false]);
    $response = $client->post('https://api.secure.payco.co/v1/auth/login', [
    'form_params' => [
    'public_key' => $public_key,
    'private_key' => $private_key,
     ],
    ]);
    $xml = json_decode($response->getBody()->getContents(), true);
    $token = $xml['bearer_token'];
    $tok = "Bearer"." ".$token;
    $responsed = $client->get('https://api.secure.payco.co/recurring/v1/plans/public_key/', [
    'headers' => [
    'Authorization' =>  $tok,
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
    'Type' => 'sdk-jwt',
    ],
    ]);
    $xmls = json_decode($responsed->getBody()->getContents(), true);
    $plantilla = \DigitalsiteSaaS\Pagina\Template::all();
    $menu = \DigitalsiteSaaS\Pagina\Page::whereNull('page_id')->orderBy('posta', 'desc')->get();
    $subtotal = $this->subtotal();
    $total = $this->total();
    return view('pagina::suscripcion.formulario')->with('plantilla', $plantilla)->with('menu', $menu)->with('xmls', $xmls)->with('subtotal', $subtotal)->with('total', $total);
  }


   public function respuesta($id){

    $plantilla = \DigitalsiteSaaS\Pagina\Template::all();
    $menu = \DigitalsiteSaaS\Pagina\Page::whereNull('page_id')->orderBy('posta', 'desc')->get();
    $subtotal = $this->subtotal();
    $total = $this->total();
    $informacion = Transaccion::where('referencia','=',$id)->get();
    return view('pagina::suscripcion.respuesta')->with('plantilla', $plantilla)->with('menu', $menu)->with('subtotal', $subtotal)->with('total', $total)->with('informacion', $informacion);
    }

  }

  
