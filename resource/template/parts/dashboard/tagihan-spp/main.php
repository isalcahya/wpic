<table class="table-datatable table table-striped table-hover">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Tagihan</th>
			<th>Bulan</th>
			<th>Tahun</th>
			<th>Kelas</th>
			<th>Target</th>
			<th>Jumlah Tagihan</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php if ( ! $tagihan->isEmpty() ): $i = 1;?>
			<?php foreach ( $tagihan as $key => $value ): ?>
				<tr>
					<td> <?php echo $i++; ?> </td>
					<td> <?php echo $value->nama_tagihan ?> </td>
					<td> <?php echo $value->bulan ?> </td>
					<td> <?php echo $value->tahun ?> </td>
					<td> <?php echo $value->angkatan_kelas ?> </td>
					<td> <?php echo get_tagihan_label( $value->target )  ?> </td>
					<td> <?php echo rupiah($value->total_tagihan) ?> </td>
					<td>
						<?php echo sprintf( '<a href="%s" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-primary"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>', url( null, null, [ 'context' => 'view', 'id' => $value->id ] ) ) ?>
						<?php if ( has_role( 1 ) ): ?>
							<?php echo sprintf( '<a href="javascript:void(0);" class="wp-remove-item" data-target="%s" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>', url( 'delete.tagihan', array( 'id' => $value->id ), array( 'wp_csrf_token' => $token ) ) ); ?>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>