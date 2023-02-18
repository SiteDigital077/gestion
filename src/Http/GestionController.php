<?php

namespace DigitalsiteSaaS\Gestion\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DigitalsiteSaaS\Gestion\Gestion;
use DigitalsiteSaaS\Gestion\Producto;
use DigitalsiteSaaS\Gestion\Sector;
use DigitalsiteSaaS\Gestion\Referido;
use DigitalsiteSaaS\Gestion\Cantidad;
use DigitalsiteSaaS\Gestion\Propuesta;
use Input;
use DB;
use Illuminate\Support\Str;
use Mail;
use App\Mail\Productos;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use DigitalsiteSaaS\Carrito\Pais;

class GestionController extends Controller
{

  protected $tenantName = null;


public function __construct()
{
if(!session()->has('cart')) session()->has('cart', array());
$hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
        if ($hostname){
            $fqdn = $hostname->fqdn;
            $this->tenantName = explode(".", $fqdn)[0];
        }

}

 public function index(){
  if(!$this->tenantName){  
  $usuarios = Gestion::all();
  $sectores = Sector::all();
  $productos = Producto::all();
}else{
  $usuarios = \DigitalsiteSaaS\Gestion\Tenant\Gestion::orderBy('created_at', 'desc')->get();
  $sectores = \DigitalsiteSaaS\Gestion\Tenant\Sector::all();
  $productos = \DigitalsiteSaaS\Gestion\Tenant\Producto::all();
}
  return view('gestion::index')->with('usuarios', $usuarios)->with('sectores', $sectores)->with('productos', $productos);
 }


 public function create() {
  $interes = Input::get('interes');
  $data = json_encode($interes, true);
  $vowels = array('"', '[', ']');
  $onlyconsonants = str_replace($vowels, '', $data);
  if(!$this->tenantName){
  $gestion = new Gestion;
  }else{
  $gestion = new \DigitalsiteSaaS\Gestion\Tenant\Gestion;  
  }
  $gestion->tipo = Input::get('tipo');
  $gestion->fecha = Input::get('fecha');
  $gestion->valor = Input::get('valor');
  $gestion->nombre = Input::get('nombre');
  $gestion->apellido = Input::get('apellido');
  $gestion->empresa = Input::get('empresa');
  $gestion->direccion = Input::get('direccion');
  $gestion->slug = Str::slug($gestion->empresa);
  $gestion->nit = Input::get('nit');
  $gestion->email = Input:: get ('email');
  $gestion->numero = Input:: get ('numero');
  $gestion->interes = $onlyconsonants;
  $gestion->sector_id = Input:: get ('sector');
  $gestion->cantidad_id = Input:: get ('cantidad');
  $gestion->referido_id = Input:: get ('referido');
  $gestion->comentarios = Input:: get ('comentarios');
  $gestion->pais_id = Input:: get ('pais');
  $gestion->ciudad_id = Input:: get ('ciudad');
  $gestion->save();
  /*Mail::to(Input::get('email'))
  ->bcc('pruebas@hotmail.com')
  ->send(new Productos($gestion->slug));*/
  return Redirect('/gestion/comercial')->with('status', 'ok_create');
 }

public function editarusuario($id){
  $interes = Input::get('interes');
  $data = json_encode($interes, true);
  $vowels = array('"', '[', ']');
  $onlyconsonants = str_replace($vowels, '', $data);
  if(!$this->tenantName){
  $gestion = Gestion::find($id);
  }else{
  $gestion = \DigitalsiteSaaS\Gestion\Tenant\Gestion::find($id); 
  }
  $gestion->tipo = Input::get('tipo');
  $gestion->fecha = Input::get('fecha');
  $gestion->valor = Input::get('valor');
  $gestion->nombre = Input::get('nombre');
  $gestion->apellido = Input::get('apellido');
  $gestion->empresa = Input::get('empresa');
  $gestion->direccion = Input::get('direccion');
  $gestion->slug = Str::slug($gestion->empresa);
  $gestion->nit = Input::get('nit');
  $gestion->email = Input:: get ('email');
  $gestion->numero = Input:: get ('numero');
  $gestion->interes = $onlyconsonants;
  $gestion->sector_id = Input:: get ('sector');
  $gestion->cantidad_id = Input:: get ('cantidad');
  $gestion->referido_id = Input:: get ('referido');
  $gestion->comentarios = Input:: get ('comentarios');
  $gestion->pais_id = Input:: get ('pais');
  $gestion->ciudad_id = Input:: get ('ciudad');
  $gestion->save();
  return Redirect('/gestion/comercial')->with('status', 'ok_update');
 }


  public function createrecepcion() {
  if(!$this->tenantName){
  $gestion = new Gestion;
  }else{
  $gestion = new \DigitalsiteSaaS\Gestion\Tenant\Gestion;  
  }
  $gestion->nombre = Input::get('nombre');
  $gestion->apellido = Input::get('apellido');
  $gestion->empresa = Input::get('empresa');
  $gestion->direccion = Input::get('direccion');
  $gestion->slug = Str::slug($gestion->empresa);
  $gestion->nit = Input::get('nit');
  $gestion->email = Input:: get ('email');
  $gestion->numero = Input:: get ('numero');
  $gestion->interes = Input:: get ('interes');
  $gestion->sector_id = Input:: get ('sector');
  $gestion->cantidad_id = Input:: get ('cantidad');
  $gestion->referido_id = Input:: get ('utm_crm');
  $gestion->comentarios = Input:: get ('comentarios');
  $gestion->pais_id = Input:: get ('pais');
  $gestion->ciudad_id = Input:: get ('ciudad');
  $gestion->save();
  Mail::to(Input::get('email'))
  ->bcc('pruebas@hotmail.com')
  ->send(new Productos($gestion->slug));
  return Redirect('/gestion/comercial-recepcion')->with('status', 'ok_create');
 }

 public function registrarproductos() {
  if(!$this->tenantName){
  $gestion = new Producto; 
  }else{
  $gestion = new \DigitalsiteSaaS\Gestion\Tenant\Producto;  
  }
  $gestion->producto = Input::get('producto');
  $gestion->save();
  return Redirect('gestion/comercial/productos')->with('status', 'ok_create');
 }

  public function registrarcantidad() {
    if(!$this->tenantName){
  $gestion = new Cantidad;
  }else{
  $gestion = new \DigitalsiteSaaS\Gestion\Tenant\Cantidad;  
  }
  $gestion->cantidad = Input::get('cantidad');
  $gestion->save();
  return Redirect('gestion/comercial/cantidades')->with('status', 'ok_create');
 }





  public function registrarsector() {
  if(!$this->tenantName){
  $gestion = new Sector;
  }else{
   $gestion = new \DigitalsiteSaaS\Gestion\Tenant\Sector; 
  }
  $gestion->sectores = Input::get('sector');
  $gestion->save();
  return Redirect('/gestion/comercial/sectores')->with('status', 'ok_create');
 }

 public function registrarreferido() {
   if(!$this->tenantName){
  $gestion = new Referido;
  }else{
    $gestion = new \DigitalsiteSaaS\Gestion\Tenant\Referido;
  }
  $gestion->referidos = Input::get('referido');
  $gestion->save();
  return Redirect('/gestion/comercial/referidos')->with('status', 'ok_create');
 }

 public function crearsector() {
  return view('gestion::crear-sector');
 }

public function crearreferido() {
  return view('gestion::crear-referido');
 }

 public function crearcantidad() {
  return view('gestion::crear-cantidad');
 }

 public function productos(){
  if(!$this->tenantName){
  $productos = Producto::all();
  }else{
     $productos = \DigitalsiteSaaS\Gestion\Tenant\Producto::all();
  }
  return view('gestion::productos')->with('productos', $productos);
 }

 public function sectores(){
  if(!$this->tenantName){
  $sectores = Sector::all();
  }else{
  $sectores = \DigitalsiteSaaS\Gestion\Tenant\Sector::all(); 
  }
  return view('gestion::sectores')->with('sectores', $sectores);
 }

 public function cantidades(){
  if(!$this->tenantName){
  $cantidades = Cantidad::all();
  }else{
    $cantidades = \DigitalsiteSaaS\Gestion\Tenant\Cantidad::all();
  }
  return view('gestion::cantidades')->with('cantidades', $cantidades);
 }

 public function referidos(){
  if(!$this->tenantName){
  $referidos = Referido::all();
  }else{
   $referidos = \DigitalsiteSaaS\Gestion\Tenant\Referido::all(); 
  }
  return view('gestion::referidos')->with('referidos', $referidos);
 }

 public function crearproductos(){
  return view('gestion::crear-productos');
 }

 public function dashboard(){


$total_usuarios = \DigitalsiteSaaS\Gestion\Tenant\Gestion::count();

$total_propuestas = \DigitalsiteSaaS\Gestion\Tenant\Propuesta::sum('valor_propuesta');
$total_proceso = \DigitalsiteSaaS\Gestion\Tenant\Propuesta::where('estado_propuesta','=','1')->sum('valor_propuesta');
$total_ganadas = \DigitalsiteSaaS\Gestion\Tenant\Propuesta::where('estado_propuesta','=','3')->sum('valor_propuesta');

$estado_usuario = \DigitalsiteSaaS\Gestion\Tenant\Gestion::select('tipo')
->selectRaw('count(tipo) as tipo_sum')
->groupBy('tipo')
->get();

$productos = \DigitalsiteSaaS\Gestion\Tenant\Gestion::leftjoin('gestion_productos','gestion_usuarios.interes','=','gestion_productos.id')
->select('producto')
->selectRaw('count(producto) as productos_sum')
->groupBy('producto')
->orderBy('producto', 'desc')
->get();

$sectores = \DigitalsiteSaaS\Gestion\Tenant\Gestion::leftjoin('gestion_sector','gestion_usuarios.sector_id','=','gestion_sector.id')
->select('sectores')
->selectRaw('count(sectores) as sectores_sum')
->groupBy('sectores')
->orderBy('sectores', 'desc')
->get();

$referidos = \DigitalsiteSaaS\Gestion\Tenant\Gestion::leftjoin('gestion_referidos','gestion_usuarios.sector_id','=','gestion_referidos.id')
->select('referidos')
->selectRaw('count(referidos) as referidos_sum')
->groupBy('referidos')
->orderBy('referidos', 'desc')
->get();

$cantidades = \DigitalsiteSaaS\Gestion\Tenant\Gestion::leftjoin('gestion_cantidad','gestion_usuarios.cantidad_id','=','gestion_cantidad.id')
->select('cantidad')
->selectRaw('count(cantidad) as cantidad_sum')
->groupBy('cantidad')
->orderBy('cantidad', 'desc')
->get();

$ciudades = \DigitalsiteSaaS\Gestion\Tenant\Gestion::leftjoin('departamentos','gestion_usuarios.ciudad_id','=','departamentos.id')
->select('departamento')
->selectRaw('count(departamento) as ciudad_sum')
->groupBy('departamento')
->orderBy('departamento', 'desc')
->get();

     
return view('gestion::dashboard')->with('total_usuarios', $total_usuarios)->with('estado_usuario', $estado_usuario)->with('productos', $productos)->with('referidos', $referidos)->with('ciudades', $ciudades)->with('total_propuestas', $total_propuestas)->with('total_proceso', $total_proceso)->with('total_ganadas', $total_ganadas);
 }

 public function registro(){
   if(!$this->tenantName){
 $productos = Producto::all();
 $sectores = Sector::all();
 $referidos = Referido::all();
 $cantidades = Cantidad::all();
 $paises = Pais::orderBy('pais', 'ASC')->get();
}else{
$productos = \DigitalsiteSaaS\Gestion\Tenant\Producto::all();
 $sectores = \DigitalsiteSaaS\Gestion\Tenant\Sector::all();
 $referidos = \DigitalsiteSaaS\Gestion\Tenant\Referido::all();
 $cantidades = \DigitalsiteSaaS\Gestion\Tenant\Cantidad::all();
 $paises = \DigitalsiteSaaS\Carrito\Tenant\Pais::orderBy('pais', 'ASC')->get();

}
 return view('gestion::registrar')->with('productos', $productos)->with('sectores', $sectores)->with('referidos', $referidos)->with('cantidades', $cantidades)->with('paises', $paises);
 }


 public function edito($id){
   if(!$this->tenantName){
 $usuarios = Gestion::join('gestion_productos','gestion_usuarios.interes','=','gestion_productos.id')
 ->join('gestion_sector','gestion_usuarios.sector','=','gestion_sector.id')
 ->where('gestion_usuarios.id', '=', $id)->get();
 $productos = Producto::all();
 $sectores = Sector::all();
}else{
$usuarios = \DigitalsiteSaaS\Gestion\Tenant\Gestion::join('gestion_productos','gestion_usuarios.interes','=','gestion_productos.id')
 ->join('gestion_sector','gestion_usuarios.sector','=','gestion_sector.id')
 ->where('gestion_usuarios.id', '=', $id)->get();
 $productos = \DigitalsiteSaaS\Gestion\Tenant\Producto::all();
 $sectores = \DigitalsiteSaaS\Gestion\Tenant\Sector::all();

}
 return view('gestion::editar-registro')->with('productos', $productos)->with('sectores', $sectores)->with('usuarios', $usuarios);
}


 public function editarcan($id){
 if(!$this->tenantName){
 $cantidad = Cantidad::where('id', '=', $id)->get();
 }else{
 $cantidad = \DigitalsiteSaaS\Gestion\Tenant\Cantidad::where('id', '=', $id)->get();
 }
 return view('gestion::editar-cantidad')->with('cantidad', $cantidad);
}

 public function propuesta($id){
 if(!$this->tenantName){
 $propuesta = Propuesta::leftjoin('gestion_productos','gestion_propuestas.producto_servicio','=','gestion_productos.id')
 ->whereIn('gestion_propuestas.gestion_usuario_id', '=', $id)
 ->get();
  foreach($propuesta as $propuestas){
  $items = str_replace('"', '', $propuestas->producto_servicio);

 $productos =  Producto::whereIn('id', array('1,2'))->get();
 }
 }else{
 $propuesta = \DigitalsiteSaaS\Gestion\Tenant\Propuesta::leftjoin('gestion_productos','gestion_propuestas.producto_servicio','=','gestion_productos.id')
 ->where('gestion_propuestas.gestion_usuario_id', '=', $id)
 ->get();

 foreach($propuesta as $propuestas){
  $items = str_replace('"', '', $propuestas->producto_servicio);

 $productos =  \DigitalsiteSaaS\Gestion\Tenant\Producto::whereIn('id', array('1,2'))->get();
 }

 }
 return view('gestion::propuesta')->with('propuesta', $propuesta);
}


 public function editarpropuesta($id){
 if(!$this->tenantName){
 $propuesta = Propuesta::leftjoin('gestion_productos','gestion_propuestas.producto_servicio','=','gestion_productos.id')
 ->whereIn('gestion_propuestas.gestion_usuario_id', '=', $id)
 ->get();

 $intereses = Gestion::where('id','=',$id)->get();
 foreach ($intereses as $interes){
 $ideman = $interes->interes;
 $id_str = explode(',', $ideman);
 $productosa = Producto::whereIn('id', $id_str)->get();
 $productos = Producto::whereNotIn('id',$id_str)->get();
 }
 }else{
 $propuesta = \DigitalsiteSaaS\Gestion\Tenant\Propuesta::lefjoin('gestion_productos','gestion_propuestas.producto_servicio','=','gestion_productos.id')
 ->where('gestion_propuestas.gestion_usuario_id', '=', $id)
 ->get();

$intereses = \DigitalsiteSaaS\Gestion\Tenant\Gestion::where('id','=',$id)->get();
 foreach ($intereses as $interes){
 $ideman = $interes->interes;
 $id_str = explode(',', $ideman);
 $productosa = \DigitalsiteSaaS\Gestion\Tenant\Producto::whereIn('id', $id_str)->get();
 $productos = \DigitalsiteSaaS\Gestion\Tenant\Producto::whereNotIn('id',$id_str)->get();
 }
 }

 return view('gestion::editar-propuesta')->with('propuesta', $propuesta)->with('productos', $productos)->with('productos', $productos)->with('productosa', $productosa);
}


public function crearpropuesta($id){
 if(!$this->tenantName){
 $productos = Producto::all(); 
 }else{
 $productos = \DigitalsiteSaaS\Gestion\Tenant\Producto::all(); 
 }
 return view('gestion::crear-propuesta')->with('productos', $productos);
}

 public function crearpropuestanew() {
  if(!$this->tenantName){
  $gestion = new Propuesta;
  }else{
  $gestion = new \DigitalsiteSaaS\Gestion\Tenant\Propuesta;  
  }
  $gestion->estado_propuesta = Input::get('tipo');
  $gestion->valor_propuesta = Input::get('valor');
  $gestion->fecha_presentacion = Input::get('fecha');
  $gestion->producto_servicio = Input::get('intereses');
  $gestion->observaciones = Input::get('comentarios');
  $gestion->gestion_usuario_id = Input::get('cliente');
  $gestion->save();
  return Redirect('/gestion/comercial')->with('status', 'ok_create');
 }

 public function portafolio($id){
 if(!$this->tenantName){
 $empresa = Gestion::where('slug','=',$id)->get();
 }else{
 $empresa = \DigitalsiteSaaS\Gestion\Tenant\Gestion::where('slug','=',$id)->get();
 }
 return view('gestion::portafolio', compact('empresa'));
}

public function editreferido($id){
 if(!$this->tenantName){
 $referido = Referido::where('id', '=', $id)->get();
 }else{
 $referido = \DigitalsiteSaaS\Gestion\Tenant\Referido::where('id', '=', $id)->get();
 }
 return view('gestion::editar-referido')->with('referido', $referido);
}

public function editsector($id){
 if(!$this->tenantName){
 $sector = Sector::where('id', '=', $id)->get();
 }else{
 $sector = \DigitalsiteSaaS\Gestion\Tenant\Sector::where('id', '=', $id)->get();
 }
 return view('gestion::editar-sector')->with('sector', $sector);
}

public function editproducto($id){
 if(!$this->tenantName){
 $producto = Producto::where('id', '=', $id)->get();
 }else{
 $producto = \DigitalsiteSaaS\Gestion\Tenant\Producto::where('id', '=', $id)->get();
 }
 return view('gestion::editar-producto')->with('producto', $producto);
}


public function valida(){
 if(!$this->tenantName){
 $user = Gestion::where('nit', Input::get('nit'))->count();
 }else{
 $user = \DigitalsiteSaaS\Gestion\Tenant\Gestion::where('nit', Input::get('nit'))->count();
 }
 if($user > 0) {
        $isAvailable = FALSE;
    } else {
        $isAvailable = TRUE;
    }
    echo json_encode(
            array(
                'valid' => $isAvailable
            )); 
 
}



public function editrecepcion($id){
 if(!$this->tenantName){
 $usuario = Gestion::join('gestion_cantidad', 'gestion_cantidad.id', '=', 'gestion_usuarios.cantidad_id')
 ->leftjoinjoin('gestion_referidos', 'gestion_referidos.id', '=', 'gestion_usuarios.referido_id')
 ->leftjoinjoin('gestion_sector', 'gestion_sector.id', '=', 'gestion_usuarios.sector_id')
 ->leftjoinjoin('gestion_productos', 'gestion_productos.id', '=', 'gestion_usuarios.interes')
 ->leftjoin('paises', 'paises.id', '=', 'gestion_usuarios.pais_id')
 ->leftjoin('departamentos', 'departamentos.id', '=', 'gestion_usuarios.ciudad_id')
 ->where('gestion_usuarios.id', '=', $id)->get();
 $sectores = Sector::all();
 $referidos = Referido::all();
 $cantidades = Cantidad::all();
 $paises = DB::table('paises')->orderBy('pais', 'ASC')->get();
 $intereses = Gestion::where('id','=',$id)->get();
 foreach ($intereses as $interes){
 $ideman = $interes->interes;
 $id_str = explode(',', $ideman);
 $productosa = Producto::whereIn('id', $id_str)->get();
 $productos = Producto::whereNotIn('id',$id_str)->get();
 }
 }else{
 $usuario = \DigitalsiteSaaS\Gestion\Tenant\Gestion::join('gestion_cantidad', 'gestion_cantidad.id', '=', 'gestion_usuarios.cantidad_id')
 ->leftjoin('gestion_referidos', 'gestion_referidos.id', '=', 'gestion_usuarios.referido_id')
 ->leftjoin('gestion_sector', 'gestion_sector.id', '=', 'gestion_usuarios.sector_id')
 ->leftjoin('gestion_productos', 'gestion_productos.id', '=', 'gestion_usuarios.interes')
 ->leftjoin('paises', 'paises.id', '=', 'gestion_usuarios.pais_id')
 ->leftjoin('departamentos', 'departamentos.id', '=', 'gestion_usuarios.ciudad_id')
 ->where('gestion_usuarios.id', '=', $id)->get();
 $sectores = \DigitalsiteSaaS\Gestion\Tenant\Sector::all();
 $referidos = \DigitalsiteSaaS\Gestion\Tenant\Referido::all();
 $cantidades = \DigitalsiteSaaS\Gestion\Tenant\Cantidad::all();
 $paises = DB::table('paises')->orderBy('pais', 'ASC')->get();
 $intereses = \DigitalsiteSaaS\Gestion\Tenant\Gestion::where('id','=',$id)->get();
 foreach ($intereses as $interes){
 $ideman = $interes->interes;
 $id_str = explode(',', $ideman);
 $productosa = \DigitalsiteSaaS\Gestion\Tenant\Producto::whereIn('id', $id_str)->get();
 $productos = \DigitalsiteSaaS\Gestion\Tenant\Producto::whereNotIn('id',$id_str)->get();
 }
}
 return view('gestion::editar-usuario')->with('usuario', $usuario)->with('productos', $productos)->with('productosa', $productosa)->with('sectores', $sectores)->with('id_str', $id_str)->with('referidos', $referidos)->with('cantidades', $cantidades)->with('paises', $paises);
}





 public function recepcion(){
  if(!$this->tenantName){
  $usuarios = Gestion::all();
  $sectores = Sector::all();
  $productos = Producto::all();
  }else{
   $usuarios = \DigitalsiteSaaS\Gestion\Tenant\Gestion::all();
  $sectores = \DigitalsiteSaaS\Gestion\Tenant\Sector::all();
  $productos = \DigitalsiteSaaS\Gestion\Tenant\Producto::all(); 
  }
  return view('gestion::index-recepcion')->with('usuarios', $usuarios)->with('sectores', $sectores)->with('productos', $productos);
 }

 public function registrarecepcion() {
  if(!$this->tenantName){
  $gestion = new Gestion;
  }else{
  $gestion = new \DigitalsiteSaaS\Gestion\Tenant\Gestion;  
  }
  $gestion->nombre = Input::get('nombre');
  $gestion->apellido = Input::get('apellido');
  $gestion->empresa = Input::get('empresa');
  $gestion->nit = Input::get('nit');
  $gestion->email = Input:: get ('email');
  $gestion->numero = Input:: get ('numero');
  $gestion->interes = Input:: get ('interes');
  $gestion->interes = Input:: get ('sector');
  $gestion->save();
  return Redirect('/gestion/comercial')->with('status', 'ok_create');
 }

 public function edit($id){
  if(!$this->tenantName){
  $gestion = Gestion::find($id);
  }else{
  $gestion = \DigitalsiteSaaS\Gestion\Tenant\Gestion::find($id);  
  }
  $gestion->nombre = Input::get('nombre');
  $gestion->apellido = Input::get('apellido');
  $gestion->empresa = Input::get('empresa');
  $gestion->nit = Input::get('nit');
  $gestion->email = Input:: get ('email');
  $gestion->numero = Input:: get ('numero');
  $gestion->interes = Input:: get ('interes');
  $gestion->sector = Input:: get ('sector');
  $gestion->save();
  return Redirect('/gestion/comercial')->with('status', 'ok_update');
 }


  public function editarcantidad($id){
  if(!$this->tenantName){
  $gestion = Cantidad::find($id);
  }else{
  $gestion = \DigitalsiteSaaS\Gestion\Tenant\Cantidad::find($id);
  }    
  $gestion->cantidad = Input::get('cantidad');
  $gestion->save();
  return Redirect('/gestion/comercial/cantidades')->with('status', 'ok_update');
 }

  public function editarpropuestaa($id){
  $interes = Input::get('interes');
  $data = json_encode($interes, true);
  $vowels = array('"', '[', ']');
  $onlyconsonants = str_replace($vowels, '', $data);
  if(!$this->tenantName){
  $propuesta = Propuesta::find($id);
  }else{
  $propuesta = \DigitalsiteSaaS\Gestion\Tenant\Propuesta::find($id);
  }
  $propuesta->estado_propuesta = Input::get('tipo');
  $propuesta->valor_propuesta = Input::get('valor');
  $propuesta->fecha_presentacion = Input::get('fecha');
  $propuesta->producto_servicio = $onlyconsonants;
  $propuesta->observaciones = Input::get('comentarios');
  $propuesta->gestion_usuario_id = Input::get('cliente');
  $propuesta->save();
  return Redirect('gestion/comercial/propuesta/1')->with('status', 'ok_update');
 }

 public function editarreferido($id){
  if(!$this->tenantName){
  $gestion = Referido::find($id); 
  }else{
  $gestion = \DigitalsiteSaaS\Gestion\Tenant\Referido::find($id);   
  }
  $gestion->referidos = Input::get('referido');
  $gestion->save();
  return Redirect('/gestion/comercial/referidos')->with('status', 'ok_update');
 }

 public function editarsector($id){
  if(!$this->tenantName){
  $gestion = Sector::find($id);
  }else{
  $gestion = \DigitalsiteSaaS\Gestion\Tenant\Sector::find($id);  
  }
  $gestion->sectores = Input::get('sector');
  $gestion->save();
  return Redirect('/gestion/comercial/sectores')->with('status', 'ok_update');
 }

 public function editarproducto($id){
  if(!$this->tenantName){
  $gestion = Producto::find($id);
  }else{
     $gestion = \DigitalsiteSaaS\Gestion\Tenant\Producto::find($id);
  }
  $gestion->producto = Input::get('producto');
  $gestion->save();
  return Redirect('/gestion/comercial/productos')->with('status', 'ok_update');
 }

  public function editrec($id){
    if(!$this->tenantName){
  $gestion = Gestion::find($id);
  }else{
  $gestion = \DigitalsiteSaaS\Gestion\Tenant\Gestion::find($id);   
  }
  $gestion->nombre = Input::get('nombre');
  $gestion->apellido = Input::get('apellido');
  $gestion->empresa = Input::get('empresa');
  $gestion->direccion = Input::get('direccion');
  $gestion->nit = Input::get('nit');
  $gestion->email = Input:: get ('email');
  $gestion->numero = Input:: get ('numero');
  $gestion->interes = Input:: get ('interes');
  $gestion->sector_id = Input:: get ('sector');
  $gestion->cantidad_id = Input:: get ('cantidad');
  $gestion->referido_id = Input:: get ('utm_crm');
  $gestion->comentarios = Input:: get ('comentarios');
  $gestion->pais_id = Input:: get ('pais');
  $gestion->ciudad_id = Input:: get ('ciudad');
  $gestion->save();
  return Redirect('/gestion/comercial-recepcion')->with('status', 'ok_update');
 }

  public function eliminar($id){
    if(!$this->tenantName){
   $gestion = Gestion::find($id);
 }else{
  $gestion = \DigitalsiteSaaS\Gestion\Tenant\Gestion::find($id);
 }
   $gestion->delete();
 
  return Redirect('/gestion/comercial')->with('status', 'ok_delete');
 }

 public function eliminarproducto($id){
   if(!$this->tenantName){
   $gestion = Producto::find($id);
   }else{
 $gestion = \DigitalsiteSaaS\Gestion\Tenant\Producto::find($id);
   }
   $gestion->delete();
  return Redirect('/gestion/comercial/productos')->with('status', 'ok_delete');
 }

 public function eliminarsector($id){
   if(!$this->tenantName){
   $gestion = Sector::find($id);
   }else{
    $gestion = \DigitalsiteSaaS\Gestion\Tenant\Sector::find($id);
   }
   $gestion->delete();
  return Redirect('/gestion/comercial/sectores')->with('status', 'ok_delete');
 }

 public function eliminarreferido($id){
   if(!$this->tenantName){
   $gestion = Referido::find($id);
   }else{
   $gestion = \DigitalsiteSaaS\Gestion\Tenant\Referido::find($id); 
   }
   $gestion->delete();
  return Redirect('/gestion/comercial/referidos')->with('status', 'ok_delete');
 }

 public function eliminarcantidad($id){
   if(!$this->tenantName){
   $gestion = Cantidad::find($id);
   }else{
    $gestion = \DigitalsiteSaaS\Gestion\Tenant\Cantidad::find($id);
   }
   $gestion->delete();
  return Redirect('/gestion/comercial/cantidades')->with('status', 'ok_delete');
 }

}




