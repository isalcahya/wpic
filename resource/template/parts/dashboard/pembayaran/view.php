
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<ul class="nav nav-tabs" id="pending-payment" role="tablist">
					<li class="nav-item">
						<a class="nav-link active nav-cashier" id="tab-cashier-pending" data-toggle="tab" href="#spp-pending-payment" role="tab" aria-selected="true">
							<h4>Menunggu Pembayaran</h4>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link nav-cashier" id="tab-cashier-paid" data-toggle="tab" href="#spp-paid-payment" role="tab" aria-selected="false">
							<h4>Sudah di bayar</h4>
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="spp-pending-payment" class="tab-pane active">
						<br/>
						<table id="spp-pending-table" class="table table-striped table-hover table-datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Tahun Ajaran</th>
									<th scope="col">Jenis Pembayaran</th>
									<th scope="col">Jangka Waktu Tagihan</th>
									<th scope="col">Total Tagihan</th>
									<th scope="col">Status Tagihan</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if ( ! empty($tagihan['pending']) ): $i = 1; ?>
									<?php foreach ( $tagihan['pending'] as $key => $value ): $i++
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $value['tahun_ajaran'] ?></td>
											<td><?php echo $value['nama_tagihan'] ?></td>
											<td><?php echo $value['jangka_waktu_tagihan'] ?></td>
											<td><?php echo $value['total_tagihan'] ?></td>
											<td><?php echo $value['status_transaksi'] ?></td>
											<td>
												<?php echo sprintf( '<a href="%s" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>', url( null, null, [ 'context' => 'edit', 'id' => $value['transaksi_id'] ] ) ); ?>
												<?php echo sprintf( '<a href="javascript:void(0);" class="wp-remove-item" data-target="%s" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>', url( 'delete.siswa', array( 'id' => $value['transaksi_id'] ), array( 'wp_csrf_token' => csrf_token() ) ) ); ?>
											</td>
										</tr>
									<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>
					<div id="spp-paid-payment" class="tab-pane fade">
						<br/>
						<table id="spp-paid-table" class="table table-striped table-hover table-datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Tahun Ajaran</th>
									<th scope="col">Jenis Pembayaran</th>
									<th scope="col">Total Bayar</th>
									<th scope="col">Tanggal Pembayaran</th>
									<th scope="col">Status Pembayaran</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if ( ! empty($tagihan['completed']) ): $i = 1; ?>
									<?php foreach ( $tagihan['completed'] as $key => $value ): $i++
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $value['tahun_ajaran'] ?></td>
											<td><?php echo $value['nama_tagihan'] ?></td>
											<td><?php echo $value['total_tagihan'] ?></td>
											<td><?php echo $value['updated_at'] ?></td>
											<td><?php echo $value['status_transaksi'] ?></td>
											<td>
												<a href="<?php echo url('pembayaran.view', ['id'=>$value['transaksi_id']]) ?>" class="btn btn-sm btn-success">Lihat</a>
											</td>
										</tr>
									<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>