
<?php

namespace DigitalsiteSaaS\Gestion\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Message extends Model

{
	use UsesTenantConnection;

	protected $fillable = [
    'nombre', 'apellido', 'empresa', 'direccion', 'email', 'numero', 'interes','sector_id','cantidad_id','referido_id','pais_id','ciudad_id','comentarios','estado','nit','tipo',
    ];

	protected $table = 'gestion_usuarios';
	public $timestamps = true;

	
}



