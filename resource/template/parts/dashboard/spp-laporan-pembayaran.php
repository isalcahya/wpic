<div class="row">
	<div class="col-md-12">
		<div class="card-body">
			<div class="main">
				<div class="container-fluid">
					<h3> Filter : </h3>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<select name="region_id" class="form-control select2 dt-quick-filter kelas" data-column="4">
								<option value="">-- Pilih Kelas --</option>
								<?php foreach (get_all_kelas() as $type => $value) : ?>
								<option value="<?php echo $value['nama_kelas']; ?>"><?php echo $value['nama_kelas']; ?></option>
								<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<select name="region_id" class="form-control select2 dt-quick-filter bulan" data-column="3">
								<option value="">-- Pilih Bulan --</option>
								<?php foreach (get_bulan_tagihan() as $type => $title) : ?>
								<option value="<?php echo $type; ?>"><?php echo $title; ?></option>
								<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<select name="region_id" class="form-control select2 dt-quick-filter angkatan" data-column="2">
								<option value="">-- Pilih Tahun Ajaran --</option>
								<?php foreach (get_list_tahun_ajaran() as $type => $title) : ?>
								<option value="<?php echo $title; ?>"><?php echo $title; ?></option>
								<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<select name="region_id" class="form-control select2 dt-quick-filter status-transaksi" data-column="5">
								<option value="">-- Pilih Status Transaksi --</option>
								<?php foreach (array( 'pending', 'on-process', 'completed' ) as $type => $title) : ?>
								<option value="<?php echo $title; ?>"><?php echo $title; ?></option>
								<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid">
					<button class="btn btn-md btn-danger cetak-laporan">Cetak Laporan</button>
				</div>
				<br/>
				<table class="table-datatable table table-striped table-hover">
					<thead>
						<tr>
							<th> Nama Siswa </th>
							<th> Nama Tagihan </th>
							<th> Tahun Ajaran </th>
							<th> Bulan </th>
							<th> Kelas </th>
							<th> Status Transaksi </th>
							<th> Jumlah Tagihan </th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $transactions as $key => $value ): ?>
							<tr>
								<td> <?php echo $value['nama_lengkap'] ?> </td>
								<td> <?php echo $value['nama_tagihan'] ?> </td>
								<td> <?php echo $value['tahun'] ?> </td>
								<td> <?php echo $value['bulan'] ?> </td>
								<td> <?php echo get_kelas($value['kelas_id']) ?> </td>
								<td> <?php echo $value['status_transaksi'] ?> </td>
								<td> <?php echo rupiah($value['total_tagihan']) ?> </td>
							</tr>
						<?php endforeach ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>