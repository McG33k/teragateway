<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1A3C8F">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
    <?php esc_html_e( 'Skip to main content', 'tgs-theme' ); ?>
</a>

<!-- ════════════════════════════════════════════
     SITE HEADER
     ════════════════════════════════════════════ -->
<header id="site-header" role="banner">
    <div class="container">
        <div class="header-inner">

            <!-- Logo -->
            <div class="site-logo">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php bloginfo( 'name' ); ?>">
                        <!-- TGS SVG inline logo (matches brand mockup) -->
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <circle cx="24" cy="24" r="24" fill="#1A3C8F"/>
                            <text x="50%" y="57%" dominant-baseline="middle" text-anchor="middle"
                                  fill="white" font-family="Poppins, sans-serif" font-size="16" font-weight="700">TGS</text>
                        </svg>
                        <span class="site-logo-text">
                            Tera-Gateway <span>Synergies</span>
                        </span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation -->
            <nav id="primary-nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'tgs-theme' ); ?>">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'menu_id'        => 'main-menu',
                    'container'      => false,
                    'depth'          => 2,
                    'fallback_cb'    => 'tgs_fallback_nav',
                ] );
                ?>
            </nav>

            <!-- Mobile toggle -->
            <button class="nav-toggle" aria-controls="primary-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'tgs-theme' ); ?>">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div><!-- .header-inner -->
    </div><!-- .container -->
</header><!-- #site-header -->

<?php
/**
 * Fallback navigation when no menu is assigned in WP admin.
 */
function tgs_fallback_nav() {
    $links = [
        home_url( '/' )          => 'Home',
        home_url( '/about-us' )  => 'About Us',
        home_url( '/services' )  => 'Services',
        home_url( '/industries' )=> 'Industries',
        home_url( '/solutions' ) => 'Solutions',
        home_url( '/contact' )   => 'Contact Us',
    ];
    echo '<ul id="main-menu">';
    foreach ( $links as $url => $label ) {
        printf(
            '<li><a href="%s">%s</a></li>',
            esc_url( $url ),
            esc_html( $label )
        );
    }
    echo '</ul>';
}
