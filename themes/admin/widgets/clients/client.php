<?php $v->layout("_admin"); ?>
<!--App-Content-->
<?php if (!$client): ?>
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Clientes</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/admin/clients/home'); ?>">Clientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Criar Cliente</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Criar Cliente</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/clients/client'); ?>" method="post">
                                <input type="hidden" name="action" value="create">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" name="name"
                                                   placeholder="Digite seu nome">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Estado</label>
                                        <select class="form-control selectState" data-url="<?= url('/admin/clients/address'); ?>" name="state" required>
                                            <option value="">Selecione o estado</option>
                                            <?php foreach ($states as $state): ?>
                                                <option value="<?= $state->id; ?>"><?= $state->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Cidade</label>
                                        <select name="city" class="form-control selectCity"></select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Telefone</label>
                                        <input type="text" class="form-control mask-phone" name="phone"
                                               placeholder="Digite seu telefone">
                                    </div>
                                    <?php if ($sellers): ?>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Vendedor</label>
                                                <select class="form-control" name="seller_id" required>
                                                    <?php foreach ($sellers as $seller): ?>
                                                        <option value="<?= $seller->id; ?>"><?= $seller->fullName(); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php /* <?php if ($funnels): ?>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Etapa</label>
                                                <select class="form-control" name="funnel_id" required>
                                                    <?php foreach ($funnels as $funnel): ?>
                                                        <option value="<?= $funnel->id; ?>"><?= $funnel->title; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?> */ ?>
                                    <div class="form-group col-md-6">
                                        <label>Data do Cadastro</label>
                                        <input type="text" class="form-control mask-date" name="registration_date"
                                               placeholder="Digite sua data">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success ">Criar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Clientes</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/admin/clients/home'); ?>">Clientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Cliente</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Editar Cliente</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/clients/client/' . $client->id); ?>" method="post">
                                <input type="hidden" name="action" value="update">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" name="name"
                                                   value="<?= $client->name; ?>"
                                                   placeholder="Digite seu nome">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Estado</label>
                                        <select class="form-control selectState" data-url="<?= url('/admin/clients/address'); ?>" name="state" required>
                                            <option value="">Selecione o estado</option>
                                            <?php foreach ($states as $state): ?>
                                                <option value="<?= $state->id; ?>" <?= ($state->id == $client->state) ? "selected" : ""; ?> ><?= $state->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Cidade</label>
                                        <select name="city" class="form-control selectCity">
                                            <option value="<?= $client->city; ?>"><?= $client->cityName(); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Telefone</label>
                                        <input type="text" class="form-control mask-phone" name="phone"
                                               value="<?= $client->phone; ?>"
                                               placeholder="Digite seu telefone">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label>Vendedor</label>
                                            <select class="form-control" name="seller_id" required>
                                                <?php foreach ($sellers as $seller): ?>
                                                    <option value="<?= $seller->id; ?>" <?= ($seller->id == $sellerSelected) ? "selected" : ""; ?>><?= $seller->fullName(); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php /* <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label>Etapa</label>
                                            <select class="form-control" name="funnel_id" required>
                                                <?php foreach ($funnels as $funnel): ?>
                                                    <option value="<?= $funnel->id; ?>" <?= ($funnel->id == $funnelSelected) ? "selected" : ""; ?>><?= $funnel->title; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div> */ ?>
                                    <div class="form-group col-md-6">
                                        <label>Data do Cadastro</label>
                                        <input type="text" class="form-control mask-date" name="registration_date"
                                               value="<?= date_fmt($client->registration_date, "d/m/Y"); ?>"
                                               placeholder="Digite sua data">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success ">Atualizar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--/App-Content-->