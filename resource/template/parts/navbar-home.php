<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg headroom py-lg-3 px-lg-6 navbar-dark navbar-theme-primary">
    <div class="container">
        <a class="navbar-brand d-none" href="./index.html">
            <img class="navbar-brand-dark common" src="<?php echo get_dist_directory(); ?>/assets/img/brand/light.svg" height="35" alt="Logo light">
            <img class="navbar-brand-light common" src="<?php echo get_dist_directory(); ?>/assets/img/brand/dark.svg" height="35" alt="Logo dark">
        </a>
        <div class="d-none d-lg-block d-lg-none">
            <a href="<?php echo url( 'login.page' ); ?>" class="btn btn-md btn-secondary animate-up-2"><i class="fas fa-paper-plane mr-2"></i> Login</a>
        </div>
        <div class="d-none d-lg-block d-lg-none">
            <a href="<?php echo url( 'register.page' ); ?>" class="btn btn-md btn-secondary animate-up-2"><i class="fas fa-paper-plane mr-2"></i> Daftar</a>
        </div>
        <div class="d-flex d-lg-none align-items-center">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global"
                aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>
        </div>
    </div>
</nav>