<!--

=========================================================
* Impact Design System - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/impact-design-system
* Copyright 2010 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/impact-design-system/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Impact Dashboard</title>

  <!-- Canonical SEO -->
  <link rel="canonical" href="https://www.creative-tim.com/product/impact-design-system" />

  <!-- Favicon -->
  <link rel="icon" href="<?php echo get_dist_directory(); ?>/assets/img/brand/favicon.png" type="image/png">
  <?php wcic_head(); ?>
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  d-flex  align-items-center">
        <a class="navbar-brand" href="">
          <img src="<?php echo get_dist_directory(); ?>/assets/img/brand/dark.svg" height="40" class="navbar-brand-img" alt="...">
        </a>
        <div class=" ml-auto ">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <?php foreach ( wpic_get_menus_dashboard() as $key => $menu ): ?>
              <?php if ( isset($menu['child']) && !empty($menu['child']) ): ?>
                <li class="nav-item">
                  <a class="nav-link" href="#<?php echo $menu['page_id']; ?>" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="<?php echo $menu['page_id']; ?>">
                    <i class="<?php echo $menu['iconcode']; ?> text-primary"></i>
                    <span class="nav-link-text"><?php echo $menu['menu_title']; ?></span>
                  </a>
                  <div class="collapse show" id="<?php echo $menu['page_id']; ?>">
                    <ul class="nav nav-sm flex-column">
                      <li class="nav-item">
                        <a href="<?php echo url( $menu['page_id'] ); ?>" class="nav-link">
                          <span class="sidenav-mini-icon"> <?php echo ucfirst($menu['menu_title'][0]); ?> </span>
                          <span class="sidenav-normal"> <?php _e( ucfirst($menu['menu_title']), 'wpic' ) ?> </span>
                        </a>
                      </li>
                      <?php foreach ( $menu['child'] as $key => $child ): ?>
                        <li class="nav-item">
                          <a href="<?php echo url( 'child.'.$child['page_id'] ); ?>" class="nav-link">
                            <span class="sidenav-mini-icon"> <?php echo ucfirst($child['menu_slug'][0]) ?> </span>
                            <span class="sidenav-normal"> <?php _e( ucfirst( $child['menu_slug'] ), 'wpic' ); ?> </span>
                          </a>
                        </li>
                      <?php endforeach ?>
                    </ul>
                  </div>
                </li>
              <?php else: ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo url( $menu['page_id'] ) ?>">
                    <i class="<?php echo $menu['iconcode']; ?>"></i>
                    <span class="nav-link-text"><?php _e( ucfirst( $menu['menu_title'] ), 'wpic' ) ?></span>
                  </a>
                </li>
              <?php endif ?>
            <?php endforeach ?>
            <!-- <hr class="my-3"> -->
            <!-- <h6 class="navbar-heading pl-4 text-muted">
              <span class="docs-normal">Documentation</span>
            </h6>
            <li class="nav-item">
              <a class="nav-link" href="https://demos.creative-tim.com/impact-design-system-pro/docs/getting-started/quick-start/">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://demos.creative-tim.com/impact-design-system-pro/docs/dashboard/alerts/">
                <i class="ni ni-ui-04"></i>
                <span class="nav-link-text">Components</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://demos.creative-tim.com/impact-design-system-pro/docs/plugins/charts/">
                <i class="ni ni-chart-pie-35"></i>
                <span class="nav-link-text">Plugins</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active active-pro" href="https://www.creative-tim.com/product/impact-design-system-pro" target="_blank">
                <i class="ni ni-send text-primary"></i>
                <span class="nav-link-text">Upgrade to PRO</span>
              </a>
            </li> -->
          </ul>
        </div>
      </div>
    </div>
  </nav>