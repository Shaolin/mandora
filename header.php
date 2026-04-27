<!DOCTYPE html>
<html>
<head>
    <?php wp_head(); ?>
</head>

<body>


<nav class="main-nav">

  <div class="nav-left">
    <div class="logo">
      <?php
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            bloginfo('name');
        }
      ?>
    </div>
  </div>

  <!-- DESKTOP MENU -->
  <div class="nav-center">
    <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'items_wrap' => '%3$s',
      ]);
    ?>
  </div>

  <!-- MOBILE MENU -->
  <div class="mobile-menu" id="mobileMenu">

    <div class="close-menu" onclick="toggleMenu()">✖</div>

    <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'items_wrap' => '%3$s',
      ]);
    ?>

  </div>

  <div class="nav-right">
    
    <button id="open-apply-form" class="apply-btn">Apply For Job</button>
    <div class="toggle" onclick="toggleMode()">🌙</div>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
  </div>

</nav>

<div class="overlay" onclick="toggleMenu()" id="overlay"></div>



