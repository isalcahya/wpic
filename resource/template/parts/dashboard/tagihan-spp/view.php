<?php
use Models\Kelas;
?>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th colspan="2">
				<h3> Data Tagihan </h3>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $tagihan->toArray() as $key => $value ): ?>
			<tr>
				<td> <?php echo ucfirst(implode( ' ', explode( '_', $key ) ));  ?></td>
				<?php if ( $key === 'total_tagihan' ): ?>
					<td> <?php echo rupiah($value) ?> </td>
				<?php else: ?>
					<td> <?php echo ucfirst($value) ?> </td>
				<?php endif ?>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<br/>
<div class="main">
	<br/>
	<h3> Daftar Siswa yang sudah membayar </h3>
	<br/>
	<table class="table-datatable table table-striped table-hover">
		<thead>
			<tr>
				<th> Nama Siswa </th>
				<th> Kelas </th>
				<th> Tanggal Pembayaran </th>
			</tr>
		</thead>
		<tbody>
			<?php if ( ! empty( $extra ) ): ?>
				<?php foreach ( $extra as $key => $value ): ?>
					<tr>
						<td> <?php echo $value['nama_lengkap'] ?> </td>
						<td> <?php echo isset(Kelas::find($value['kelas_id'])->nama_kelas) ? Kelas::find($value['kelas_id'])->nama_kelas : '' ?> </td>
						<td> <?php echo $value['updated_at']; ?> </td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</tbody>
	</table>
</div>