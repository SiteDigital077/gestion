
 @extends ('adminsite.layout')

 @section('cabecera')
    <script src="/modulo-estadisticas/js/chartkick.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
    <!-- <script src="Chart.bundle.js"></script> -->

 
 <script type="text/javascript" src="//www.google.com/jsapi"></script>

     <script>
      // Chartkick.configure({language: "de"});
      // Chartkick.configure({mapsApiKey: "test123"})
      // Chartkick.options = {colors: ["#b00", "#666"]};
      // Chartkick.options = {legend: "right"};
      // Chartkick.options = {title: "Bingo"};

      var CustomAdapter = new function () {
        this.name = "custom";

        // this.renderLineChart = function (chart) {
        //   chart.getElement().innerHTML = "Hi";
        // };

        this.renderCustomChart = function (chart) {
          chart.getElement().innerHTML = "Custom Chart";
        };
      };

      Chartkick.CustomChart = function (element, dataSource, options) {
        Chartkick.createChart("CustomChart", this, element, dataSource, options);
      };

      Chartkick.adapters.unshift(CustomAdapter);
    </script>

    <style>

      Rect {
   stroke: black;
   fill: #d8d8d8;
 }
      h1 {
        text-align: center;
      }


.table-striped tr {display: block; }
.table-striped th, td { width: 400px; }
.table-striped tbody { display: block; height: 230px; overflow: auto;} 
    </style>


 @parent
 
 @stop


 @section('ContenidoSite-01')




   <div class="content-header">
     <ul class="nav-horizontal text-center">
        <li class="active">
       <a href="/gestion/estadistica"><i class="gi gi-signal"></i>Estadísticas</a>
      </li>
      <li>
       <a href="/gestion/estadistica/bloqueo"><i class="gi gi-eye_close"></i>IPs Bloqueadas</a>
      </li>
      
     </ul>
    </div>


<div class="container">
  <div class="col-md-12">
   <div class="block">
                  
    <div class="block-title">
     <h2><strong>Filtrar</strong> estadísticas por fecha</h2>
    </div>
    
    <div class="table-responsive">
     <form action="{{URL::current()}}">

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
     <div class="form-group">
      <div class='input-group date' id='datetimepicker7'>
       {{Form::text('min_price',Input::get('min_price'), array('class' => 'form-control','readonly' => 'readonly','placeholder'=>'Ingrese fecha desde'))}}
       <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
      </div>
     </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
     <div class="form-group">
      <div class='input-group date' id='datetimepicker9'>
       {{Form::text('max_price',Input::get('max_price'), array('class' => 'form-control','readonly' => 'readonly','placeholder'=>'Ingrese fecha hasta'))}}
       <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
      </div>
     </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
     <div class="form-group">
      <br>
       <div class='input-group pull-right' style="margin-top:-15px;margin-bottom:15px">
        <button class="btn btn-primary">Filtrar</button>
       </div>
     </div>
    </div>

   </form>
    </div>
     </div>                      
      </div>
       </div>




<div class="container">

<div class="col-md-12">
                                <!-- Widget -->
                                <div class="widget">
                                    <div class="widget-extra text-center themed-background-dark">
                                        <h3 class="widget-content-light"><i class="fa fa-arrow-up animation-floating"></i> Estadísticas <strong>web</strong></h3>
                                    </div>
                                    <div class="widget-simple">
                                        <div class="row text-center">
                                            <div class="col-xs-3">
                                                <a href="javascript:void(0)" class="widget-icon themed-background">
                                                    <i class="gi gi-thumbs_up"></i>
                                                </a>
                                                <h3 class="remove-margin-bottom"><strong>{{number_format($total_usuarios, 0, ",", ".")}}</strong><br><small>Total Registros</small></h3>
                                            </div>
                                            @foreach($estado_usuario as $estado_usuario)
                                            @if($estado_usuario->tipo == '1')
                                            <div class="col-xs-3">
                                                <a href="javascript:void(0)" class="widget-icon themed-background">
                                                    <i class="gi gi-thumbs_up"></i>
                                                </a>
                                                <h3 class="remove-margin-bottom"><strong>{{$estado_usuario->tipo_sum}}</strong><br><small>Leads</small></h3>
                                            </div>
                                            @elseif($estado_usuario->tipo == '2')
                                            <div class="col-xs-3">
                                                <a href="javascript:void(0)" class="widget-icon themed-background">
                                                    <i class="gi gi-thumbs_up"></i>
                                                </a>
                                                <h3 class="remove-margin-bottom"><strong>{{$estado_usuario->tipo_sum}}</strong><br><small>Prospectos nuevos</small></h3>
                                            </div>
                                            @elseif($estado_usuario->tipo == '3')
                                            <div class="col-xs-3">
                                                <a href="javascript:void(0)" class="widget-icon themed-background">
                                                    <i class="gi gi-thumbs_up"></i>
                                                </a>
                                                <h3 class="remove-margin-bottom"><strong>{{$estado_usuario->tipo_sum}}</strong><br><small>Ganados</small></h3>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- END Widget -->
                            </div>
</div>

<div class="container">
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
 <div class="block">
                            <!-- Responsive Full Title -->
                            <div class="block-title">
                                <h2><strong>Páginas</strong> vistas</h2>
                            </div>
                            <!-- END Responsive Full Title -->

                            <!-- Responsive Full Content -->
                            
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-primary">Página</th>
                                            <th class="text-primary"># Registros</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($productos as $productos)
                                        <tr>
                                           <td style="width:280px">{{$productos->producto}}</td>
                                           <td style="width:100px">{{$productos->productos_sum}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- END Responsive Full Content -->
                        </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
 <div class="block">
                            <!-- Responsive Full Title -->
                            <div class="block-title">
                                <h2><strong>Visitas</strong> referidas</h2>
                            </div>
                            <!-- END Responsive Full Title -->

                            <!-- Responsive Full Content -->
                            
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead>
                                        
                                        <tr>
                                            <th class="text-primary">Referidos</th>
                                            <th class="text-primary"># Registros</th>    
                                        </tr>
                                     
                                    </thead>
                                    <tbody>
                                    @foreach($referidos as $referidos)
                                        <tr>
                                           
                                           <td style="width:100px">{{$referidos->referidos}}</td>
                                            <td style="width:100px">{{$referidos->referidos_sum}}</td>
                                        </tr>
                                    
                                           @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- END Responsive Full Content -->
                        </div>
</div>
</div>

<div class="container">

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
 <div class="block">
                            <!-- Responsive Full Title -->
                            <div class="block-title">
                                <h2><strong>Visitas</strong> ciudades</h2>
                            </div>
                            <!-- END Responsive Full Title -->

                            <!-- Responsive Full Content -->
                            
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-primary">Ciudades</th>
                                            <th class="text-primary"># Visitas</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                        <tr>
                                           <td style="width:280px"></td>
                                           <td style="width:100px"></td>
                                        </tr>
                               
                                    </tbody>
                                </table>
                            </div>
                            <!-- END Responsive Full Content -->
                        </div>


</div>

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
 <div class="block">
                            <!-- Responsive Full Title -->
                            <div class="block-title">
                                <h2><strong>Lenguajes</strong> visitas</h2>
                            </div>
                            <!-- END Responsive Full Title -->

                            <!-- Responsive Full Content -->
                            
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-primary">Lenguaje</th>
                                            <th class="text-primary"># Visitas</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                               
                                        <tr>
                                           <td style="width:280px"></td>
                                           <td style="width:100px"></td>
                                        </tr>
                               
                                    </tbody>
                                </table>
                            </div>
                            <!-- END Responsive Full Content -->
                        </div>


</div>
</div>



<div class="container">

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
 <div class="block">
                            <!-- Responsive Full Title -->
                            <div class="block-title">
                                <h2><strong>Fuentes</strong> tráfico</h2>
                            </div>
                            <!-- END Responsive Full Title -->

                            <!-- Responsive Full Content -->
                            
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-primary">Fuentes</th>
                                            <th class="text-primary"># Visitas</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr>
                                           <td style="width:280px"></td>
                                           <td style="width:100px"></td>
                                        </tr>
                                      
                                    </tbody>
                                </table>
                            </div>
                            <!-- END Responsive Full Content -->
                        </div>


</div>

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
 <div class="block">
                            <!-- Responsive Full Title -->
                            <div class="block-title">
                                <h2><strong>Lenguajes</strong> visitas</h2>
                            </div>
                            <!-- END Responsive Full Title -->

                            <!-- Responsive Full Content -->
                            
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-primary">Lenguaje</th>
                                            <th class="text-primary"># Visitas</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr>
                                           <td style="width:280px">Otro</td>
                                           <td style="width:100px">5</td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- END Responsive Full Content -->
                        </div>


</div>
</div>




  
<div class="container">
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
 <div class="block">
                                    <!-- Quick Post Title -->
    <div class="block-title">
     <div class="block-options pull-right">
      
     </div>
      <h2><strong>Visitas</strong> por mes</h2>
                                    
     
       <div id="column" style="height:400px;"></div>
        <script>
         new Chartkick.ColumnChart("column", [
      
         ]);
        </script>
   </div>
 </div>
</div>

<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
 <div class="block">
                                    <!-- Quick Post Title -->
    <div class="block-title">
     <div class="block-options pull-right">
  
     </div>
      <h2><strong>Visitas</strong> por país</h2>
                                  
    <div id="geo" style="height:400px"></div>

  
   </div>
 </div>
</div>


</div>




   


   {{ Html::script('modulo-estadisticas/js/jquery.min.js') }}

  <script type="text/javascript">
$(document).ready(function(){
    $('#datetimepicker7').datetimepicker({
      pickTime: false,
      format: 'YYYY-MM-DD'

    });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('#datetimepicker9').datetimepicker({
      pickTime: false,
      format: 'YYYY-MM-DD'

    });
});
</script>





     {{ Html::script('modulo-estadisticas/js/moment.min.js') }}
     {{ Html::script('modulo-estadisticas/js/bootstrap-datetimepicker.min.js') }}


    


@stop


