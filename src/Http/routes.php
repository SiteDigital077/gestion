<?php
Route::group(['middleware' => ['auths','administrador']], function (){

Route::get('gestion/crear-pais', function(){
    return View::make('pagina::configuracion.crear-pais');
});

Route::post('gestion/crearpais', 'DigitalsiteSaaS\Pagina\Http\ConfiguracionController@crearpais'); 
Route::post('gestion/actualizarpais', 'DigitalsiteSaaS\Pagina\Http\ConfiguracionController@crearpais'); 

Route::get('gestion/comercial/registro', function(){
 $productos = DB::table('gestion_productos')->get();
 $sectores = DB::table('gestion_sector')->get();
 $referidos = DB::table('gestion_referidos')->get();
 $cantidades = DB::table('gestion_cantidad')->get();
 $paises = DB::table('paises')->orderBy('pais', 'ASC')->get();
 return View::make('gestion::registrar')->with('productos', $productos)->with('sectores', $sectores)->with('referidos', $referidos)->with('cantidades', $cantidades)->with('paises', $paises);
});

Route::get('gestion/comercial/editar/{id}', function($id){
 $usuarios = DB::table('gestion_usuarios')
 ->join('gestion_productos','gestion_usuarios.interes','=','gestion_productos.id')
 ->join('gestion_sector','gestion_usuarios.sector','=','gestion_sector.id')
 ->where('gestion_usuarios.id', '=', $id)->get();
 $productos = DB::table('gestion_productos')->get();
 $sectores = DB::table('gestion_sector')->get();
 return View::make('gestion::editar-registro')->with('productos', $productos)->with('sectores', $sectores)->with('usuarios', $usuarios);
});


Route::get('gestion/comercial/editar-cantidades/{id}', function($id){
 $cantidad = DB::table('gestion_cantidad')->where('id', '=', $id)->get();
 return View::make('gestion::editar-cantidad')->with('cantidad', $cantidad);
});

Route::get('portafolio/{id}', function ($id) {

$empresa = DB::table('gestion_usuarios')->where('slug','=',$id)->get();

      return view('gestion::portafolio', compact('empresa'));


});




Route::get('gestion/comercial/editar-referido/{id}', function($id){
 $referido = DB::table('gestion_referidos')->where('id', '=', $id)->get();
 return View::make('gestion::editar-referido')->with('referido', $referido);
});

Route::get('gestion/comercial/editar-sector/{id}', function($id){
 $sector = DB::table('gestion_sector')->where('id', '=', $id)->get();
 return View::make('gestion::editar-sector')->with('sector', $sector);
});

Route::get('gestion/comercial/editar-producto/{id}', function($id){
 $producto = DB::table('gestion_productos')->where('id', '=', $id)->get();
 return View::make('gestion::editar-producto')->with('producto', $producto);
});


Route::get('gestion/comercial/editar-recepcion/{id}', function($id){
 $usuario = DB::table('gestion_usuarios')
 ->join('gestion_cantidad', 'gestion_cantidad.id', '=', 'gestion_usuarios.cantidad_id')
 ->join('gestion_referidos', 'gestion_referidos.id', '=', 'gestion_usuarios.referido_id')
 ->join('gestion_sector', 'gestion_sector.id', '=', 'gestion_usuarios.sector_id')
 ->join('gestion_productos', 'gestion_productos.id', '=', 'gestion_usuarios.interes')
 ->leftjoin('paises', 'paises.id', '=', 'gestion_usuarios.pais_id')
 ->leftjoin('departamentos', 'departamentos.id', '=', 'gestion_usuarios.ciudad_id')
 ->where('gestion_usuarios.id', '=', $id)->get();
 $productos = DB::table('gestion_productos')->get();
 $sectores = DB::table('gestion_sector')->get();
 $referidos = DB::table('gestion_referidos')->get();
 $cantidades = DB::table('gestion_cantidad')->get();
 $paises = DB::table('paises')->orderBy('pais', 'ASC')->get();
 return View::make('gestion::editar-usuario')->with('usuario', $usuario)->with('productos', $productos)->with('sectores', $sectores)->with('referidos', $referidos)->with('cantidades', $cantidades)->with('paises', $paises);
});



Route::post('gestion/comercial/editarcantidad/{id}', 'DigitalsiteSaaS\Gestion\Http\GestionController@editarcantidad');
Route::post('gestion/comercial/editarreferido/{id}', 'DigitalsiteSaaS\Gestion\Http\GestionController@editarreferido');
Route::post('gestion/comercial/editarsector/{id}', 'DigitalsiteSaaS\Gestion\Http\GestionController@editarsector');
Route::post('gestion/comercial/editarproducto/{id}', 'DigitalsiteSaaS\Gestion\Http\GestionController@editarproducto');
Route::post('gestion/comercial/editarusuario/{id}', 'DigitalsiteSaaS\Gestion\Http\GestionController@editarusuario');

Route::resource('gestion/comercial/editar-usuario', 'DigitalsiteSaaS\Gestion\Http\GestionController@edit');
Route::resource('gestion/comercial/eliminar', 'DigitalsiteSaaS\Gestion\Http\GestionController@eliminar');
Route::get('gestion/comercial/eliminar-producto/{id}', 'DigitalsiteSaaS\Gestion\Http\GestionController@eliminarproducto');
Route::get('gestion/comercial/eliminar-sector/{id}', 'DigitalsiteSaaS\Gestion\Http\GestionController@eliminarsector');
Route::get('gestion/comercial/eliminar-referido/{id}', 'DigitalsiteSaaS\Gestion\Http\GestionController@eliminarreferido');
Route::get('gestion/comercial/eliminar-cantidades/{id}', 'DigitalsiteSaaS\Gestion\Http\GestionController@eliminarcantidad');
Route::get('gestion/comercial/productos', 'DigitalsiteSaaS\Gestion\Http\GestionController@productos');
Route::get('gestion/comercial/crear-producto', 'DigitalsiteSaaS\Gestion\Http\GestionController@crearproductos');
Route::get('gestion/comercial/crear-sector', 'DigitalsiteSaaS\Gestion\Http\GestionController@crearsector');
Route::get('gestion/comercial/crear-referido', 'DigitalsiteSaaS\Gestion\Http\GestionController@crearreferido');
Route::get('gestion/comercial/crear-cantidad', 'DigitalsiteSaaS\Gestion\Http\GestionController@crearcantidad');
Route::post('gestion/registrar/sector', 'DigitalsiteSaaS\Gestion\Http\GestionController@registrarsector');
Route::post('gestion/registrar/referido', 'DigitalsiteSaaS\Gestion\Http\GestionController@registrarreferido');

Route::post('gestion/registrar/producto', 'DigitalsiteSaaS\Gestion\Http\GestionController@registrarproductos');
Route::post('gestion/registrar/cantidad', 'DigitalsiteSaaS\Gestion\Http\GestionController@registrarcantidad');
Route::get('gestion/comercial/sectores', 'DigitalsiteSaaS\Gestion\Http\GestionController@sectores');
Route::get('gestion/comercial/cantidades', 'DigitalsiteSaaS\Gestion\Http\GestionController@cantidades');
Route::get('gestion/comercial/referidos', 'DigitalsiteSaaS\Gestion\Http\GestionController@referidos');
Route::post('gestion/registrar/usuario', 'DigitalsiteSaaS\Gestion\Http\GestionController@create');
Route::resource('gestion/comercial', 'DigitalsiteSaaS\Gestion\Http\GestionController');
});


Route::get('/validacion/nit', function () {
          $user = DB::table('gestion_usuarios')->where('nit', Input::get('nit'))->count();
    if($user > 0) {
        $isAvailable = FALSE;
    } else {
        $isAvailable = TRUE;
    }
    echo json_encode(
            array(
                'valid' => $isAvailable
            )); 

});

Route::group(['middleware' => ['auths','recepcion']], function (){
Route::get('gestion/comercial-recepcion', 'DigitalsiteSaaS\Gestion\Http\GestionController@recepcion');
Route::get('gestion/registro-recepcion', function(){
 $productos = DB::table('gestion_productos')->get();
 $sectores = DB::table('gestion_sector')->get();
  $referidos = DB::table('gestion_referidos')->get();
 $cantidades = DB::table('gestion_cantidad')->get();
  $paises = DB::table('paises')->orderBy('pais', 'ASC')->get();
 return View::make('gestion::registro-recepcion')->with('productos', $productos)->with('sectores', $sectores)->with('referidos', $referidos)->with('cantidades', $cantidades)->with('paises', $paises);
});
Route::post('gestion/usuariorecepcion', 'DigitalsiteSaaS\Gestion\Http\GestionController@createrecepcion');
Route::get('gestion/comercial/editar-registrorec/{id}', function($id){
 $usuario = DB::table('gestion_usuarios')
 ->join('gestion_productos','gestion_usuarios.interes','=','gestion_productos.id')
 ->join('gestion_sector','gestion_usuarios.sector_id','=','gestion_sector.id')
 ->join('gestion_cantidad', 'gestion_cantidad.id', '=', 'gestion_usuarios.cantidad_id')
  ->join('gestion_referidos', 'gestion_referidos.id', '=', 'gestion_usuarios.referido_id')
 ->leftjoin('paises', 'paises.id', '=', 'gestion_usuarios.pais_id')
 ->leftjoin('departamentos', 'departamentos.id', '=', 'gestion_usuarios.ciudad_id')
 ->where('gestion_usuarios.id', '=', $id)->get();
 $productos = DB::table('gestion_productos')->get();
 $paises = DB::table('paises')->orderBy('pais', 'ASC')->get();
  $referidos = DB::table('gestion_referidos')->get();
 $sectores = DB::table('gestion_sector')->get();
  $cantidades = DB::table('gestion_cantidad')->get();
 return View::make('gestion::editar-registrorec')->with('productos', $productos)->with('sectores', $sectores)->with('usuario', $usuario)->with('paises', $paises)->with('referidos', $referidos)->with('cantidades', $cantidades);
});
Route::post('gestion/comercial/editar-usuariorec/{id}', 'DigitalsiteSaaS\Gestion\Http\GestionController@editrec');
});


