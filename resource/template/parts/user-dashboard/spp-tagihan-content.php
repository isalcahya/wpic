
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h3> Informasi Transaksi Tagihan Siswa</h3>
			</div>
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
											<td>
												<a href="<?php echo url('midtrans', ['id'=>$value['transaksi_id']]) ?>" class="btn btn-sm btn-danger">bayar</a>
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
											<td><?php echo $value['status'] ?></td>
											<td>
												<a href="<?php echo url('midtrans.view', ['id'=>$value['transaksi_id']]) ?>" class="btn btn-sm btn-success">lihat</a>
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