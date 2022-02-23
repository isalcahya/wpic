<?php
$roles = get_all_roles();
unset( $roles[2] );
?>
<form method="<?php echo $method ?>" action="<?php echo url( $form_url['url'], $form_url['params'] ) ?>" role="form" autocomplete="off">
	<input type="hidden" name="wp_csrf_token" value="<?php echo $token ?>">
	<div class="form-row mb-4">
		<div class="form-group col-md-4">
			<label>Username</label>
			<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo isset( $user->username ) ? $user->username : '' ?>" oninvalid="this.setCustomValidity('UserName Harus Diisi')" oninput="this.setCustomValidity('')" required />
		</div>
		<div class="form-group col-md-4">
			<label>Role</label>
			<select name="role_mask" class="form-control" oninvalid="this.setCustomValidity('Username Harus Diisi')" oninput="this.setCustomValidity('')" required>
				<option value="" selected="selected" disabled="disabled">--- Pilih Roles ---</option>
				<?php foreach ($roles as $key => $value): ?>
					<option value="<?php echo $key ?>" <?php echo isset($user->roles_mask) && $key == $user->roles_mask ? 'selected="selected"' : '' ?>> <?php echo $value ?> </option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label>Email</label>
			<input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo isset( $user->email ) ? $user->email : '' ?>" />
		</div>
		<div class="form-group col-md-4">
			<label>Password</label>
			<input type="text" name="password" class="form-control" placeholder="Password" value="<?php echo isset( $user->passwordString ) ? $user->passwordString : '' ?>" />
		</div>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-md btn-primary">Submit</button>
	</div>
</form>