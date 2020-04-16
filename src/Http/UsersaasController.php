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



    protected function create($name, $email, $empresa, $password, $periodo)
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
            ->update(['presentacion' => $periodo]);
    

        return Redirect('/gestion/registrosaas')->with('status', 'ok_create');
    }




public function suscripcion(Request $request){

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
  'url_confirmation' => 'http://sitedesarrollo.local/',
  'method_confirmation' => 'POST',
  ],
 ]);
$xmlstok = json_decode($responsedtok->getBody()->getContents(), true);
$periodos = $xmlstok['current_period_end'];
$periodo =  \Carbon\Carbon::parse($periodos)->format('Y-m-d');


$this->create($name, $email, $empresa, $password, $periodo);
}




      
    }

  

  


