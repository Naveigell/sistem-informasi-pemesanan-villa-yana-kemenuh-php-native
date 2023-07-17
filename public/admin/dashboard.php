<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>
    <?php
        $staffCount     = \App\Models\User::instance()->raw("SELECT * FROM users WHERE role = '" . \App\Models\User::ROLE_STAFF . "'")->rowCount();
        $bookingCount   = \App\Models\Booking::instance()->raw("SELECT * FROM bookings WHERE status = '" . \App\Models\Booking::STATUS_ACC . "'")->rowCount();
        $complaintCount = \App\Models\Complaint::instance()->raw("SELECT * FROM complaints")->rowCount();

        $data = [];

        $year = date('Y');
        $bookings = \App\Models\Booking::instance()->raw("
            SELECT SUM((rooms.price * bookings.total_day) - IFNULL(promos.price, 0)) AS _sum, MONTH(bookings.created_at) AS _month, YEAR(bookings.created_at) AS _year 
            FROM bookings 
                INNER JOIN rooms ON rooms.id = bookings.room_id
                LEFT JOIN promos on bookings.promo_id = promos.id
            WHERE status = '" . \App\Models\Booking::STATUS_ACC . "' GROUP BY _month, _year")->fetchAll();

        foreach (range(1, 12) as $number) {
            $month = date('F', mktime(0, 0, 0, $number));

            $data[$month] = 0;

            array_filter($bookings, function ($booking) use ($month, $number, &$data) {
                if ($booking['_month'] == $number) {
                    $data[$month] = $booking['_sum'];
                }
            });
        }
    ?>
</head>

<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">

        <?php require_once '../layout/admin/header.php'; ?>
        <?php require_once '../layout/admin/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Dashboard</h1>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Staff</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= $staffCount; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-danger">
                                    <i class="far fa-newspaper"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Booking (Diterima)</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= $bookingCount; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-warning">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Komplain</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= number_format($complaintCount); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (\Lib\Session\Session::get('user')['role'] == \App\Models\User::ROLE_ADMIN): ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Statistik</h4>
                                    </div>
                                    <div class="card-body"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                        <canvas id="myChart" height="576" width="950" style="display: block; width: 950px; height: 576px;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <?php require_once '../layout/admin/footer.php'; ?>

    </div>
</div>

<?php require_once '../layout/admin/script.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var data = {
        labels: <?= json_encode(array_keys($data)); ?>,
        datasets: [{
            label: 'Pemasukan',
            backgroundColor: 'rgb(75,158,252)',
            borderColor: 'rgb(75,158,252)',
            data: <?= json_encode(array_values($data)); ?>,
            lineTension: 0.4,
            fill: true
        }]
    };
    var config = {
        type: 'bar',
        data: data,
        options: {
            scale: {
                ticks: {
                    precision: 0
                }
            },
            elements: {
                point:{
                    radius: 0
                }
            }
        }
    };
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
<script>
</script>
</body>
</html>