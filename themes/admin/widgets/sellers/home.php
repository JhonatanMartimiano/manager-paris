<?php $v->layout("_admin"); ?>
<?php $v->start("styles"); ?>
<!--App-Content-->
<div class="app-content  my-3 my-md-5">
    <div class="side-app">
        <div class="page-header">
            <h4 class="page-title">Vendedores</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vendedores</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h3 class="card-title">Vendedores</h3>
                            <div>
                                <a href="<?= url('/admin/sellers/seller'); ?>" class="btn btn-pill btn-success"><i class="fa fa-plus"></i> Adicionar Vendedor</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form class="form-inline mb-1" action="<?= url('/admin/sellers/home'); ?>" method="post">
                                <div class="nav-search">
                                    <input type="search" class="form-control header-search" name="s" value="<?= $search; ?>" placeholder="Buscar…" aria-label="Search">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                            <table class="table table-bordered border-top mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>CPF</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($sellers) : ?>
                                        <?php foreach ($sellers as $seller) : ?>
                                            <tr>
                                                <th scope="row"><?= $seller->id; ?></th>
                                                <td><?= $seller->fullName(); ?></td>
                                                <td><?= $seller->email; ?></td>
                                                <td class="mask-doc"><?= $seller->cpf; ?></td>
                                                <td align="center">
                                                    <?php if (user()->level >= 5) : ?>
                                                        <a href="<?= url('/admin/sellers/seller/' . $seller->id); ?>" class="btn btn-info btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>

                                                        <a href="#" class="btn btn-danger btn-sm" data-post="<?= url("/admin/sellers/seller/{$seller->id}"); ?>" data-action="delete" data-confirm="ATENÇÃO: Tem certeza que deseja excluir o vendedor e todos os dados relacionados a ele? Essa ação não pode ser feita!" data-seller_id="<?= $seller->id; ?>" title="Excluir"><i class="fa fa-trash"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?= $paginator; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalNotification" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalNotificationLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNotificationLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea name="content" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" name="status">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-success">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/App-Content-->