<?php $v->layout("_admin"); ?>
<!--App-Content-->
<div class="app-content  my-3 my-md-5">
    <div class="side-app">
        <div class="page-header">
            <h4 class="page-title">Mensagens</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mensagens</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h3 class="card-title">Caixa de Entrada</h3>
                            <div>
                                <?php if (user()->level >= 5): ?>
                                    <a href="<?= url('admin/messages/message'); ?>" class="btn btn-pill btn-success">Enviar Mensagem</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form class="form-inline mb-1" action="<?= url('/admin/funnels/home'); ?>" method="post">
                                <div class="nav-search">
                                    <input type="search" class="form-control header-search" name="s"
                                           value="<?= $search; ?>" placeholder="Buscar…" aria-label="Search">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                            <table class="table table-bordered border-top mb-0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Remetente</th>
                                    <th>Assunto</th>
                                    <th>Mensagem</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($messages): ?>
                                    <?php foreach ($messages as $message): ?>
                                        <tr>
                                            <th scope="row"><?= $message->id; ?></th>
                                            <td><?= $message->senderFullName(); ?></td>
                                            <td><?= $message->subject; ?></td>
                                            <td><?= $message->content; ?></td>
                                            <td><?= date_fmt($message->created_at, "d/m/Y H:i"); ?></td>
                                                <td align="center">
                                                    <a href="<?= url('/admin/messages/message/'.$message->id); ?>"
                                                       class="btn btn-info btn-sm" title="Visualizar"><i
                                                                class="fa fa-eye"></i></a>
                                                    <?php if (user()->level >= 5): ?>
                                                    <a href="#" class="btn btn-danger btn-sm"
                                                       data-post="<?= url("/admin/funnels/funnel/{$message->id}"); ?>"
                                                       data-action="delete"
                                                       data-confirm="ATENÇÃO: Tem certeza que deseja excluir o funil e todos os dados relacionados a ele? Essa ação não pode ser feita!"
                                                       data-message_id="<?= $message->id; ?>" title="Excluir"><i
                                                                class="fa fa-trash"></i></a>
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
    </div>
</div>
<!--/App-Content-->