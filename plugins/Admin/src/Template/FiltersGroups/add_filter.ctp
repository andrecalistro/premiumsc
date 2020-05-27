<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Cadastrar Filtro</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($filter, ['type' => 'file']) ?>
			<?= $this->Form->control('filters_groups_id', ['type' => 'hidden', 'value' => $filters_groups_id]) ?>

			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#content" aria-controls="content" role="tab" data-toggle="tab">Conteúdo</a></li>
				<li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO</a></li>
			</ul>

			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="content">
					<div class="form-group">
						<?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome do Grupo']) ?>
					</div>
					<div class="form-group">
						<?= $this->Form->control('description', ['class' => 'form-control input-editor', 'label' => 'Descrição', 'type' => 'textarea']) ?>
					</div>
				</div>

				<div role="tabpanel" class="tab-pane fade" id="seo">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<?= $this->Form->control('seo_url', ['class' => 'form-control', 'label' => 'Url']) ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?= $this->Form->control('seo_title', ['class' => 'form-control', 'label' => 'Título SEO']) ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?= $this->Form->control('seo_description', ['class' => 'form-control', 'label' => 'Descrição SEO']) ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?= $this->Form->control('seo_image', ['type' => 'file', 'class' => 'form-control', 'label' => 'Imagem SEO (1200x630px)']) ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<hr>
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<?= $this->Html->link("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Cancelar", ['action' => 'index', 'plugin' => 'admin'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
				</div>
				<div class="col-md-6 col-xs-12 text-right">
					<?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
				</div>
			</div>
        <?= $this->Form->end() ?>
    </div>
</div>