<?php $v->layout("_admin"); ?>
<!--App-Content-->
<?php if (!$funnel): ?>
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Funis de Venda</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/admin/clients/home'); ?>">Funis de Venda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Criar Funil</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Criar Funil</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/funnels/funnel'); ?>" method="post">
                                <input type="hidden" name="action" value="create">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label>Título</label>
                                            <input type="text" class="form-control" name="title"
                                                   placeholder="Digite seu título">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label>Ordem</label>
                                            <input type="number" class="form-control" name="sequence"
                                                   placeholder="Digite sua ordem">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Descrição</label>
                                        <textarea name="description" rows="5"
                                                  class="form-control" placeholder="Digite sua descrição"></textarea>
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
                <h4 class="page-title">Funis de Venda</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/admin/funnels/home'); ?>">Funis de Venda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Funil</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Editar Funil</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/funnels/funnel/' . $funnel->id); ?>" method="post">
                                <input type="hidden" name="action" value="update">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label>Título</label>
                                            <input type="text" class="form-control" name="title"
                                                   value="<?= $funnel->title; ?>"
                                                   placeholder="Digite seu título">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label>Ordem</label>
                                            <input type="number" class="form-control" name="sequence"
                                                   value="<?= $funnel->sequence; ?>"
                                                   placeholder="Digite sua ordem">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Descrição</label>
                                        <textarea name="description" rows="5"
                                                  class="form-control"
                                                  placeholder="Digite sua descrição"><?= $funnel->description; ?></textarea>
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