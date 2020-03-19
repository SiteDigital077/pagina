<?php

namespace DigitalsiteSaaS\Pagina\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Maxi extends Model

{
	use UsesTenantConnection;

	protected $table = 'images';
	public $timestamps = false;

	public function contents(){

		return $this->belongsTo('Content');
	}

}


