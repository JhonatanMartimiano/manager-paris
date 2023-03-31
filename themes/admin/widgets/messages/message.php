<?php $v->layout("_admin"); ?>
<!--App-Content-->
<?php if (!$message): ?>
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Mensagens</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/admin/clients/home'); ?>">Mensagens</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Criar Mensagem</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Criar Mensagem</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/messages/message'); ?>" method="post">
                                <input type="hidden" name="action" value="create">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label>Destinatário</label>
                                            <select name="recipient" class="form-control">
                                                <option value="">Selecione o destinatário</option>
                                                <?php if ($recipients): ?>
                                                    <?php foreach ($recipients as $recipient): ?>
                                                        <option value="<?= $recipient->id; ?>"><?= $recipient->fullName(); ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label>Assunto</label>
                                            <input type="text" class="form-control" name="subject"
                                                   placeholder="Digite o assunto">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Mensagem</label>
                                        <textarea name="content" rows="5"
                                                  class="form-control" placeholder="Digite sua mensagem"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Criar</button>
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
                <h4 class="page-title">Mensagens</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/admin/messages/home'); ?>">Mensagens</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mensagem</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Mensagem</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/messages/message/' . $message->id); ?>" method="post">
                                <input type="hidden" name="action" value="update">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <?php if ($message->sender == user()->id): ?>
                                                <label>Destinatário</label>
                                            <?php else: ?>
                                                <label>Remetente</label>
                                            <?php endif; ?>
                                            <select name="recipient" class="form-control" disabled>
                                                <?php if ($message->sender == user()->id): ?>
                                                    <option value="<?= $message->recipient; ?>"><?= $message->recipientFullName(); ?></option>
                                                <?php else: ?>
                                                    <option value="<?= $message->sender; ?>"><?= $message->senderFullName(); ?></option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label>Assunto</label>
                                            <input type="text" class="form-control" name="subject" value="<?= $message->subject; ?>"
                                                   placeholder="Digite o assunto" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Mensagem</label>
                                        <textarea name="content" rows="5"
                                                  class="form-control" placeholder="Digite sua mensagem" disabled><?= $message->content; ?></textarea>
                                    </div>
                                </div>
                            </form>
                            <a href="<?= url('/admin/messages/response/'.$message->id); ?>" class="btn btn-success">Responder</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--/App-Content-->