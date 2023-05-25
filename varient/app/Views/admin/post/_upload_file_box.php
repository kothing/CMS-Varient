<div class="box">
	<div class="box-header with-border">
		<div class="left">
			<h3 class="box-title">
				<?= trans('files'); ?>
				<small class="small-title"><?= trans("files_exp"); ?></small>
			</h3>
		</div>
	</div>
	<div class="box-body">
		<div class="form-group m-0">
			<div class="row">
				<div class="col-sm-12">
					<a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#file_manager">
						<?= trans('select_file'); ?>
					</a>
				</div>
				<div class="col-sm-12 post-selected-files-container">
					<div id="post_selected_files" class="post-selected-files">
						<?php
						if (!empty($post)):
							$files = getPostFiles($post->id);
							if (!empty($files)):
								foreach ($files as $file): ?>
									<div id="post_selected_file_<?= $file->post_file_id; ?>" class="item">
										<div class="left">
											<i class="fa fa-file"></i>
										</div>
										<div class="center">
											<span><?= $file->file_name; ?></span>
										</div>
										<div class="right">
											<a href="javascript:void(0)" class="btn btn-sm btn-selected-file-list-item btn-delete-selected-file-database" data-value="<?= $file->post_file_id; ?>"><i class="fa fa-times"></i></a></p>
										</div>
									</div>
								<?php endforeach;
							endif;
						endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>