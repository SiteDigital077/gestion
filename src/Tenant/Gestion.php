<?php

namespace DigitalsiteSaaS\Gestion\Tenant;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
class Gestion extends Model

{
	use UsesTenantConnection;
 protected $table = 'gestion_usuarios';
 public $timestamps = true;
}
