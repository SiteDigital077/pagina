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
use Redirect;

class UsersaasController extends Controller
{
    
use RegistersUsers;

  protected $tenantName = null;

  public function __construct()
    {
        $this->middleware('auth');

        $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
        if ($hostname){
            $fqdn = $hostname->fqdn;
            $this->tenantName = explode(".", $fqdn)[0];
        }
       
    }
  
  public function showRegistrationForm(){
        return view('auth.register')->with('tenantName', $this->tenantName);
    }



    protected function create()
    {
      
       $metrica = User::create([
           'name' => Input::get('name'),
           'email' => Input::get('email'),
           'password' => Hash::make(Input::get('password')),
        ]);

       	

        $fqdn = sprintf('%s.%s', Input::get('fqdn'), env('APP_DOMAIN'));
       
        $website = new Website;
        $website->uuid = Str::random(10);
        app(WebsiteRepository::class)->create($website);
        $hostname = new Hostname();
        $hostname->fqdn = $fqdn;
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
  

        $update = User::where('id', $metrica->id)
            ->update(['saas_id' => $hostname->id,]);


        return Redirect('/gestion/registrosaas')->with('status', 'ok_create');
    }


      
    }

  

  


