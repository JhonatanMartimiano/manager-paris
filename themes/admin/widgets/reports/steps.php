<?php $v->layout("_admin"); ?>
    <!--App-Content-->
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Relatórios</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Relatórios</li>
                </ol>
            </div>

            <!-- Revenue Chart -->
            <div class="card card-chart">
                <div class="card-header">
                    <div class="row align-items-center col-12">
                        <div class="col-md-6 col-sm-12">
                            <h5 class="card-title">Desempenho Etapas:</h5>
                        </div>
                        <div class="d-flex justify-content-end col-md-6 col-sm-12">
                            <form class="form-inline mb-1" action="<?= url('/admin/reports/sellers'); ?>"
                                  method="post">
                                <div class="form-group">
                                    <input type="text" name="startDate" class="mask-date">
                                </div>
                                <p class="mt-0 mx-4">à</p>
                                <div class="form-group">
                                    <input type="text" name="endDate" class="mask-date">
                                </div>
                                <button type="submit" class="btn btn-danger btn-sm ml-2 rounded">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart"></div>
                </div>
            </div>
            <!-- /Revenue Chart -->

            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <h3 class="card-title">Vendedores</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered border-top mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>N° de Clientes</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($sellers as $seller): ?>
                                        <tr>
                                            <th scope="row"><?= $seller->id; ?></th>
                                            <td>
                                                <a href="<?= url('/admin/reports/step/'.$seller->id) ?>"><?= $seller->fullName(); ?></a>
                                            </td>
                                            <td><?= $seller->countClients(); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?= $paginator; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/App-Content-->

<?php $v->start("scripts"); ?>
    <script>
        $(document).ready(function () {
            // Area chart
            var options = {
                series: [{
                    name: 'Apresentação',
                    data: [<?= number_format($presentation * 100 / $negotiations, 2); ?>],
                    color: "#ff382b"
                },
                    {
                        name: 'Tabela',
                        data: [<?= number_format($table * 100 / $negotiations, 2); ?>],
                        color: "#05a01f"
                    },
                    {
                        name: 'Cotação',
                        data: [<?= number_format($price * 100 / $negotiations, 2); ?>],
                        color: "#ffa22b"
                    },
                    {
                        name: 'APagamento',
                        data: [<?= number_format($apayment * 100 / $negotiations, 2); ?>],
                        color: "#1da1f3"
                    }
                ],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val + '%';
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },

                xaxis: {
                    categories: ["Apresentação", "Tabela", "Cotação", "APagamento"],
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: '0D47A1',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: false,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function (val) {
                            return val + '%';
                        }
                    }

                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
<?php $v->end("scripts"); ?>