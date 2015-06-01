<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>

	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title><?php wp_title(); ?></title>
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

  <section class="container">
    <div class="row mb30">

      <div id="header-logo" class="col-md-4">
        <a class="navbar-brand" href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo(); ?>"><img src="<?php echo of_get_option('of_logo'); ?>" /></a>
      </div>

    </div>
  </section>

  <section id="navbar-main" class="container">
      <div class="navbar navbar-inverse row" role="navigation">
        <div class="col-md-12">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
  						<?php if ( has_nav_menu( 'primary' ) ) {
  							wp_nav_menu( array('theme_location' => 'primary', 'container' => false, 'items_wrap' => '%3$s'));
  						} ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
  </section>

