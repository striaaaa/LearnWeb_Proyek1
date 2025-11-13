<?php 
require_once __DIR__ . '/../../controller/dashboardController.php';
$page_css = '<link rel="stylesheet" href="assets/css/admin/manajemen-penggguna.css" />';
ob_start();
?>
 <div class="">
       asddasd 
       <!-- <div id="chartUserGroupByMonth"></div> -->
       <?php
    //    echo "<pre>";
    //    var_dump($getUserGroupByMonth['data']);
    //    echo "</pre>";
        ?>
    </div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/heatmap.js"></script>
<script src="https://code.highcharts.com/modules/treemap.js"></script>
<script src="https://code.highcharts.com/modules/funnel.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/polar.js"></script>
<script src="https://code.highcharts.com/modules/timeline.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
   
<script>
// Pilih chart type di sini
var dataFromDB=<?=json_encode($getUserGroupByMonth['data']) ?>;
console.log('ss',dataFromDB);

var categories = dataFromDB.map(d => d.month);
var seriesData = dataFromDB.map(d => d.total_user);
Highcharts.chart('chartUserGroupByMonth', {
    chart: {
        type: 'line'  
    },
    title: {
        text: 'Sebaran User Join Per Bulan'
    },
    xAxis: {
        categories: categories,
        title: { text: 'Bulan' }
    },
    yAxis: {
        title: { text: 'Jumlah User' },
        allowDecimals: false
    },
    series: [{
        name: 'User Baru',
        data: seriesData
    }],
    tooltip: {
        valueSuffix: ' user'
    },
    credits: { enabled: false }
}); 
</script>
<?php
$content = ob_get_clean();
include __DIR__ .'../../../layouts/mainAdmin.php';
?>


<!-- 
line
spline
area
areaspline
column
bar
pie
scatter
bubble
area range
areasplinerange
column range
waterfall
funnel
pyramid
gauge
solidgauge
polar
boxplot
errorbar
treemap
heatmap
timeline -->
