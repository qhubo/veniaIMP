<!-- Styles -->
<style>
    #chartdiv2 {
        width: 100%;
        height: 400px;
    }

</style>

<?php $sqlexp = "select count(*)  as cantidad, day(created_at) as dia,"
        . "  month(created_at) as mes, year(created_at) anio from orden_devolucion"
        . "  group by month(created_at),"
        . "  year(created_at),day(created_at) order by created_at desc  limit 0,7"; ?>
<?Php
$con = Propel::getConnection();
$stmt = $con->prepare($sqlexp);
$resource = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$ARRAY[1]='Ene';
$ARRAY[2]='Feb';
$ARRAY[3]='Mar';
$ARRAY[4]='Abr';
$ARRAY[5]='May';
$ARRAY[6]='Jun';
$ARRAY[7]='Jul';
$ARRAY[8]='Ago';
$ARRAY[9]='Sep';
$ARRAY[10]='Oct';
$ARRAY[11]='Nov';
$ARRAY[12]='Dic';
//$linea['dia']=4;
//  $linea['mes']=$ARRAY[3];
//    $linea['valor'] = 8;
//    $linea['pagado'] =5;
//    $valores[] = $linea;
    
    
foreach ($result as $data) {
  $sql="select sum(valor)  as valor  from orden_devolucion  where month(created_at) = ".$data['mes'].
        " and  estatus in ('Autorizado','Entregado') and  year(created_at)=" .$data['anio']." and day(created_at)=  ".$data['dia'];
  $con2 = Propel::getConnection();
$stmt2 = $con2->prepare($sql);
$resource2 = $stmt2->execute();
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$linea['dia']=$data['dia'];
  
    $linea['mes']=$ARRAY[$data['mes']];
    $linea['valor'] = $data['cantidad'];
       $linea['pagado'] = $result2[0]['valor'];
    $valores[] = $linea;
}



//echo "<pre>";
//print_r($valores);
//die();
?>




<!-- Resources -->
<!--<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>-->
<script src="lib/4/core.js"></script>
<script src="lib/4/charts.js"></script>
<script src="lib/4/animated.js"></script>

<!-- Chart code -->
<script>
    am4core.ready(function () {

// Themes begin
        am4core.useTheme(am4themes_animated);
// Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv2", am4charts.XYChart);

// Add data
        chart.data = [
            <?php    foreach ($valores as $line) { ?>
            {
                "year": '<?php echo $line['dia']; ?>-<?php echo $line['mes']; ?> ',
                "income": <?php echo $line['valor']; ?>,
                "expenses": <?php echo $line['pagado']; ?>
            }, 
            <?php   } ?>
          
        ];

// Create axes
        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "year";
        categoryAxis.numberFormatter.numberFormat = "#";
        categoryAxis.renderer.inversed = true;
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.cellStartLocation = 0.1;
        categoryAxis.renderer.cellEndLocation = 0.9;

        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.opposite = true;

// Create series
        function createSeries(field, name) {
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueX = field;
            series.dataFields.categoryY = "year";
            series.name = name;
            series.columns.template.tooltipText = "{name}: [bold]{valueX}[/]";
            series.columns.template.height = am4core.percent(100);
            series.sequencedInterpolation = true;

            var valueLabel = series.bullets.push(new am4charts.LabelBullet());
            valueLabel.label.text = "{valueX}";
            valueLabel.label.horizontalCenter = "left";
            valueLabel.label.dx = 10;
            valueLabel.label.hideOversized = false;
            valueLabel.label.truncate = false;

            var categoryLabel = series.bullets.push(new am4charts.LabelBullet());
            categoryLabel.label.text = "{name}";
            categoryLabel.label.horizontalCenter = "right";
            categoryLabel.label.dx = -10;
            categoryLabel.label.fill = am4core.color("#fff");
            categoryLabel.label.hideOversized = false;
            categoryLabel.label.truncate = false;
        }

        createSeries("income", "#");
        createSeries("expenses", "Q");

    }); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv2"></div>