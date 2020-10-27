<?php

namespace DigitalsiteSaaS\Pagina;

use Illuminate\Database\Eloquent\Model;


class Maxi extends Model

{


	protected $table = 'images';
	public $timestamps = false;

	public function contents(){

		return $this->belongsTo('Content');
	}

}


