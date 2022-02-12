<form method="<?php echo $method ?>" action="<?php echo url( $form_url['url'], $form_url['params'] ) ?>" role="form" autocomplete="off">
	<input type="hidden" name="wp_csrf_token" value="<?php echo $token ?>">
	<div class="form-row mb-4">
		<div class="form-group col-md-4">
			<label>Nama Kelas</label>
			<input type="text" name="nama_kelas" class="form-control" placeholder="Nama Kelas" value="<?php echo isset( $kelas->nama_kelas ) ? $kelas->nama_kelas : '' ?>" oninvalid="this.setCustomValidity('Nama Kelas Harus Diisi')" oninput="this.setCustomValidity('')" required />
		</div>
		<div class="form-group col-md-4">
			<label>Angkatan Kelas</label>
			<select name="angkatan_kelas" class="form-control" oninvalid="this.setCustomValidity('Angkatan Kelas Harus Diisi')" oninput="this.setCustomValidity('')" required>
				<option value="" selected="selected" disabled="disabled">--- Pilih Angkatan Kelas ---</option>
				<?php foreach (get_all_angkatan_kelas() as $key => $value): ?>
					<option value="<?php echo $value ?>" <?php echo isset($kelas->angkatan_kelas) && $value == $kelas->angkatan_kelas ? 'selected="selected"' : '' ?>> <?php echo $value ?> </option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group col-md-8">
			<label>Wali Kelas</label>
			<input type="text" name="wali_kelas" class="form-control" placeholder="Wali Kelas" value="<?php echo isset( $kelas->wali_kelas ) ? $kelas->wali_kelas : '' ?>" />
		</div>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-md btn-primary">Submit</button>
	</div>
</form>