<?php
/*
=========================================================
* Impact Design System - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/impact-design-system
* Copyright 2010 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/impact-design-system/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Primary Meta Tags -->
<title></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="title" content="Impact - Design System">

<!-- Canonical SEO -->
<link rel="canonical" href="https://www.creative-tim.com/product/impact-design-system" />

<!--  Social tags      -->
<meta name="keywords" content="impact design system, design system, login, form, table, tables, calendar, card, cards, navbar, modal, icons, icons, map, chat, carousel, menu, datepicker, gallery, slider, date, sidebar, social, dropdown, search, tab, nav, footer, date picker, forms, tabs, time, button, select, input, timeline, cart, car, fullcalendar, about us, invoice, account, chat, log in, blog, profile, portfolio, landing page, ecommerce, shop, landing, register, app, contact, one page, sign up, signup, store, bootstrap 4, bootstrap4, dashboard, bootstrap 4 dashboard, bootstrap 4 design, bootstrap 4 system, bootstrap 4, bootstrap 4 uit kit, bootstrap 4 kit, impact, impact ui kit, creative tim, html kit, html css template, web template, bootstrap, bootstrap 4, css3 template, frontend, responsive bootstrap template, bootstrap ui kit, responsive ui kit, impact dashboard">
<meta name="description" content="Kick-Start Your Development With An Awesome Design System carefully designed for your online business showcase. It comes as a complete solution, with front pages and dashboard pages included.">

<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="Impact Design System by Creative Tim">
<meta itemprop="description" content="Kick-Start Your Development With An Awesome Design System carefully designed for your online business showcase. It comes as a complete solution, with front pages and dashboard pages included.">

<meta itemprop="image" content="https://s3.amazonaws.com/creativetim_bucket/products/296/original/opt_impact_thumbnail.jpg">

<!-- Favicon -->
<link rel="icon" href="./front/assets/img/favicon/favicon.png" type="image/png">

<!-- enqueue css -->
<?php wcic_head(); ?>
</head>

<body>
    <header class="header-global">
    <?php do_action( 'wcic_navbar_template' ) ?>
    </header>
    <main style="height: 100vh; background-image: url(<?php echo get_image_directory() . '/bg-home.jpeg' ?> );">
        <div class="preloader bg-soft flex-column justify-content-center align-items-center">
            <div class="loader-element">
                <span class="loader-animated-dot"></span>
                <img src="<?php echo get_dist_directory(); ?>/assets/img/brand/dark-loader.svg" height="40" alt="Impact logo">
            </div>
        </div>