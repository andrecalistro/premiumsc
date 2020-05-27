<div class="row">
	<div class="col-sm-12">
		<ul class="pagination custom-pagination">
			<li class="page-item">
				<?= $this->Paginator->prev('<span class="page-link" aria-hidden="true">&laquo;</span>', ['escape' => false]) ?>
			</li>
			<li class="page-item">
				<div class="page-link">
					<?= $this->Paginator->counter(['format' => 'Página <span>{{page}}</span> de {{pages}}']) ?>
				</div>
			</li>
			<li class="page-item">
				<?= $this->Paginator->next('<span class="page-link" aria-hidden="true">&raquo;</span>', ['escape' => false]) ?>
			</li>
		</ul>
	</div>
</div>