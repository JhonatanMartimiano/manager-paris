<?php $v->layout("_admin"); ?>
<!--App-Content-->
<div class="app-content  my-3 my-md-5">
    <div class="side-app">
        <div class="page-header">
            <h4 class="page-title">Negociações</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Negociações</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h3 class="card-title">Negociações</h3>
                        </div>
                        <div class="legend d-flex">
                            <div class="bg-danger mr-1">
                                <div class="card-body iconfont text-center">
                                    <h5 class="text-white">Atrasados 24H+</h5>
                                </div>
                            </div>
                            <div class="bg-success mr-1">
                                <div class="card-body iconfont text-center">
                                    <h5 class="text-white">Finalizados</h5>
                                </div>
                            </div>
                            <div class="bg-warning mr-1">
                                <div class="card-body iconfont text-center">
                                    <h5 class="text-white">Aguardando</h5>
                                </div>
                            </div>
                            <div class="bg-info mr-1">
                                <div class="card-body iconfont text-center">
                                    <h5 class="text-white">Em Negociação</h5>
                                </div>
                            </div>
                            <div class="bg-purple">
                                <div class="card-body iconfont text-center">
                                    <h5 class="text-white">Perdidos</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body overflow-auto">
                        <div class="d-flex">
                            <div class="card-style">
                                <div class="card">
                                    <div class="card-header" style="background-color: #000">
                                        <h2 class="text-center text-white mb-0 mx-auto">Pendentes</h2>
                                    </div>
                                    <div class="card-body overflow-auto d-flex flex-column align-items-center">
                                        <?php if ($clients->funnelNewClients()): ?>
                                            <?php foreach ($clients->funnelNewClients() as $newClient): ?>
                                                <a href="<?= url('/admin/negotiations/negotiation/' . $newClient->id); ?>"
                                                   class="p-1">
                                                    <div class="border rounded">
                                                        <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Cliente:</p>
                                                        <p class="m-0 text-center"><?= $newClient->name; ?></p>
                                                        <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Vendedor:</p>
                                                        <p class="m-0 text-center"><?= $newClient->sellerName(); ?></p>
                                                        <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Cadastro:</p>
                                                        <p class="m-0 text-center"><?= date_fmt($newClient->registration_date, "d/m/Y"); ?></p>
                                                        <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Próximo Contato:</p>
                                                        <p class="m-0 text-center"><?= date('d/m/Y', strtotime('+1 days', strtotime($newClient->registration_date))) ?></p>
                                                    </div>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php if ($funnels): ?>
                                <?php foreach ($funnels as $funnel): ?>
                                    <div class="card-style">
                                        <div class="card">
                                            <div class="card-header" style="background-color: #000">
                                                <h2 class="text-center text-white mb-0 mx-auto"><?= $funnel->title; ?></h2>
                                            </div>
                                            <div class="card-body overflow-auto d-flex justify-content-center">
                                                <?php if ($funnel->funnelClients()): ?>
                                                    <?php foreach ($funnel->funnelClients() as $client): ?>
                                                        <a href="<?= url('/admin/negotiations/negotiation/' . $client->id); ?>"
                                                           class="p-1">
                                                            <?php if ($client->lastNegotiationInfo()->next_contact < 1): ?>
                                                                <div class="border rounded text-white bg-danger">
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Cliente:</p>
                                                                    <p class="m-0 text-center"><?= $client->name; ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Vendedor:</p>
                                                                    <p class="m-0 text-center"><?= $client->sellerName(); ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Cadastro:</p>
                                                                    <p class="m-0 text-center"><?= date_fmt($client->registration_date,
                                                                            "d/m/Y"); ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Próximo Contato:</p>
                                                                    <p class="m-0 text-center"><?= ($client->lastNegotiationInfo()->next_contact) ? date_fmt($client->lastNegotiationInfo()->next_contact,
                                                                            "d/m/Y") : "Não informado."; ?></p>
                                                                </div>
                                                            <?php elseif ($client->lastNegotiationInfo()->reason_loss != ""): ?>
                                                                <div class="border rounded text-white bg-purple">
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Cliente:</p>
                                                                    <p class="m-0 text-center"><?= $client->name; ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Vendedor:</p>
                                                                    <p class="m-0 text-center"><?= $client->sellerName(); ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Cadastro:</p>
                                                                    <p class="m-0 text-center"><?= date_fmt($client->registration_date,
                                                                            "d/m/Y"); ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Próximo Contato:</p>
                                                                    <p class="m-0 text-center"><?= ($client->lastNegotiationInfo()->next_contact) ? date_fmt($client->lastNegotiationInfo()->next_contact,
                                                                            "d/m/Y") : "Não informado."; ?></p>
                                                                </div>
                                                            <?php elseif ($client->lastNegotiationInfo()->contact_type == "PFinalizado"): ?>
                                                                <div class="border rounded text-white bg-success">
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Cliente:</p>
                                                                    <p class="m-0 text-center"><?= $client->name; ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Vendedor:</p>
                                                                    <p class="m-0 text-center"><?= $client->sellerName(); ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Cadastro:</p>
                                                                    <p class="m-0 text-center"><?= date_fmt($client->registration_date,
                                                                            "d/m/Y"); ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Próximo Contato:</p>
                                                                    <p class="m-0 text-center"><?= ($client->lastNegotiationInfo()->next_contact) ? date_fmt($client->lastNegotiationInfo()->next_contact,
                                                                            "d/m/Y") : "Não informado."; ?></p>
                                                                </div>
                                                            <?php elseif ($client->lastNegotiationInfo()->contact_type == "APagamento" || $client->lastNegotiationInfo()->contact_type == "Orçamento" || $client->lastNegotiationInfo()->contact_type == "Cotação"): ?>
                                                                <div class="border rounded text-white bg-warning">
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Cliente:</p>
                                                                    <p class="m-0 text-center"><?= $client->name; ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Vendedor:</p>
                                                                    <p class="m-0 text-center"><?= $client->sellerName(); ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Cadastro:</p>
                                                                    <p class="m-0 text-center"><?= date_fmt($client->registration_date,
                                                                            "d/m/Y"); ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Próximo Contato:</p>
                                                                    <p class="m-0 text-center"><?= ($client->lastNegotiationInfo()->next_contact) ? date_fmt($client->lastNegotiationInfo()->next_contact,
                                                                            "d/m/Y") : "Não informado."; ?></p>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="border rounded text-white bg-info">
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Cliente:</p>
                                                                    <p class="m-0 text-center"><?= $client->name; ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Vendedor:</p>
                                                                    <p class="m-0 text-center"><?= $client->sellerName(); ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Cadastro:</p>
                                                                    <p class="m-0 text-center"><?= date_fmt($client->registration_date,
                                                                            "d/m/Y"); ?></p>
                                                                    <p class="m-0 text-center font-weight-bold" style="font-size: 12px">Data do Próximo Contato:</p>
                                                                    <p class="m-0 text-center"><?= ($client->lastNegotiationInfo()->next_contact) ? date_fmt($client->lastNegotiationInfo()->next_contact,
                                                                            "d/m/Y") : "Não informado."; ?></p>
                                                                </div>
                                                            <?php endif; ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/App-Content-->