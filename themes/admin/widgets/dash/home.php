<?php $v->layout("_admin"); ?>
    <!--App-Content-->
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                <?php /*
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="card overflow-hidden">
                        <div class="card-body iconfont text-center">
                            <h5>Total de Clientes</h5>
                            <div class="d-flex justify-content-center">
                                <h5 class="mb-0 mt-1"><?= $totalClients; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (user()->level >= 5): ?>
                    <div class="col-sm-12 col-md-6 col-lg-3">
                        <div class="card overflow-hidden">
                            <div class="card-body iconfont text-center">
                                <h5>Total de Vendedores</h5>
                                <div class="d-flex justify-content-center">
                                    <h5 class="mb-0 mt-1"><?= $totalSellers; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="card overflow-hidden">
                        <div class="card-body iconfont text-center">
                            <h5>Total em Negociação</h5>
                            <div class="d-flex justify-content-center">
                                <h5 class="mb-0 mt-1"><?= $totalInNegotiations; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="card overflow-hidden">
                        <div class="card-body iconfont text-center">
                            <h5>Total em Atraso</h5>
                            <div class="d-flex justify-content-center">
                                <h5 class="mb-0 mt-1"><?= $totalInDelay; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                */ ?>
            </div>
            <!-- Revenue Chart -->
            <!--            <div class="card card-chart">-->
            <!--                <div class="card-header">-->
            <!--                    <div class="row align-items-center">-->
            <!--                        <div class="col-12">-->
            <!--                            <h5 class="card-title">Etapas/Clientes:</h5>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <div class="card-body">-->
            <!--                    <div id="chart"></div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!-- /Revenue Chart -->

            <?php if (user()->level >= 3): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card m-b-20">
                            <div class="card-header">
                                <h3 class="card-title">Novos Clientes</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-top mb-0">
                                        <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cidade</th>
                                            <th>Estado</th>
                                            <th>Data do Cadastro</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if ($newClients): ?>
                                            <?php foreach ($newClients as $newClient): ?>
                                                <?php if (!$negotiation->find("client_id = :cid", "cid={$newClient->id}")->count()): ?>
                                                    <tr class="<?= (date_diff_panel($newClient->registration_date) < -1) ? 'bg-danger text-white' : ''; ?>">
                                                        <td>
                                                            <a class="<?= (date_diff_panel($newClient->registration_date) < -1) ? 'text-white' : ''; ?>"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $newClient->id) ?>"><?= $newClient->name; ?></a>
                                                        </td>
                                                        <td><?= $newClient->cityName(); ?></td>
                                                        <td><?= $newClient->stateName(); ?></td>
                                                        <td><?= date_fmt($newClient->registration_date, "d/m/Y"); ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card m-b-20">
                            <div class="card-header">
                                <h3 class="card-title">Novos Clientes</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-top mb-0">
                                        <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cidade</th>
                                            <th>Estado</th>
                                            <th>Data do Cadastro</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if ($newClients): ?>
                                            <?php foreach ($newClients as $newClient): ?>
                                                <?php if (!$negotiation->find("client_id = :cid", "cid={$newClient->id}")->count()): ?>
                                                    <tr class="<?= (date_diff_panel($newClient->registration_date) < -1) ? 'bg-danger text-white' : ''; ?>">
                                                        <td>
                                                            <a class="<?= (date_diff_panel($newClient->registration_date) < -1) ? 'text-white' : ''; ?>"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $newClient->id) ?>"><?= $newClient->name; ?></a>
                                                        </td>
                                                        <td><?= $newClient->cityName(); ?></td>
                                                        <td><?= $newClient->stateName(); ?></td>
                                                        <td><?= date_fmt($newClient->registration_date, "d/m/Y"); ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered border-top mb-0">
                                    <thead>
                                    <tr align="center">
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th colspan="2" style="background-color: #DDDDDD">
                                            1° Contato
                                            <div class="d-flex justify-content-between">
                                                <p>Etapa</p>
                                                <p>Data</p>
                                            </div>
                                        </th>
                                        <th colspan="2" style="background-color: #CECECE">
                                            2° Contato
                                            <div class="d-flex justify-content-between">
                                                <p>Etapa</p>
                                                <p>Data</p>
                                            </div>
                                        </th>
                                        <th colspan="2" style="background-color: #B2B2B2">
                                            3° Contato
                                            <div class="d-flex justify-content-between">
                                                <p>Etapa</p>
                                                <p>Data</p>
                                            </div>
                                        </th>
                                        <th>Descrição</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($allNegotiations as $allNegotiation): ?>
                                        <?php if (date_diff_system(date_fmt($negotiation->findById($allNegotiation->id_neg)->updated_at, 'Y-m-d')) >= -30): ?>
                                            <?php if (user()->level >= 3): ?>
                                                <?php if (date_diff_panel($negotiation->getClientIDNeg($allNegotiation->id_neg)->next_contact) < -1): ?>
                                                    <tr class="bg-danger text-white">
                                                        <td>
                                                            <a class="text-white"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $negotiation->getClientIDNeg($allNegotiation->id_neg)->client_id); ?>"><?= $allNegotiation->cliente; ?></a>
                                                        </td>
                                                        <td><?= $allNegotiation->vendedor; ?></td>
                                                        <?php if ($allNegotiation->etapa1 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa1 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa1; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data1) ? date_fmt($allNegotiation->data1, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data11) ? date_fmt($allNegotiation->data11, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa2 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa2 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa2; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data2) ? date_fmt($allNegotiation->data2, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data22) ? date_fmt($allNegotiation->data22, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa3 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa3 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa3; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data3) ? date_fmt($allNegotiation->data3, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data33) ? date_fmt($allNegotiation->data33, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <td><?= $allNegotiation->obs; ?></td>
                                                    </tr>
                                                <?php elseif ($negotiation->getClientIDNeg($allNegotiation->id_neg)->reason_loss != ""): ?>
                                                    <tr class="bg-purple text-white">
                                                        <td>
                                                            <a class="text-white"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $negotiation->getClientIDNeg($allNegotiation->id_neg)->client_id); ?>"><?= $allNegotiation->cliente; ?></a>
                                                        </td>
                                                        <td><?= $allNegotiation->vendedor; ?></td>
                                                        <?php if ($allNegotiation->etapa1 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa1 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa1; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data1) ? date_fmt($allNegotiation->data1, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data11) ? date_fmt($allNegotiation->data11, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa2 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa2 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa2; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data2) ? date_fmt($allNegotiation->data2, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data22) ? date_fmt($allNegotiation->data22, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa3 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa3 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa3; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data3) ? date_fmt($allNegotiation->data3, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data33) ? date_fmt($allNegotiation->data33, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <td><?= $allNegotiation->obs; ?></td>
                                                    </tr>
                                                <?php elseif ($negotiation->getClientIDNeg($allNegotiation->id_neg)->contact_type == "PFinalizado"): ?>
                                                    <tr class="bg-success text-white">
                                                        <td>
                                                            <a class="text-white"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $negotiation->getClientIDNeg($allNegotiation->id_neg)->client_id); ?>"><?= $allNegotiation->cliente; ?></a>
                                                        </td>
                                                        <td><?= $allNegotiation->vendedor; ?></td>
                                                        <?php if ($allNegotiation->etapa1 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa1 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa1; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data1) ? date_fmt($allNegotiation->data1, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data11) ? date_fmt($allNegotiation->data11, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa2 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa2 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa2; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data2) ? date_fmt($allNegotiation->data2, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data22) ? date_fmt($allNegotiation->data22, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa3 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa3 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa3; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data3) ? date_fmt($allNegotiation->data3, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data33) ? date_fmt($allNegotiation->data33, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <td><?= $allNegotiation->obs; ?></td>
                                                    </tr>
                                                <?php elseif ($negotiation->getClientIDNeg($allNegotiation->id_neg)->contact_type == "APagamento" || $negotiation->getClientIDNeg($allNegotiation->id_neg)->contact_type == "Orçamento" || $negotiation->getClientIDNeg($allNegotiation->id_neg)->contact_type == "Cotação"): ?>
                                                    <tr class="bg-warning text-white">
                                                        <td>
                                                            <a class="text-white"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $negotiation->getClientIDNeg($allNegotiation->id_neg)->client_id); ?>"><?= $allNegotiation->cliente; ?></a>
                                                        </td>
                                                        <td><?= $allNegotiation->vendedor; ?></td>
                                                        <?php if ($allNegotiation->etapa1 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa1 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa1; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px; "><?= ($allNegotiation->data1) ? date_fmt($allNegotiation->data1, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px; "><?= ($allNegotiation->data11) ? date_fmt($allNegotiation->data11, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa2 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa2 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa2; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data2) ? date_fmt($allNegotiation->data2, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data22) ? date_fmt($allNegotiation->data22, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa3 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa3 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa3; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data3) ? date_fmt($allNegotiation->data3, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data33) ? date_fmt($allNegotiation->data33, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <td><?= $allNegotiation->obs; ?></td>
                                                    </tr>
                                                <?php elseif (date_diff_panel($negotiation->getClientIDNeg($allNegotiation->id_neg)->next_contact) >= 0): ?>
                                                    <tr class="bg-info text-white">
                                                        <td>
                                                            <a class="text-white"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $negotiation->getClientIDNeg($allNegotiation->id_neg)->client_id); ?>"><?= $allNegotiation->cliente; ?></a>
                                                        </td>
                                                        <td><?= $allNegotiation->vendedor; ?></td>
                                                        <?php if ($allNegotiation->etapa1 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa1 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa1; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data1) ? date_fmt($allNegotiation->data1, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data11) ? date_fmt($allNegotiation->data11, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa2 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa2 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa2; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data2) ? date_fmt($allNegotiation->data2, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data22) ? date_fmt($allNegotiation->data22, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa3 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa3 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa3; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data3) ? date_fmt($allNegotiation->data3, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data33) ? date_fmt($allNegotiation->data33, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <td><?= $allNegotiation->obs; ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php elseif ($negotiation->findById($allNegotiation->id_neg)->seller_id == user()->seller_id): ?>
                                                <?php if (date_diff_panel($negotiation->getClientIDNeg($allNegotiation->id_neg)->next_contact) < -1): ?>
                                                    <tr class="bg-danger text-white">
                                                        <td>
                                                            <a class="text-white"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $negotiation->getClientIDNeg($allNegotiation->id_neg)->client_id); ?>"><?= $allNegotiation->cliente; ?></a>
                                                        </td>
                                                        <td><?= $allNegotiation->vendedor; ?></td>
                                                        <?php if ($allNegotiation->etapa1 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa1 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa1; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data1) ? date_fmt($allNegotiation->data1, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data11) ? date_fmt($allNegotiation->data11, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa2 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa2 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa2; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data2) ? date_fmt($allNegotiation->data2, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data22) ? date_fmt($allNegotiation->data22, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa3 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa3 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa3; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data3) ? date_fmt($allNegotiation->data3, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data33) ? date_fmt($allNegotiation->data33, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <td><?= $allNegotiation->obs; ?></td>
                                                    </tr>
                                                <?php elseif ($negotiation->getClientIDNeg($allNegotiation->id_neg)->reason_loss != ""): ?>
                                                    <tr class="bg-purple text-white">
                                                        <td>
                                                            <a class="text-white"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $negotiation->getClientIDNeg($allNegotiation->id_neg)->client_id); ?>"><?= $allNegotiation->cliente; ?></a>
                                                        </td>
                                                        <td><?= $allNegotiation->vendedor; ?></td>
                                                        <?php if ($allNegotiation->etapa1 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa1 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa1; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data1) ? date_fmt($allNegotiation->data1, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data11) ? date_fmt($allNegotiation->data11, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa2 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa2 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa2; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data2) ? date_fmt($allNegotiation->data2, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data22) ? date_fmt($allNegotiation->data22, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa3 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa3 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa3; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data3) ? date_fmt($allNegotiation->data3, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data33) ? date_fmt($allNegotiation->data33, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <td><?= $allNegotiation->obs; ?></td>
                                                    </tr>
                                                <?php elseif ($negotiation->getClientIDNeg($allNegotiation->id_neg)->contact_type == "PFinalizado"): ?>
                                                    <tr class="bg-success text-white">
                                                        <td>
                                                            <a class="text-white"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $negotiation->getClientIDNeg($allNegotiation->id_neg)->client_id); ?>"><?= $allNegotiation->cliente; ?></a>
                                                        </td>
                                                        <td><?= $allNegotiation->vendedor; ?></td>
                                                        <?php if ($allNegotiation->etapa1 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa1 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa1; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data1) ? date_fmt($allNegotiation->data1, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data11) ? date_fmt($allNegotiation->data11, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa2 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa2 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa2; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data2) ? date_fmt($allNegotiation->data2, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data22) ? date_fmt($allNegotiation->data22, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa3 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa3 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa3; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data3) ? date_fmt($allNegotiation->data3, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data33) ? date_fmt($allNegotiation->data33, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <td><?= $allNegotiation->obs; ?></td>
                                                    </tr>
                                                <?php elseif ($negotiation->getClientIDNeg($allNegotiation->id_neg)->contact_type == "APagamento" || $negotiation->getClientIDNeg($allNegotiation->id_neg)->contact_type == "Orçamento" || $negotiation->getClientIDNeg($allNegotiation->id_neg)->contact_type == "Cotação"): ?>
                                                    <tr class="bg-warning text-white">
                                                        <td>
                                                            <a class="text-white"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $negotiation->getClientIDNeg($allNegotiation->id_neg)->client_id); ?>"><?= $allNegotiation->cliente; ?></a>
                                                        </td>
                                                        <td><?= $allNegotiation->vendedor; ?></td>
                                                        <?php if ($allNegotiation->etapa1 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa1 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa1; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data1) ? date_fmt($allNegotiation->data1, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data11) ? date_fmt($allNegotiation->data11, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa2 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa2 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa2; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data2) ? date_fmt($allNegotiation->data2, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data22) ? date_fmt($allNegotiation->data22, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa3 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa3 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa3; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data3) ? date_fmt($allNegotiation->data3, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data33) ? date_fmt($allNegotiation->data33, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <td><?= $allNegotiation->obs; ?></td>
                                                    </tr>
                                                <?php elseif (date_diff_panel($negotiation->getClientIDNeg($allNegotiation->id_neg)->next_contact) >= 0): ?>
                                                    <tr class="bg-info text-white">
                                                        <td>
                                                            <a class="text-white"
                                                               href="<?= url('/admin/negotiations/negotiation/' . $negotiation->getClientIDNeg($allNegotiation->id_neg)->client_id); ?>"><?= $allNegotiation->cliente; ?></a>
                                                        </td>
                                                        <td><?= $allNegotiation->vendedor; ?></td>
                                                        <?php if ($allNegotiation->etapa1 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa1 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa1; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data1) ? date_fmt($allNegotiation->data1, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data11) ? date_fmt($allNegotiation->data11, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa2 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa2 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa2; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data2) ? date_fmt($allNegotiation->data2, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data22) ? date_fmt($allNegotiation->data22, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <?php if ($allNegotiation->etapa3 == "APagamento"): ?>
                                                            <td><?= "Aguardando Pagamento"; ?></td>
                                                        <?php elseif ($allNegotiation->etapa3 == "NRespondeu"): ?>
                                                            <td><?= "Não Respondeu"; ?></td>
                                                        <?php else: ?>
                                                            <td><?= $allNegotiation->etapa3; ?></td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Últ.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data3) ? date_fmt($allNegotiation->data3, "d/m/Y") : ""; ?></p>
                                                            <p class="mt-0" style="font-size: 10px; color: #ccc">Próx.
                                                                Contato</p>
                                                            <p class="mt-0"
                                                               style="font-size: 12px"><?= ($allNegotiation->data33) ? date_fmt($allNegotiation->data33, "d/m/Y") : ""; ?></p>
                                                        </td>
                                                        <td><?= $allNegotiation->obs; ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
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