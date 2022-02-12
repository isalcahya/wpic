<form method="<?php echo $method ?>" action="<?php echo url( $form_url['url'], $form_url['params'] ) ?>" role="form" autocomplete="off">
	<input type="hidden" name="wp_csrf_token" value="<?php echo $token ?>">
	<div class="form-row mb-4">
		<div class="form-group col-md-4">
			<label>Username</label>
			<input type="text" name="username" class="form-control" placeholder="Nama Kelas" value="<?php echo isset( $user->username ) ? $user->username : '' ?>" oninvalid="this.setCustomValidity('UserName Harus Diisi')" oninput="this.setCustomValidity('')" required />
		</div>
		<div class="form-group col-md-4">
			<label>Role</label>
			<select name="roles_mask" class="form-control" oninvalid="this.setCustomValidity('Username Harus Diisi')" oninput="this.setCustomValidity('')" required>
				<option value="" selected="selected" disabled="disabled">--- Pilih Roles ---</option>
				<?php foreach (get_all_roles() as $key => $value): ?>
					<option value="<?php echo $key ?>" <?php echo isset($user->roles_mask) && $key == $user->roles_mask ? 'selected="selected"' : '' ?>> <?php echo $value ?> </option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group col-md-8">
			<label>Email</label>
			<input type="text" name="email" class="form-control" placeholder="Wali Kelas" value="<?php echo isset( $user->email ) ? $user->email : '' ?>" />
		</div>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-md btn-primary">Submit</button>
	</div>
</form>