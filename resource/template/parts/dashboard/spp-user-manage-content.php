<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-end">
					<?php if ( ! in_array( $context, array( 'add', 'delete', 'edit', 'view' ) ) ): ?>
						<a href="<?php echo url( null, null, [ 'context' => 'add' ] ) ?>" class="btn btn-primary mb-4">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
								<line x1="12" y1="5" x2="12" y2="19"></line>
								<line x1="5" y1="12" x2="19" y2="12"></line>
							</svg> Tambah Baru
						</a>
					<?php else: ?>
						<a href="<?php echo request()->getHeader('redirect_url'); ?>" class="btn btn-primary mb-4"> Kembali </a>
					<?php endif ?>
				</div>
			</div>
			<div class="card-body">
				<?php
					render_sukses_notification();
					include( 'user-manage/' . $template );
				?>
			</div>
		</div>
	</div>
</div>