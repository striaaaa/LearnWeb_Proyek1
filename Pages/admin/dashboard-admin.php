<?php
require_once __DIR__ . '/../../controller/dashboardController.php';
$page_css = '<link rel="stylesheet" href="assets/css/admin/manajemen-penggguna.css" />';
ob_start();
?>
<style>
    .chart-user-Permonth {
        border-radius: 20px;
    }

    .list-count {
        overflow-x: auto;
        margin-bottom: 24px;
    }

    .cardCountsData {
        min-width: 300px;
        padding: 24px;
        border-radius: 16px;

    }

    .countCard-title {
        margin-left: 24px;
    }

    .countCard-title h1 {
        font-size: 36px;
        font-weight: 600;
    }

    .countCard-title p {
        font-size: 20px;
    }

    .icon-ContsData {
        padding: 16px;
        border-radius: 24px;
    }
</style>
<div class="">
    <br>
    <div class="list-count  flex  gap-4">
        <div class="cardCountsData flex items-center" style="
        background-color: #fef6e3;">
            <div class="icon-ContsData" style="background-color: #fee9be;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#f7a015" d="M17.25 2A2.75 2.75 0 0 1 20 4.75v14.5A2.75 2.75 0 0 1 17.25 22H6.75A2.75 2.75 0 0 1 4 19.249V4.75c0-1.26.846-2.32 2-2.647V3.75c-.304.228-.5.59-.5 1v14.498c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25V4.75c0-.69-.56-1.25-1.25-1.25H15V2zM14 2v8.139c0 .747-.8 1.027-1.29.764l-.082-.052l-2.126-1.285l-2.078 1.251c-.5.36-1.33.14-1.417-.558L7 10.14V2zm-1.5 1.5h-4v5.523l1.573-.949a.92.92 0 0 1 .818-.024l1.61.974z" />
                </svg>
            </div>
            <div class="countCard-title">
                <h1><?= $totalCourses['data']->total_courses; ?></h1>
                <p>Total kursus</p>
            </div>
        </div>
        <div class="cardCountsData flex items-center" style="
        background-color: #e3effd;">
            <div class="icon-ContsData" style="background-color: #c7dced;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#3358cd" d="M17.25 2A2.75 2.75 0 0 1 20 4.75v14.5A2.75 2.75 0 0 1 17.25 22H6.75A2.75 2.75 0 0 1 4 19.249V4.75c0-1.26.846-2.32 2-2.647V3.75c-.304.228-.5.59-.5 1v14.498c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25V4.75c0-.69-.56-1.25-1.25-1.25H15V2zM14 2v8.139c0 .747-.8 1.027-1.29.764l-.082-.052l-2.126-1.285l-2.078 1.251c-.5.36-1.33.14-1.417-.558L7 10.14V2zm-1.5 1.5h-4v5.523l1.573-.949a.92.92 0 0 1 .818-.024l1.61.974z" />
                </svg>
            </div>
            <div class="countCard-title">
                <h1><?= $totalModules['data']->total_modules; ?></h1>
                <p>Total Modul</p>
            </div>
        </div>
        <div class="cardCountsData flex items-center" style="background-color: #ffebe7;">
            <div class="icon-ContsData" style="background-color: #ffd3d8;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#f0485f" d="M17.25 2A2.75 2.75 0 0 1 20 4.75v14.5A2.75 2.75 0 0 1 17.25 22H6.75A2.75 2.75 0 0 1 4 19.249V4.75c0-1.26.846-2.32 2-2.647V3.75c-.304.228-.5.59-.5 1v14.498c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25V4.75c0-.69-.56-1.25-1.25-1.25H15V2zM14 2v8.139c0 .747-.8 1.027-1.29.764l-.082-.052l-2.126-1.285l-2.078 1.251c-.5.36-1.33.14-1.417-.558L7 10.14V2zm-1.5 1.5h-4v5.523l1.573-.949a.92.92 0 0 1 .818-.024l1.61.974z" />
                </svg>
            </div>
            <div class="countCard-title">
                <h1><?= $totalUsers['data']->total_users; ?></h1>
                <p>Total Pengguna</p>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-6">

            <div id="chartUserGroupByMonth" class="chart-user-Permonth" </div>
            </div>
            <?= var_dump($userCourseCompleted); ?>
        </div>
        <div class="col-span-6">
            <div id="courseChart" style="width:100%; height:400px;"></div>

        </div>
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
        var dataFromDB = <?= json_encode($getUserGroupByMonth['data']) ?>;
        var userCourseCompleted = <?= json_encode($userCourseCompleted['data']) ?>;
        console.log('ss', dataFromDB);
    var currentYear = new Date().getFullYear();

        var categories = dataFromDB.map(d => d.month);
        var seriesData = dataFromDB.map(d => d.total_user);
        Highcharts.chart('chartUserGroupByMonth', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Sebaran User Join Bulan Per '+ currentYear
            },
            xAxis: {
                categories: categories,
                title: {
                    text: 'Bulan'
                }
            },
            yAxis: {
                title: {
                    text: 'Jumlah User'
                },
                allowDecimals: false
            },
            series: [{
                name: 'User Baru',
                data: seriesData
            }],
            tooltip: {
                valueSuffix: ' user'
            },
            credits: {
                enabled: false
            }
        });
 
        console.log(userCourseCompleted);
        
        let courseNames = userCourseCompleted.map(item => item.title);
        let totalUser = userCourseCompleted.map(item => item.total_user_selesai);

        // buat chart
        Highcharts.chart('courseChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Sebaran Penyelesaian Course oleh User'
            },
            xAxis: {
                categories: courseNames,
                title: {
                    text: 'Nama Course'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah User Selesai'
                }
            },
            series: [{
                name: 'User Selesai',
                data: totalUser
            }],
            credits: {
                enabled: false
            }
        });
    </script>
    <?php
    $content = ob_get_clean();
    include __DIR__ . '../../../layouts/mainAdmin.php';
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