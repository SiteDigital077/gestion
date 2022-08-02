@extends ('adminsite.layout')
 
 @section('cabecera')
  @parent
 @stop

@section('ContenidoSite-01')
<h1>Hola</h1>
<div class="content-header">
 <ul class="nav-horizontal text-center">
  <li class="active">
   <a href="/gestion/comercial"><i class="fa fa-list-ul"></i> Usuarios</a>
  </li>
  <li>
   <a href="/gestion/comercial/registro"><i class="fa fa-user-plus"></i> Registrar Datos Usuario</a>
  </li>
  <li>
   <a href="/gestion/comercial/productos"><i class="fa fa-file-o"></i>Productos & Servicios</a>
  </li>
  <li>
   <a href="/gestion/comercial/sectores"><i class="fa fa-file-o"></i>Sectores</a>
  </li>
  <li>
   <a href="/gestion/comercial/referidos"><i class="fa fa-file-o"></i>Referidos</a>
  </li>
   <li>
   <a href="/gestion/comercial/cantidades"><i class="fa fa-file-o"></i>Cantidades</a>
  </li>
 </ul>
</div>

<div class="container">
 <?php $status=Session::get('status'); ?>
 @if($status=='ok_create')
  <div class="alert alert-success">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <strong>Usuario registrado con éxito</strong> CMS...
  </div>
 @endif

 @if($status=='ok_delete')
  <div class="alert alert-danger">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <strong>Usuario eliminado con éxito</strong> CMS...
  </div>
 @endif

 @if($status=='ok_update')
  <div class="alert alert-warning">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <strong>Usuario actualizado con éxito</strong> CMS...
  </div>
 @endif
</div>

<div class="container">

 <br>
 
 <div class="block full">
  <div class="block-title">
   <h2><strong>Prospectos</strong> registrados</h2>
  </div>
            
  <div class="table-responsive">
   <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
    <thead>
     <tr>
      <th class="text-center">Nombres y Apellidos</th>
      <th class="text-center">Empresa</th>
      <th class="text-center">Estado</th>
      <th class="text-center">Email</th>
      <th class="text-center">Intéres</th>
      <th class="text-center">Sector</th>
      <th class="text-center">Creación</th>
      <th class="text-center">Acciones</th>
     </tr>
    </thead>
    
    <tbody>
      @foreach($usuarios as $usuariosa)

      <tr>
       <td class="text-center">{{$usuariosa->nombre}} {{$usuariosa->apellido}}</td>
       
       <td class="text-center">{{$usuariosa->empresa}}</td>
       @if($usuariosa->tipo == '1')
       <td class="text-center"> <span class="badge label-info">Contacto</span></td>
       @elseif($usuariosa->tipo == '2')
       <td class="text-center"> <span class="badge label-warning">En Proceso</span></td>
       @elseif($usuariosa->tipo == '3')
       <td class="text-center"> <span class="badge label-success">Ganado</span></td>
       @endif
       <td>{{$usuariosa->email}}</td>
      
       @foreach($productos as $productosa)
       @if($usuariosa->interes == $productosa->id)
       <td>{{$productosa->producto}}</td>
       @endif
       @endforeach

       @foreach($sectores as $sectoresa)
       @if($usuariosa->sector_id == $sectoresa->id)
       <td>{{$sectoresa->sectores}}</td>
       @endif
       @endforeach

       <td>{{$usuariosa->created_at}}</td>
       <td class="text-center">

        

        <a href="<?=URL::to('gestion/comercial/editar-recepcion/');?>/{{$usuariosa->id}}"><span  id="tip" data-toggle="tooltip" data-placement="left" title="Editar usuario" class="btn btn-primary"><i class="fa fa-pencil-square-o sidebar-nav-icon"></i></span></a>

       <script language="JavaScript">
		    function confirmar ( mensaje ) {
		    return confirm( mensaje );}
	      </script>

       <a href="<?=URL::to('gestion/comercial/eliminar');?>/{{$usuariosa->id}}" onclick="return confirmar('¿Está seguro que desea eliminar el registro?')"><span id="tup" data-toggle="tooltip" data-placement="top" title="Eliminar usuario" class="btn btn-danger" disabled="true"><i class="hi hi-trash sidebar-nav-icon"></i></span></a>

       <a href="<?=URL::to('/portafolio');?>/{{$usuariosa->slug}}"><span  id="tip" data-toggle="tooltip" data-placement="right" title="Ver Portafolio" class="btn btn-warning"><i class="fa fa-book sidebar-nav-icon"></i></span></a>
       </td>
      </tr>
      @endforeach
    </tbody>
   </table>
  </div>
 </div>
</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

  <script src="/adminsite/js/pages/tablesDatatables.js"></script>
  <script>$(function(){ TablesDatatables.init(); });</script>

@stop