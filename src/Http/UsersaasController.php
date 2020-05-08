<?php

 namespace DigitalsiteSaaS\Pagina\Http;



use App\Providers\RouteServiceProvider;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use DigitalsiteSaaS\Carrito\Transaccion;
use DigitalsiteSaaS\Pagina\Credencial;
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
use GuzzleHttp\Client;
use DB;

class UsersaasController extends Controller
{
    
use RegistersUsers;

  protected $tenantName = null;

  public function __construct()
    {
       

        $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
        if ($hostname){
            $fqdn = $hostname->fqdn;
            $this->tenantName = explode(".", $fqdn)[0];
        }
       
    }
  
  public function showRegistrationForm(){
        return view('auth.register')->with('tenantName', $this->tenantName);
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


    protected function create($name, $email, $empresa, $password, $periodo, $plan)
    {

       $metrica = User::create([
           'name' => $name,
           'email' => $email,
           'rol_id' => '5',
           'password' => Hash::make($password),
        ]);

       	$fqdns = $empresa;

        $fqdn = sprintf('%s.%s', $fqdns, env('APP_DOMAIN'));
       
        $website = new Website;
        $website->uuid = Str::random(10);
        $path = public_path() . '/saas/'.$website->uuid;
        File::makeDirectory($path, 0777, true);
        app(WebsiteRepository::class)->create($website);
        $hostname = new Hostname();
        $hostname->fqdn = $fqdn;
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
  

        $update = User::where('id', $metrica->id)
            ->update(['saas_id' => $hostname->id,]);

         $updatedate = DB::table('tenancy.hostnames')->where('id', $hostname->id)
            ->update(['presentacion' => $periodo,'plan_id' => $plan]);
        
        $pass = Hash::make($password);

         $mihost =  ($website->uuid.'.');
         $website = DB::table($mihost.'users')->where('id', '1')
         ->update(['password' => $pass]);

        return Redirect('/gestion/registrosaas')->with('status', 'ok_create');
    }




public function suscripcion(Request $request){

$credenciales = Credencial::where('id', 1)->get();
    foreach ($credenciales as $credencialesw) {
        $public_key = $credencialesw->public_key;
        $private_key = $credencialesw->private_key;
    }
$card_number = $request->input('card_number');
$exp_year = $request->input('exp_year');
$exp_month = $request->input('exp_month');
$cvc = $request->input('cvc');
$name = $request->input('name');
$phone = $request->input('phone');
$email = $request->input('email');
$plan = $request->input('id_plan');
$empresa = $request->input('fqdn');
$password = $request->input('password');
$ip = $request->input('ip');
$tipo = $request->input('tipo');
$documento = $request->input('documento');
dd($plan);

 $client = new Client(['http_errors' => false]);
 $response = $client->post('https://api.secure.payco.co/v1/auth/login', [
  'form_params' => [
  'public_key' => '00183a3712a6c49a93ebe60d06613558',
  'private_key' => 'b536c266cd1705b261e9b76a7f44660f',
  ],
 ]);
 $xml = json_decode($response->getBody()->getContents(), true);
 $token = $xml['bearer_token'];
 $tok = "Bearer"." ".$token;

 $responsed = $client->post('https://api.secure.payco.co/v1/tokens', [
  'headers' => [
  'Authorization' =>  $tok,
  'Content-Type' => 'application/json',
  'Accept' => 'application/json',
  'Type' => 'sdk-jwt',
  ],
  'json' => [
  'card[number]' => $card_number,
  'card[exp_year]' => $exp_year,
  'card[exp_month]' => $exp_month,
  'card[cvc]' => $cvc,
  ],
 ]);
 $xmls = json_decode($responsed->getBody()->getContents(), true);

if($xmls['data']['status'] == 'error'){

return Redirect('/suscripcion/servicio')->with('status', 'ko_datos')->withInput();
}
 $token_id = $xmls['id'];

 $responsedcus = $client->post('https://api.secure.payco.co/payment/v1/customer/create', [
  'headers' => [
  'Authorization' =>  $tok,
  'Content-Type' => 'application/json',
  'Accept' => 'application/json',
  'Type' => 'sdk-jwt',
  ],
  'json' => [
  'token_card' => $token_id,
  'name' => $name,
  'email' => $email,
  'phone' => $phone,
  'default' => 'true',
  ],
 ]);
 $xmlscus = json_decode($responsedcus->getBody()->getContents(), true);

$customer_id = $xmlscus['data']['customerId'];

 $responsedtok = $client->post('https://api.secure.payco.co/recurring/v1/subscription/create', [
  'headers' => [
  'Authorization' =>  $tok,
  'Content-Type' => 'application/json',
  'Accept' => 'application/json',
  'Type' => 'sdk-jwt',
  ],
  'json' => [
  'id_plan' => $plan,
  'customer' => $customer_id,
  'token_card' => $token_id,
  'doc_type' => 'CC',
  'doc_number' => '1014184224',
  'url_confirmation' => 'http://siteavanza.com/respuesta/informacion/',
  'method_confirmation' => 'POST',
  ],
 ]);
$xmlstok = json_decode($responsedtok->getBody()->getContents(), true);

 $responsecob = $client->post('https://api.secure.payco.co/payment/v1/charge/subscription/create', [
  'headers' => [
  'Authorization' =>  $tok,
  'Content-Type' => 'application/json',
  'Accept' => 'application/json',
  'Type' => 'sdk-jwt',
  ],
  'json' => [
  'id_plan' => $plan,
  'customer' => $customer_id,
  'token_card' => $token_id,
  'doc_type' => $tipo,
  'doc_number' => $documento,
  'url_response' => 'https:/secure.payco.co/restpagos/testRest/endpagopse.php',
  'url_confirmation' => 'http://siteavanza.com/respuesta/informacion/',
  'method_confirmation' => 'POST',
  'ip' => $ip,
  ],
 ]);
$xmlscob = json_decode($responsecob->getBody()->getContents(), true);


$plan = $xmlscob['subscription']['idPlan'];
$referencia = $xmlscob['data']['ref_payco'];
$valor = $xmlscob['data']['valor'];
$estado = $xmlscob['data']['estado'];
$autorizacion = $xmlscob['data']['autorizacion'];
$ip = $xmlscob['data']['ip'];
$tipo = $xmlscob['data']['tipo_doc'];
$documento = $xmlscob['data']['documento'];
$periodos = $xmlstok['current_period_end'];
$periodo =  \Carbon\Carbon::parse($periodos)->format('Y-m-d');

if($xmlscob['data']['estado'] == 'Aceptada'){
 Transaccion::insert(
    array('referencia' => $referencia,'valor' => $valor,'estado' => $estado,'request_id' => $autorizacion,'ip' => $ip, 'documento' => $documento,'tipo' => $tipo));
  $this->create($name, $email, $empresa, $password, $periodo, $plan);
}else{
 return Redirect('/respuesta/error/');
}

    $plantilla = \DigitalsiteSaaS\Pagina\Template::all();
    $menu = \DigitalsiteSaaS\Pagina\Page::whereNull('page_id')->orderBy('posta', 'desc')->get();
    $subtotal = $this->subtotal();
    $total = $this->total();
     return Redirect('/respuesta/suscripcion/'.$referencia)->with('referencia', $referencia)->with('valor', $valor)->with('estado', $estado)->with('autorizacion', $autorizacion)->with('ip', $ip)->with('tipo', $tipo)->with('documento', $documento)->with('plantilla', $plantilla)->with('menu', $menu)->with('subtotal', $subtotal)->with('total', $total);

}



      
    }


