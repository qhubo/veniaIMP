

<style>
    #chartdiv6 {
        width: 100%;
        height: 400px;
    }										
</style>

<!-- Resources -->
<!-- Resources -->
<script src="/assets/amcharts.js" type="text/javascript"></script>
<!--<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>-->

<script src="/assets/serial.js" type="text/javascript"></script>
<!--<script src="https://www.amcharts.com/lib/3/serial.js"></script>-->


<!--<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>-->

<link href="/assets/export.css" rel="stylesheet" type="text/css"/>
<!--<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />-->

<script src="/assets/light.js" type="text/javascript"></script>
<!--<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>-->
<?php     // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta')); ?>
         
<?php //print_r($valores); ?>
<?php    //  echo "<pre>";
       // echo "<pre>";
     //   print_r($listado);   ?>

 <?php $no = 0 ?>
<!-- $registros->where("OrdenDevolucion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $registros->where("OrdenDevolucion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");-->
<?php  $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad'); ?>
<?php 
  $sqlexp = "select detalle_motivo, sum(valor)  as Valor from orden_devolucion";
      $sqlexp .= "  where estatus in ('Autorizado','Entregado')  and vendedor <> ''  "
              . " and  created_at  >='".$fechaInicio."' and  created_at <='".$fechaFin."'  group by detalle_motivo;"; 
      if ($vendedor) {
            $sqlexp = "select detalle_motivo, sum(valor)  as Valor from orden_devolucion";
      $sqlexp .= "  where estatus in ('Autorizado','Entregado')  and vendedor <> ''  and vendedor ='".$vendedor." ' "
              . " and  created_at  >='".$fechaInicio."' and  created_at <='".$fechaFin."'  group by detalle_motivo;"; 
          
      }  
      
      
      $con = Propel::getConnection();
            $stmt = $con->prepare($sqlexp);
            $resource = $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>


<?php  foreach ($result as $data) {?>

<?php if ($no < 21) { ?>
  <?php $no++; ?>
 <?php $valor =$data['Valor']; ?>
 <?php $detalle = strtoupper( $data['detalle_motivo']); ?>
<?php if ($detalle=="") {  $detalle='SIN MOTIVO'; } ?>
    <input name="visita<?php echo $no ?>" type="hidden"  id="visita<?php echo $no ?>" value="<?php echo $valor; ?>" />
    <input name="country<?php echo $no ?>" type="hidden"  id="country<?php echo $no ?>" value="<?php echo   $detalle ; ?>"  />  
<?php } ?>
<?php } ?>
    <input name="cantidad" type="hidden"  id="cantidad" value="<?php echo $no ?>" />
<script>
    var myArray = ['#FA32AB','#1624F3','#5CEA23','#6823EA','#A9FCE7','#FDCF12','#FA32AB','#1624F3','#5CEA23','#6823EA','#A9FCE7','#FDCF12']; 
    var rand = myArray[Math.floor(Math.random() * myArray.length)];
    var countryR = new Array();
    var visitaR = new Array();
    var colores = new Array();
    var contado = $("#cantidad").val();
    var datos = [];
    var linea = 1;
    for (var i = 1; i <= contado; i++) {
        countryR[i - 1] = $("#country" + i).val();
        visitaR[i - 1] = $("#visita" + i).val();
        colores[i - 1] = myArray[Math.floor(Math.random() * myArray.length)];;
        datos[i - 1] = {};
        datos[i - 1]["country"] = countryR[i - 1];
        datos[i - 1]["visits"] = visitaR[i - 1];
        datos[i - 1]["color"] = colores[i - 1];
    }
    var chart = AmCharts.makeChart("chartdiv6", {
        "theme": "light",
        "type": "serial",
        "startDuration": 2,
        "dataProvider": datos,
        "valueAxes": [{
                "position": "left",
                "title": "Devoluciones"
            }],
        "graphs": [{
                "balloonText": "[[category]]: <b>[[value]]</b>",
                "fillColorsField": "color",
                "fillAlphas": 1,
                "lineAlpha": 0.1,
                "type": "column",
                "valueField": "visits"
            }],
        "depth3D": 20,
        "angle": 30,
        "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
        },
        "categoryField": "country",
        "categoryAxis": {
            "gridPosition": "start",
            "labelRotation": 45
        },
        "export": {
            "enabled": true
        }
    });
</script>



<div id="chartdiv6"></div>