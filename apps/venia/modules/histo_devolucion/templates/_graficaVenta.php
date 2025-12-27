

<style>
    #chartdiv5 {
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
<?php // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta')); ?>

<?php //print_r($valores); ?>
<?php
//  echo "<pre>";
// echo "<pre>";
//   print_r($listado);   
?>

<?php $no = 0 ?>
<!-- $registros->where("OrdenDevolucion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $registros->where("OrdenDevolucion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");-->
<?php $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad'); ?>
<?php
$sqlexp = "select vendedor, sum(valor)  as Valor from orden_devolucion";
$sqlexp .= "  where estatus in ('Autorizado','Entregado')  and vendedor <> ''"
        . " and  created_at  >='" . $fechaInicio . "' and  created_at <='" . $fechaFin . "'  group by vendedor;";
if ($medio_pago) { 
$sqlexp = "select vendedor, sum(valor)  as Valor from orden_devolucion";
$sqlexp .= "  where estatus in ('Autorizado','Entregado')  and vendedor <> ''  and  pago_medio = '".$medio_pago."' "
        . " and  created_at  >='" . $fechaInicio . "' and  created_at <='" . $fechaFin . "'  group by vendedor;";
    
    
}


$con = Propel::getConnection();
$stmt = $con->prepare($sqlexp);
$resource = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $result['Valor'] = 45;
//    $result['mes'] =2;
?>


<?php foreach ($result as $data) { ?>

    <?php if ($no < 21) { ?>
        <?php $no++; ?>
        <?php $valor = $data['Valor']; ?>
        <?php $detalle = strtoupper($data['vendedor']); ?>
        <input name="visitaR<?php echo $no ?>" type="hidden"  id="visitaR<?php echo $no ?>" value="<?php echo $valor; ?>" />
        <input name="countryR<?php echo $no ?>" type="hidden"  id="countryR<?php echo $no ?>" value="<?php echo $detalle; ?>"  />  
    <?php } ?>
<?php } ?>
<input name="xcantidad" type="hidden"  id="xcantidad" value="<?php echo $no ?>" />
<script>
    var myArray = ['#93D7FB', '#E393FB', '#49B4FE', '#AB78F1', '#A9FCE7', '#93D7FB', '#E393FB', '#49B4FE', '#AB78F1', '#A9FCE7',
        '#93D7FB', '#E393FB', '#49B4FE', '#AB78F1', '#A9FCE7', '#93D7FB', '#E393FB', '#49B4FE', '#AB78F1', '#A9FCE7', '#93D7FB', '#E393FB', '#49B4FE', '#AB78F1', '#A9FCE7'];
    var rand = myArray[Math.floor(Math.random() * myArray.length)];
    var countryR = new Array();
    var visitaR = new Array();
    var colores = new Array();
    var contado = $("#xcantidad").val();
    var datos = [];
    var linea = 1;
    for (var i = 1; i <= contado; i++) {
        countryR[i - 1] = $("#countryR" + i).val();
        visitaR[i - 1] = $("#visitaR" + i).val();
        colores[i - 1] = myArray[Math.floor(Math.random() * myArray.length)];
        ;
        datos[i - 1] = {};
        datos[i - 1]["countryR"] = countryR[i - 1];
        datos[i - 1]["visits"] = visitaR[i - 1];
        datos[i - 1]["color"] = colores[i - 1];
    }
    var chart = AmCharts.makeChart("chartdiv5", {
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
        "categoryField": "countryR",
        "categoryAxis": {
            "gridPosition": "start",
            "labelRotation": 45
        },
        "export": {
            "enabled": true
        }
    });
</script>



<div id="chartdiv5"></div>