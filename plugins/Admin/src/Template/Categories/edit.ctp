<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Editar Categoria</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($category, ['type' => 'file']) ?>
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#content" aria-controls="home" role="tab" data-toggle="tab">Conteúdo</a></li>
				<li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO</a></li>
				<li role="presentation"><a href="#dates" aria-controls="dates" role="tab" data-toggle="tab">Datas</a></li>
			</ul>

			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="content">
					<div class="row">
						<div class="col-md-6 form-group">
							<?= $this->Form->control('title', ['class' => 'form-control', 'label' => 'Título']) ?>
						</div>
						<div class="col-md-6 form-group">
							<?= $this->Form->control('abbreviation', ['class' => 'form-control', 'label' => 'Abreviação']) ?>
						</div>
						<div class="col-md-6 form-group">
							<?= $this->Form->control('order_show',['class' => 'form-control', 'label' => 'Ordem de exibição']) ?>
						</div>

						<div class="col-md-3 form-group">
							<label>Status</label><br>
							<?= $this->Form->radio('status', $statuses, ['hiddenField' => false, 'label' => 'Status']) ?>
						</div>

						<div class="col-md-3 form-group">
							<?= $this->Form->control('show_launch_menu', ['type' => 'checkbox', 'value' => 1, 'label' => 'Exibir menu de lançamentos']) ?>
						</div>

						<div class="form-group col-md-12">
							<?= $this->Form->control('description', ['type' => 'textarea', 'class' => 'form-control', 'label' => 'Descrição', 'rows' => 8]) ?>
						</div>
						<div class="form-group col-md-12">
							<?= $this->Form->control('image', ['type' => 'file', 'class' => 'form-control', 'label' => 'Imagem']) ?>
							<?php if ($category->thumb_image_link): ?>
								<?= $this->Html->image($category->thumb_image_link, ['class' => 'thumbnail', 'width' => 50]) ?>
							<?php endif; ?>
						</div>

						<div class="form-group col-md-12">
							<?= $this->Form->control('parent_id', ['label' => 'Categoria Pai', 'class' => 'form-control', 'empty' => '-- Selecione --', 'options' => $categories]) ?>
						</div>

						<div class="form-group col-md-12">
							<?= $this->Form->control('products_id', ['label' => 'Produto destaque da categoria', 'class' => 'form-control', 'empty' => '-- Selecione --', 'options' => $products]) ?>
						</div>
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

				<div role="tabpanel" class="tab-pane fade" id="dates">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<?= $this->Form->control('release_date', ['type' => 'text', 'class' => 'form-control input-date-time', 'label' => 'Data de Lançamento',
									'value' => $category->formatted_deadlines['release_date']]) ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?= $this->Form->control('expiration_date', ['type' => 'text', 'class' => 'form-control input-date-time', 'label' => 'Data de Expiração',
									'value' => $category->formatted_deadlines['expiration_date']]) ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<hr>
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<?= $this->Html->link("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Voltar", ['controller' => 'categories'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
				</div>
				<div class="col-md-6 col-xs-12 text-right">
					<?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
				</div>
			</div>
        <?= $this->Form->end() ?>
    </div>
</div>
