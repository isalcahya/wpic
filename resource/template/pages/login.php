<?php view()->render( 'header-auth' ); ?>
<!-- Main content -->
<div class="main-content">
	<!-- Header -->
	<div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
	  <div class="container">
	    <div class="header-body text-center mb-7">
	      <div class="row justify-content-center">
	        <div class="col-xl-5 col-lg-6 col-md-8 px-5">
	          <h1 class="text-white">Selamat Datang!</h1>
	          <p class="text-lead text-white">Gunakan form login dibawah ini untuk masuk ke halaman dashboard</p>
	        </div>
	      </div>
	    </div>
	  </div>
	  <div class="separator separator-bottom separator-skew zindex-100">
	    <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
	      <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
	    </svg>
	  </div>
	</div>
	<!-- Page content -->
	<div class="container mt--9 pb-5 text-gray">
	  <div class="row justify-content-center">
	    <div class="col-lg-5 col-md-7">
	      <div class="card bg-secondary border border-soft mb-0">
	        <?php
	        /*
	        <div class="card-header bg-transparent pb-5">
	          <div class="text-center mt-2 mb-3"><small>Sign in with</small></div>
	          <div class="btn-wrapper text-center">
	            <a href="#" class="btn btn-neutral btn-icon">
	              <span class="btn-inner--icon"><img src="<?php echo get_image_directory(); ?>/dashboard/icons/common/github.svg"></span>
	              <span class="btn-inner--text">Github</span>
	            </a>
	            <a href="#" class="btn btn-neutral btn-icon">
	              <span class="btn-inner--icon"><img src="<?php echo get_image_directory(); ?>/dashboard/icons/common/google.svg"></span>
	              <span class="btn-inner--text">Google</span>
	            </a>
	          </div>
	        </div>
	         */
	        ?>
	        <div class="card-body px-lg-5 py-lg-5">
	        <?php
			/*
			<div class="text-center mb-4">
				<small>Or sign in with credentials</small>
			</div>
			 */
	        ?>
	          <form role="form" action="<?= url() ?>" method="POST">
	          	<input type="hidden" name="wp_csrf_token" value="<?= csrf_token(); ?>">
	          	<input type="hidden" name="_login" value="1">
	          	<?php if (isset( $_POST['warning'] )):
	          		$warning = $_POST['warning'];
	          		unset($_POST['warning'])?>
	          	<div class="alert alert-danger" role="alert">
	          		<?php foreach ($warning as $key => $value): ?>
	          			<span><?php echo $value ?><span/>
      				<?php endforeach ?>
				</div>
				<?php endif; ?>
	            <div class="form-group mb-3">
	              <div class="input-group input-group-merge input-group-alternative">
	                <div class="input-group-prepend">
	                  <span class="input-group-text"><i class="ni ni-email-83"></i></span>
	                </div>
	                <input class="form-control" placeholder="Email" type="email" name="user_email" oninvalid="this.setCustomValidity('Jangan Lupa email tidak boleh kosong guys! ')" oninput="this.setCustomValidity('')" required="required">
	              </div>
	            </div>
	            <div class="form-group">
	              <div class="input-group input-group-merge input-group-alternative">
	                <div class="input-group-prepend">
	                  <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
	                </div>
	                <input class="form-control" placeholder="Password" type="password" name="user_pass" oninvalid="this.setCustomValidity('Password juga nggak boleh kosong ya')" oninput="this.setCustomValidity('')" required="required">
	              </div>
	            </div>
	            <div class="custom-control custom-control-alternative custom-checkbox">
	              <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
	              <label class="custom-control-label" for=" customCheckLogin">
	                <span>Remember me</span>
	              </label>
	            </div>
	            <div class="text-center">
	              <button type="submit" class="btn btn-primary my-4">Sign in</button>
	            </div>
	          </form>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<?php view()->render( 'footer-auth' ); ?>