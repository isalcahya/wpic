<?php view()->render( 'header-auth' ); ?>
<!-- Main content -->
<div class="main-content">
  <!-- Header -->
  <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
    <div class="container">
      <div class="header-body text-center mb-7">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-8 px-5">
            <h1 class="text-white"><?php _e( 'Create an account', 'WPIC' ) ?></h1>
            <p class="text-lead text-white"><?php _e( 'Use these awesome forms to login or create new account in your project for free.', 'WPIC' ) ?></p>
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
  <div class="container mt--9 pb-5">
    <!-- Table -->
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="card bg-secondary border border-soft">
          <div class="card-header bg-transparent pb-5">
            <div class="text-muted text-center mt-2 mb-4"><small><?php _e( 'Sign up with', 'WPIC' ) ?></small></div>
            <div class="text-center">
              <a href="#" class="btn btn-neutral btn-icon">
                <span class="btn-inner--icon"><img src="<?php echo get_dist_directory(); ?>/assets/img/icons/common/google.svg"></span>
                <span class="btn-inner--text"><?php _e( 'Google', 'WPIC' ) ?></span>
              </a>
            </div>
          </div>
          <div class="card-body px-lg-5 py-lg-5">
            <div class="text-center text-muted mb-4">
              <small><?php _e( 'Or sign up with credentials', 'WPIC' ) ?></small>
            </div>
            <form action="<?= url(); ?>" method="post">
              <input type="hidden" name="wp_csrf_token" value="<?= csrf_token(); ?>">
              <input type="hidden" name="_register" value="1">
              <div class="form-group">
                <div class="input-group input-group-merge input-group-alternative mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                  </div>
                  <input class="form-control" placeholder="Name" type="text" name="user.username">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group input-group-merge input-group-alternative mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                  </div>
                  <input class="form-control" placeholder="Email" type="email" name="user.email">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group input-group-merge input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                  </div>
                  <input class="form-control" placeholder="Password" type="password" name="user.pass">
                </div>
              </div>
              <div class="text-muted font-italic"><small><?php _e( 'password strength :', 'WPIC' ) ?><span class="text-success font-weight-700">strong</span></small></div>
              <div class="row my-4">
                <div class="col-12">
                  <div class="custom-control custom-control-alternative custom-checkbox">
                    <input class="custom-control-input" id="customCheckRegister" type="checkbox">
                    <label class="custom-control-label" for="customCheckRegister">
                      <span class="text-muted"><?php _e( 'I agree with the', 'WPIC' ) ?> <a href="#!"><?php _e( 'Privacy Policy', 'WPIC' ) ?></a></span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary mt-4"><?php _e( 'Create account', 'WPIC' ) ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php view()->render( 'footer-auth' ); ?>