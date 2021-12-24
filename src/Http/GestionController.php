<?php

namespace DigitalsiteSaaS\Gestion\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DigitalsiteSaaS\Gestion\Gestion;
use DigitalsiteSaaS\Gestion\Producto;
use DigitalsiteSaaS\Gestion\Sector;
use DigitalsiteSaaS\Gestion\Referido;
use DigitalsiteSaaS\Gestion\Cantidad;
use Input;
use DB;
use Illuminate\Support\Str;
use Mail;
use App\Mail\Productos;

class GestionController extends Controller
{
 public function index(){
  $usuarios = DB::table('gestion_usuarios')->get();
  $sectores = DB::table('gestion_sector')->get();
  $productos = DB::table('gestion_productos')->get();
  return view('gestion::index')->with('usuarios', $usuarios)->with('sectores', $sectores)->with('productos', $productos);
 }

 public function create() {
  $interes = Input::get('interes');
  $data = json_encode($interes, true);
  $vowels = array('"', '[', ']');
  $onlyconsonants = str_replace($vowels, '', $data);
  $gestion = new Gestion;
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
  $gestion = Gestion::find($id);
  $gestion->nombre = Input::get('nombre');
  $gestion->apellido = Input::get('apellido');
  $gestion->empresa = Input::get('empresa');
  $gestion->direccion = Input::get('direccion');
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
  $gestion = new Gestion;
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
  $gestion->referido_id = Input:: get ('referido');
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
  $gestion = new Producto;
  $gestion->producto = Input::get('producto');
  $gestion->save();
  return Redirect('gestion/comercial/productos')->with('status', 'ok_create');
 }

  public function registrarcantidad() {
  $gestion = new Cantidad;
  $gestion->cantidad = Input::get('cantidad');
  $gestion->save();
  return Redirect('gestion/comercial/cantidades')->with('status', 'ok_create');
 }

  public function registrarsector() {
  $gestion = new Sector;
  $gestion->sectores = Input::get('sector');
  $gestion->save();
  return Redirect('/gestion/comercial/sectores')->with('status', 'ok_create');
 }

 public function registrarreferido() {
  $gestion = new Referido;
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
  $productos = DB::table('gestion_productos')->get();
  return view('gestion::productos')->with('productos', $productos);
 }

 public function sectores(){
  $sectores = DB::table('gestion_sector')->get();
  return view('gestion::sectores')->with('sectores', $sectores);
 }

 public function cantidades(){
  $cantidades = DB::table('gestion_cantidad')->get();
  return view('gestion::cantidades')->with('cantidades', $cantidades);
 }

 public function referidos(){
  $referidos = DB::table('gestion_referidos')->get();
  return view('gestion::referidos')->with('referidos', $referidos);
 }

 public function crearproductos(){
  return view('gestion::crear-productos');
 }


 public function recepcion(){
  $usuarios = DB::table('gestion_usuarios')->get();
  $sectores = DB::table('gestion_sector')->get();
  $productos = DB::table('gestion_productos')->get();
  return view('gestion::index-recepcion')->with('usuarios', $usuarios)->with('sectores', $sectores)->with('productos', $productos);
 }

 public function registrarecepcion() {
  $gestion = new Gestion;
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
  $gestion = Gestion::find($id);
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
  $gestion = Cantidad::find($id);
  $gestion->cantidad = Input::get('cantidad');
  $gestion->save();
  return Redirect('/gestion/comercial/cantidades')->with('status', 'ok_update');
 }

 public function editarreferido($id){
  $gestion = Referido::find($id);
  $gestion->referidos = Input::get('referido');
  $gestion->save();
  return Redirect('/gestion/comercial/referidos')->with('status', 'ok_update');
 }

 public function editarsector($id){
  $gestion = Sector::find($id);
  $gestion->sectores = Input::get('sector');
  $gestion->save();
  return Redirect('/gestion/comercial/sectores')->with('status', 'ok_update');
 }

 public function editarproducto($id){
  $gestion = Producto::find($id);
  $gestion->producto = Input::get('producto');
  $gestion->save();
  return Redirect('/gestion/comercial/productos')->with('status', 'ok_update');
 }

  public function editrec($id){
  $gestion = Gestion::find($id);
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
  $gestion->referido_id = Input:: get ('referido');
  $gestion->comentarios = Input:: get ('comentarios');
  $gestion->pais_id = Input:: get ('pais');
  $gestion->ciudad_id = Input:: get ('ciudad');
  $gestion->save();
  return Redirect('/gestion/comercial-recepcion')->with('status', 'ok_update');
 }

  public function eliminar($id){
   $gestion = Gestion::find($id);
   $gestion->delete();
  return Redirect('/gestion/comercial')->with('status', 'ok_delete');
 }

 public function eliminarproducto($id){
   $gestion = Producto::find($id);
   $gestion->delete();
  return Redirect('/gestion/comercial/productos')->with('status', 'ok_delete');
 }

 public function eliminarsector($id){
   $gestion = Sector::find($id);
   $gestion->delete();
  return Redirect('/gestion/comercial/sectores')->with('status', 'ok_delete');
 }

 public function eliminarreferido($id){
   $gestion = Referido::find($id);
   $gestion->delete();
  return Redirect('/gestion/comercial/referidos')->with('status', 'ok_delete');
 }

 public function eliminarcantidad($id){
   $gestion = Cantidad::find($id);
   $gestion->delete();
  return Redirect('/gestion/comercial/cantidades')->with('status', 'ok_delete');
 }

}




