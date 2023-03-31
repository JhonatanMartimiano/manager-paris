<?php $v->layout("_admin"); ?>
<!--App-Content-->
<div class="app-content  my-3 my-md-5">
    <div class="side-app">
        <div class="page-header">
            <h4 class="page-title">Mensagens</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= url('/admin/messages/home'); ?>">Mensagens</a></li>
                <li class="breadcrumb-item active" aria-current="page">Responder Mensagem</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title">Responder Mensagem</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= url('/admin/messages/message'); ?>" method="post">
                            <input type="hidden" name="action" value="create">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label>Destinatário</label>
                                        <select name="recipient" class="form-control" readonly="readonly">
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
                                        <input type="text" class="form-control" name="subject"
                                               value="<?= $message->subject; ?>"
                                               placeholder="Digite o assunto" readonly>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Mensagem</label>
                                    <textarea name="content" rows="5"
                                              class="form-control" placeholder="Digite sua mensagem"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/App-Content-->