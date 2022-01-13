<table class="table-datatable table table-striped table-hover">
	<thead>
		<tr>
			<th>No</th>
			<th>NIS</th>
			<th>Nama</th>
			<th>Kelas</th>
			<th>Alamat</th>
			<th>Nama Wali</th>
			<th>Angkatan</th>
			<th>Status</th>
			<th>Opsi</th>
		</tr>
	</thead>
	<tbody>
		<?php if ( ! $siswa->isEmpty() ):
			$i = 1;
			?>
			<?php foreach ( $siswa as $key => $value ): ?>
				<tr>
					<td> <?php echo $i++; ?> </td>
					<td> <?php echo $value->nis ?> </td>
					<td> <?php echo $value->nama_lengkap ?> </td>
					<td> <?php echo get_kelas( $value->kelas_id ) ?> </td>
					<td> <?php echo $value->alamat ?> </td>
					<td> <?php echo $value->nama_wali ?> </td>
					<td> <?php echo $value->tahun_ajaran ?> </td>
					<td> <?php echo $value->status ?> </td>
					<td>
						<?php echo sprintf( '<a href="%s" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-primary"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>', url( '/wp-admin/dashboard', null, [ 'context' => 'view', 'id' => $value->id ] ) ) ?>
						<?php echo sprintf( '<a href="%s" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>', url( '/wp-admin/dashboard', null, [ 'context' => 'edit', 'id' => $value->id ] ) ); ?>
						<?php echo sprintf( '<a href="javascript:void(0);" class="wp-remove-item" data-target="%s" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>', url( 'delete.siswa', array( 'id' => $value->id ), array( 'wp_csrf_token' => $token ) ) ); ?>
					</td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>