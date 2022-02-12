<form method="<?php echo $method ?>" action="<?php echo url( $form_url['url'], $form_url['params'] ) ?>" role="form" autocomplete="off">

	<input type="hidden" name="wp_csrf_token" value="<?php echo $token ?>">

	<div class="form-row mb-4">
		<div class="form-group col-md-8">
			<label>Nama Lengkap</label>
			<input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" value="<?php echo isset( $siswa->nama_lengkap ) ? $siswa->nama_lengkap : '' ?>" oninvalid="this.setCustomValidity('Nama Lengkap Jangan Lupa Diisi :)')"
  			oninput="this.setCustomValidity('')" required/>
		</div>
		<div class="form-group col-md-4">
			<label>NIS</label>
			<input type="number" name="nis" minlength="16" class="form-control" placeholder="NIS" value="<?php echo isset( $siswa->nis ) ? $siswa->nis : '' ?>" oninvalid="this.setCustomValidity('Nis Juga Jangan Lupa Diisi :)')" oninput="this.setCustomValidity('')" required/>
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-md-4">
			<label>Kelas</label>
			<select name="kelas_id" class="form-control" required="">
				<option value="" selected="selected" disabled="disabled">--- Pilih Kelas ---</option>
				<?php foreach (get_all_kelas() as $key => $value): ?>
					<option value="<?php echo $value['id'] ?>" <?php echo isset($siswa->kelas_id) && $value['id'] === $siswa->kelas_id ? 'selected="selected"' : '' ?>><?php echo $value['nama_kelas'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label>Nama Wali</label>
			<input type="text" name="nama_wali" class="form-control" placeholder="Nama Wali" value="<?php echo isset( $siswa->nama_wali ) ? $siswa->nama_wali : '' ?>" />
		</div>
		<div class="form-group col-md-4">
			<label>Tahun Ajaran</label>
			<input type="text" name="tahun_ajaran" class="form-control" placeholder="Tahun Ajaran" value="<?php echo isset( $siswa->tahun_ajaran ) ? $siswa->tahun_ajaran : '' ?>" />
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-md-8">
			<label>Alamat</label>
			<textarea name="alamat" class="form-control" placeholder="Alamat"><?php echo isset( $siswa->alamat ) ? $siswa->alamat : ''  ?></textarea>
		</div>
		<?php if ( 'edit' === $context ): ?>
		<div class="form-group col-md-4">
			<label>Status</label>
			<select name="status" class="form-control">
				<option value="" selected="selected" disabled="disabled">--- Pilih Status ---</option>
				<?php foreach (array('aktif' => 'Aktif', 'non-aktif' => 'Non Aktif') as $key => $value): ?>
					<option value="<?php echo $key ?>" <?php echo isset($siswa->status) && $key == $siswa->status ? 'selected="selected"' : '' ?>><?php echo $value ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<?php endif ?>
	</div>

	<div class="form-row mb-4">
		<div class="form-group col-md-4">
			<label>Jenis Kelamin</label>
			<div class="custom-control custom-radio">
				<input type="radio" id="male" class="custom-control-input" name="jenis_kelamin" value="laki-laki" <?php echo isset( $siswa->jenis_kelamin ) && $siswa->jenis_kelamin === 'laki-laki' ? 'checked="checked"' : '' ?> required/>
				<label class="custom-control-label" for="male">Laki-laki</label>
			</div>
			<div class="custom-control custom-radio">
				<input type="radio" id="female" class="custom-control-input" name="jenis_kelamin" value="perempuan" <?php echo isset( $siswa->jenis_kelamin ) && $siswa->jenis_kelamin === 'perempuan' ? 'checked="checked"' : '' ?> required/>
				<label class="custom-control-label" for="female">Perempuan</label>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h4> Kelola Hak Akses </h4>
		</div>
		<div class="card-body">
			<div class="form-row mb-4">
				<div class="form-group col-md-4">
					<label>Username</label>
					<input type="text" name="privelege[username]" class="form-control" placeholder="username" <?php echo 'edit' === $context ? 'disabled="disabled"' : '' ?> value="<?php echo isset( $privelege->username ) ? $privelege->username : '' ?>" oninvalid="this.setCustomValidity('Hak Akses Username Harus diisi')" oninput="this.setCustomValidity('')" required/>
				</div>
				<div class="form-group col-md-4">
					<label>Email</label>
					<input type="text" name="privelege[email]" class="form-control" placeholder="email" <?php echo 'edit' === $context ? 'disabled="disabled"' : '' ?> value="<?php echo isset( $privelege->email ) ? $privelege->email : '' ?>" oninvalid="this.setCustomValidity('Hak Akses Email Harus diisi')" oninput="this.setCustomValidity('')" required/>
				</div>
				<div class="form-group col-md-4">
					<label>Password</label>
					<input type="text" name="privelege[password]" minlength="6" class="form-control" <?php echo 'edit' === $context ? 'disabled="disabled"' : '' ?> placeholder="password" value="<?php echo isset( $siswa->password ) ? $siswa->password : '' ?>" oninvalid="this.setCustomValidity('Hak Akses Password Harus diisi')" oninput="this.setCustomValidity('')" required/>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-md btn-primary">Submit</button>
	</div>
</form>