<?php $v->layout("_admin"); ?>
    <!--App-Content-->
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Em Negociação</li>
                </ol>
            </div>
            <div class="row">
                <a href="<?= url('/admin/dash/late'); ?>" class="col-20per">
                    <div class="card overflow-hidden bg-danger">
                        <div class="card-body iconfont text-center">
                            <h5 class="text-white">Atrasados 24H+</h5>
                            <div class="d-flex justify-content-center">
                                <h5 class="mb-0 text-white mt-1"><?= $post24hour; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?= url('/admin/dash/completed'); ?>" class="col-20per">
                    <div class="card overflow-hidden bg-success">
                        <div class="card-body iconfont text-center">
                            <h5 class="text-white">Finalizados</h5>
                            <div class="d-flex justify-content-center">
                                <h5 class="mb-0 text-white mt-1"><?= $completedOrders; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?= url('/admin/dash/waiting'); ?>" class="col-20per">
                    <div class="card overflow-hidden bg-warning">
                        <div class="card-body iconfont text-center">
                            <h5 class="text-white">Aguardando</h5>
                            <div class="d-flex justify-content-center">
                                <h5 class="mb-0 text-white mt-1"><?= $waiting; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?= url('/admin/dash/inNegotiations'); ?>" class="col-20per">
                    <div class="card overflow-hidden bg-info">
                        <div class="card-body iconfont text-center">
                            <h5 class="text-white">Em Negociação</h5>
                            <div class="d-flex justify-content-center">
                                <h5 class="mb-0 text-white mt-1"><?= $inNegotiations; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?= url('/admin/dash/loss'); ?>" class="col-20per">
                    <div class="card overflow-hidden bg-purple">
                        <div class="card-body iconfont text-center">
                            <h5 class="text-white">Perdidos</h5>
                            <div class="d-flex justify-content-center">
                                <h5 class="mb-0 text-white mt-1"><?= $loss; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Clientes Em Negociação</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <h4>Último Contato</h4>
                                <form class="form-inline ajax_off mb-1" action="<?= url('/admin/dash/inNegotiations'); ?>"
                                      method="post">
                                    <div class="nav-search">
                                        <input type="date" class="form-control header-search mr-2" name="first_date"
                                               value="<?= $date['first_date']; ?>" placeholder="Buscar…" aria-label="Search">
                                        <input type="date" class="form-control header-search" name="second_date"
                                               value="<?= $date['second_date']; ?>" placeholder="Buscar…" aria-label="Search">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered border-top mb-0">
                                    <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Etapa</th>
                                        <th>Último Contato</th>
                                        <th>Próximo Contato</th>
                                        <th>Descrição</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($inNegotiationsArr): ?>
                                        <?php foreach ($inNegotiationsArr as $negInNegotiations): ?>
                                            <tr class="bg-info text-white">
                                                <td>
                                                    <a href="<?= url('/admin/negotiations/negotiation/' . $negInNegotiations->infoClient()->id); ?>" class="text-white"><?= $negInNegotiations->infoClient()->name; ?></a>
                                                </td>
                                                <td><?= $negInNegotiations->infoSeller()->fullName(); ?></td>
                                                <td><?= $negInNegotiations->infoFunnel()->title; ?></td>
                                                <td><?= date_fmt($negInNegotiations->updated_at, 'd/m/Y'); ?></td>
                                                <td><?= date_fmt($negInNegotiations->next_contact, 'd/m/Y'); ?></td>
                                                <td><?= $negInNegotiations->description; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
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
                    name: 'Primeiro Contato',
                    data: [0],
                    color: "#05a01f"
                },
                    {
                        name: 'Briefing',
                        data: [50],
                        color: "#ffa22b"
                    },
                    {
                        name: 'Compra',
                        data: [50],
                        color: "#ff382b"
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
                    categories: ["Primeiro Contato", "Briefing", "Compra"],
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