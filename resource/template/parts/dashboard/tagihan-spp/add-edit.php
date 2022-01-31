<form method="<?php echo $method ?>" action="<?php echo url( $form_url['url'], $form_url['params'] ) ?>" role="form" autocomplete="off">
	<input type="hidden" name="wp_csrf_token" value="<?php echo $token ?>">
	<div class="form-row mb-4">
		<div class="form-group col-md-4">
			<label>Nama Tagihan</label>
			<select name="nama_tagihan" class="form-control">
				<option value="" selected="selected" disabled="disabled">--- Pilih Nama Tagihan ---</option>
				<?php foreach (get_all_nama_tagihan() as $key => $value): ?>
					<option value="<?php echo $key ?>"> <?php echo $value ?> </option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label>Jangka Waktu Tagihan</label>
			<select name="jangka_waktu_tagihan" class="form-control">
				<option value="" selected="selected" disabled="disabled">--- Pilih Jangka Waktu Tagihan ---</option>
				<?php foreach (get_all_durasi_tagihan() as $key => $value): ?>
					<option value="<?php echo $key ?>"> <?php echo $value ?> </option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label>Angkatan Kelas</label>
			<select name="angkatan_kelas" class="form-control">
				<option value="" selected="selected" disabled="disabled">--- Pilih Angkatan Kelas ---</option>
				<?php foreach (get_all_angkatan_kelas() as $key => $value): ?>
					<option value="<?php echo $value ?>" <?php echo isset($kelas->angkatan_kelas) && $value == $kelas->angkatan_kelas ? 'selected="selected"' : '' ?>> <?php echo $value ?> </option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-4">
			<label>Bulan Tagihan</label>
			<select name="bulan" class="form-control" id="bulan_tagihan">
				<option value="" selected="selected" disabled="disabled">--- Pilih Bulan ---</option>
				<?php foreach (get_bulan_tagihan() as $key => $value): ?>
					<option value="<?php echo $key ?>"> <?php echo $value ?> </option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label>Tahun Ajaran</label>
			<input type="text" name="tahun" class="form-control" placeholder="Tahun Ajaran" value="" />
		</div>
		<div class="form-group col-md-4">
			<label>Target</label>
			<select name="target" class="form-control" id="target_tagihan">
				<option value="" selected="selected" disabled="disabled">--- Pilih Target ---</option>
				<?php foreach (get_target_tagihan() as $key => $value): ?>
					<option value="<?php echo $key ?>"> <?php echo $value ?> </option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label>Total Biaya</label>
			<input type="text" name="total_tagihan" class="form-control" placeholder="Total Biaya" value="" />
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-4">
			<label>Catatan</label>
			<textarea name="catatan" class="form-control" cols="30" rows="10"></textarea>
		</div>
		<div class="form-group col-md-4 target-container" style="display: none">
			<label>Pilih Siswa</label>
			<select name="pilihan_siswa" class="form-control dropdown-siswa">
				<option value="">Pilih Siswa</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-12">
				<button type="submit" class="btn btn-md btn-primary">Submit</button>
			</div>
		</div>
	</div>
</form>