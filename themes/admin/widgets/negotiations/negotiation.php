<?php $v->layout("_admin"); ?>
<!--App-Content-->
<div class="app-content  my-3 my-md-5">
    <div class="side-app">
        <div class="page-header">
            <h4 class="page-title">Negociações</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= url('/admin/negotiations/home'); ?>">Negociações</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalhe da Negociação</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title">Detalhe da Negociação</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= url('/admin/negotiations/negotiation/' . $client->id); ?>" method="post">
                            <input type="hidden" name="action" value="create">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="name"
                                               value="<?= $client->name; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" class="form-control" name="state"
                                               value="<?= $client->stateName(); ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input type="text" class="form-control" name="city"
                                               value="<?= $client->cityName(); ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input type="text" class="form-control mask-phone" name="phone"
                                               value="<?= $client->phone; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label>Como nos conheceu</label>
                                        <select name="met_us" class="form-control">
                                            <option value="">Selecione uma opção</option>
                                            <option value="Instagram" <?= ("Instagram" == $client->lastNegotiationInfo()->met_us) ? "selected" : ""; ?>>
                                                Instagram
                                            </option>
                                            <option value="Facebook" <?= ("Facebook" == $client->lastNegotiationInfo()->met_us) ? "selected" : ""; ?>>
                                                Facebook
                                            </option>
                                            <option value="Indicação" <?= ("Indicação" == $client->lastNegotiationInfo()->met_us) ? "selected" : ""; ?>>
                                                Indicação
                                            </option>
                                            <option value="Blogueira" <?= ("Blogueira" == $client->lastNegotiationInfo()->met_us) ? "selected" : ""; ?>>
                                                Blogueira
                                            </option>
                                            <option value="Google" <?= ("Google" == $client->lastNegotiationInfo()->met_us) ? "selected" : ""; ?>>
                                                Google
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label>Ramo</label>
                                        <select name="branch" class="form-control">
                                            <option value="">Selecione uma opção</option>
                                            <option value="Vendedor" <?= ("Vendedor" == $client->lastNegotiationInfo()->branch) ? "selected" : ""; ?>>
                                                Vendedor
                                            </option>
                                            <option value="Distribuidor" <?= ("Distribuidor" == $client->lastNegotiationInfo()->branch) ? "selected" : ""; ?>>
                                                Distribuidor
                                            </option>
                                            <option value="Salão" <?= ("Salão" == $client->lastNegotiationInfo()->branch) ? "selected" : ""; ?>>
                                                Salão
                                            </option>
                                            <option value="Outros" <?= ("Outros" == $client->lastNegotiationInfo()->branch) ? "selected" : ""; ?>>
                                                Outros
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label>Etapa</label>
                                        <select name="contact_type" class="form-control">
                                            <option value="">Selecione uma opção</option>
                                            <option value="Apresentação" <?= ("Apresentação" == $client->lastNegotiationInfo()->contact_type) ? "selected" : ""; ?>>
                                                Apresentação
                                            </option>
                                            <option value="Tabela" <?= ("Tabela" == $client->lastNegotiationInfo()->contact_type) ? "selected" : ""; ?>>
                                                Tabela
                                            </option>
                                            <option value="Catalago" <?= ("Catalago" == $client->lastNegotiationInfo()->contact_type) ? "selected" : ""; ?>>
                                                Catalago
                                            </option>
                                            <option value="Proposta" <?= ("Proposta" == $client->lastNegotiationInfo()->contact_type) ? "selected" : ""; ?>>
                                                Proposta
                                            </option>
                                            <option value="Orçamento" <?= ("Orçamento" == $client->lastNegotiationInfo()->contact_type) ? "selected" : ""; ?>>
                                                Orçamento
                                            </option>
                                            <option value="Cotação" <?= ("Cotação" == $client->lastNegotiationInfo()->contact_type) ? "selected" : ""; ?>>
                                                Cotação
                                            </option>
                                            <option value="APagamento" <?= ("APagamento" == $client->lastNegotiationInfo()->contact_type) ? "selected" : ""; ?>>
                                                Aguardando Pagamento
                                            </option>
                                            <option value="PFinalizado" <?= ("PFinalizado" == $client->lastNegotiationInfo()->contact_type) ? "selected" : ""; ?>>
                                                Pedido Finalizado
                                            </option>
                                            <option value="Marketing" <?= ("Marketing" == $client->lastNegotiationInfo()->contact_type) ? "selected" : ""; ?>>
                                                Marketing
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3 d-none">
                                    <div class="form-group">
                                        <label>Data do Cadastro</label>
                                        <input type="text" class="form-control"
                                               value="<?= date_fmt($client->registration_date, 'd/m/Y'); ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label>Motivo da perda</label>
                                        <select name="reason_loss" class="form-control">
                                            <option value="">Selecione uma opção</option>
                                            <option value="Preço" <?= ("Preço" == $client->lastNegotiationInfo()->reason_loss) ? "selected" : ""; ?>>
                                                Preço
                                            </option>
                                            <option value="Cadastro" <?= ("Cadastro" == $client->lastNegotiationInfo()->reason_loss) ? "selected" : ""; ?>>
                                                Cadastro Reprovado
                                            </option>
                                            <option value="Investimento" <?= ("Investimento" == $client->lastNegotiationInfo()->reason_loss) ? "selected" : ""; ?>>
                                                Sem Investimento
                                            </option>
                                            <option value="Prazo" <?= ("Prazo" == $client->lastNegotiationInfo()->reason_loss) ? "selected" : ""; ?>>
                                                Prazo
                                            </option>
                                            <option value="Frete" <?= ("Frete" == $client->lastNegotiationInfo()->reason_loss) ? "selected" : ""; ?>>
                                                Frete
                                            </option>
                                            <option value="NRespondeu" <?= ("NRespondeu" == $client->lastNegotiationInfo()->reason_loss) ? "selected" : ""; ?>>
                                                Não Respondeu
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Selecione uma opção</option>
                                            <option value="Negociação" <?= ("Negociação" == $client->status) ? "selected" : ""; ?>>
                                                Em Negociação
                                            </option>
                                            <option value="Concluído" <?= ("Concluído" == $client->status) ? "selected" : ""; ?>>
                                                Concluído
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><b style="color: #ff382b;">Contato Atual</b></label>
                                        <select class="form-control" name="funnel_id" required>
                                            <?php foreach ($funnels as $funnel): ?>
                                                <option value="<?= $funnel->id; ?>" <?= ($funnel->id == $funnelSelected) ? "selected" : ""; ?>><?= $funnel->title; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><b>Data Próximo Contato</b></label>
                                        <input type="text" name="next_contact"
                                               value="<?= ($client->lastNegotiationInfo()->next_contact) ? date_fmt($client->lastNegotiationInfo()->next_contact, "d/m/Y") : ''; ?>"
                                               class="form-control mask-date">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Observação</label>
                                    <textarea name="description" rows="2"
                                              class="form-control" placeholder="Digite sua descrição"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success ">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title">Histórico da Negociação</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <?php if ($negotiations): ?>
                                <?php foreach ($negotiations as $negotiation): ?>
                                    <div class="d-flex">
                                        <div>
                                            <div class="border pr-5">
                                                <h5><?= $negotiation->infoFunnel()->title; ?></h5>
                                            </div>
                                            <div class="border-left border-right border-bottom p-1">
                                                <p class="m-0"><?= date_fmt_br($negotiation->created_at); ?></p>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="border pr-5">
                                                <h5>ETAPA</h5>
                                            </div>
                                            <div class="border-left border-right border-bottom p-1">
                                                <p class="m-0"><?= $negotiation->contact_type; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div>
                                    <div class="border pr-5">
                                        <h5>Oberservação</h5>
                                    </div>
                                    <div class="border-left border-right border-bottom p-1">
                                        <p class="m-0"><?= $negotiation->infoClient()->lastNegotiationInfo()->description; ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/App-Content-->