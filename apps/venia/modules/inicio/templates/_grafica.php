<?php  $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad'); ?>
<?php 
  $sqlexp = "select month(created_at) as mes, sum(valor)  as Valor from orden_devolucion  where estatus in ('Autorizado','Entregado') group by month(created_at);"; 
            $con = Propel::getConnection();
            $stmt = $con->prepare($sqlexp);
            $resource = $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

         

            
            $ARRAY[1]='Enero';
$ARRAY[2]='Febrero';
$ARRAY[3]='Marzo';
$ARRAY[4]='Abril';
$ARRAY[5]='Mayo';
$ARRAY[6]='Junio';
$ARRAY[7]='Julio';
$ARRAY[8]='Agosto';
$ARRAY[9]='Septiembre';
$ARRAY[10]='Octubre';
$ARRAY[11]='Noviembre';
$ARRAY[12]='Diciembre';
// $result['Valor'] = 45;
//    $result['mes'] =2;

?>



<?php $valorMax = 50;  ?>
    <?Php foreach ($result as $regi) { ?>
<?php if ($regi['Valor'] >$valorMax) { ?>
<?php $valorMax = $regi["Valor"];  ?>

    <?php } ?>
<?php } ?>
<?php $valorMax= $valorMax; ?>
<?php $Media = (int) $valorMax/2; ?>
<?Php $Inicia= 1; ?>


<?Php 
//echo "<pre>";
//print_r($result);
//die();

?>
<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 400px;
}
</style>

<!-- Resources -->
<!--<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>-->
<script src="lib/4/core.js"></script>
<script src="lib/4/charts.js"></script>
<script src="lib/4/animated.js"></script>


<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv", am4charts.XYChart);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.data = [
  <?php        foreach ($result as $data) { ?>  
  {
    country:  "<?php echo $ARRAY[$data['mes']] ?>",
    visits: <?php echo $data['Valor'] ?>
  },
  <?Php  }?>
//  {
//    country: "China",
//    visits: 1882
//  },
//  {
//    country: "Japan",
//    visits: 1809
//  },

];

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.minGridDistance = 40;
categoryAxis.fontSize = 11;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;
valueAxis.max = <?php echo $valorMax; ?>;
valueAxis.strictMinMax = true;
valueAxis.renderer.minGridDistance = 30;
// axis break
var axisBreak = valueAxis.axisBreaks.create();
axisBreak.startValue = <?php echo $Inicia; ?>;
axisBreak.endValue =  <?php echo $Media; ?>;
//axisBreak.breakSize = 0.005;

// fixed axis break
var d = (axisBreak.endValue - axisBreak.startValue) / (valueAxis.max - valueAxis.min);
axisBreak.breakSize = 0.05 * (1 - d) / d; // 0.05 means that the break will take 5% of the total value axis height

// make break expand on hover
var hoverState = axisBreak.states.create("hover");
hoverState.properties.breakSize = 1;
hoverState.properties.opacity = 0.1;
hoverState.transitionDuration = 1500;

axisBreak.defaultState.transitionDuration = 1000;
/*
// this is exactly the same, but with events
axisBreak.events.on("over", function() {
  axisBreak.animate(
    [{ property: "breakSize", to: 1 }, { property: "opacity", to: 0.1 }],
    1500,
    am4core.ease.sinOut
  );
});
axisBreak.events.on("out", function() {
  axisBreak.animate(
    [{ property: "breakSize", to: 0.005 }, { property: "opacity", to: 1 }],
    1000,
    am4core.ease.quadOut
  );
});*/

var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.categoryX = "country";
series.dataFields.valueY = "visits";
series.columns.template.tooltipText = "{valueY.value}";
series.columns.template.tooltipY = 0;
series.columns.template.strokeOpacity = 0;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>