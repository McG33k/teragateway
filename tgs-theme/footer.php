<!-- ════════════════════════════════════════════
     SITE FOOTER
     ════════════════════════════════════════════ -->
<footer id="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">

            <!-- Brand column -->
            <div class="footer-brand">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
                        <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <circle cx="24" cy="24" r="24" fill="#1A3C8F"/>
                            <text x="50%" y="57%" dominant-baseline="middle" text-anchor="middle"
                                  fill="white" font-family="Poppins, sans-serif" font-size="16" font-weight="700">TGS</text>
                        </svg>
                        <span class="site-logo-text" style="color:#fff">
                            Tera-Gateway <span>Synergies</span>
                        </span>
                    </a>
                <?php endif; ?>

                <p>
                    <?php esc_html_e( 'Your trusted partner in IT consultancy — delivering innovative, secure and scalable technology solutions that drive growth, efficiency and transformation.', 'tgs-theme' ); ?>
                </p>

                <div class="footer-social">
                    <a href="<?php echo esc_url( get_theme_mod( 'tgs_social_fb', '#' ) ); ?>" class="social-link" aria-label="Facebook" rel="noopener noreferrer" target="_blank">
                        <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a href="<?php echo esc_url( get_theme_mod( 'tgs_social_li', '#' ) ); ?>" class="social-link" aria-label="LinkedIn" rel="noopener noreferrer" target="_blank">
                        <i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                    <a href="<?php echo esc_url( get_theme_mod( 'tgs_social_tw', '#' ) ); ?>" class="social-link" aria-label="Twitter / X" rel="noopener noreferrer" target="_blank">
                        <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                    </a>
                    <a href="<?php echo esc_url( get_theme_mod( 'tgs_social_yt', '#' ) ); ?>" class="social-link" aria-label="YouTube" rel="noopener noreferrer" target="_blank">
                        <i class="fa-brands fa-youtube" aria-hidden="true"></i>
                    </a>
                </div>
            </div><!-- .footer-brand -->

            <!-- Quick Links -->
            <div class="footer-col">
                <h4><?php esc_html_e( 'Quick Links', 'tgs-theme' ); ?></h4>
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer-1',
                    'container'      => false,
                    'depth'          => 1,
                    'fallback_cb'    => 'tgs_footer_fallback_links',
                ] );
                ?>
            </div>

            <!-- Services links -->
            <div class="footer-col">
                <h4><?php esc_html_e( 'Services', 'tgs-theme' ); ?></h4>
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer-2',
                    'container'      => false,
                    'depth'          => 1,
                    'fallback_cb'    => 'tgs_footer_fallback_services',
                ] );
                ?>
            </div>

            <!-- Contact Info -->
            <div class="footer-col">
                <h4><?php esc_html_e( 'Contact Us', 'tgs-theme' ); ?></h4>

                <?php
                $email   = get_theme_mod( 'tgs_contact_email',   'info@teragatewaysynergies.com' );
                $phone   = get_theme_mod( 'tgs_contact_phone',   '+263 XXX XXX XXX' );
                $website = get_theme_mod( 'tgs_contact_website', 'www.teragatewaysynergies.com' );
                $address = get_theme_mod( 'tgs_contact_address', 'Harare, Zimbabwe' );
                ?>

                <div class="footer-contact-item">
                    <i class="fa-regular fa-envelope contact-icon" aria-hidden="true"></i>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                </div>

                <div class="footer-contact-item">
                    <i class="fa-solid fa-phone contact-icon" aria-hidden="true"></i>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
                </div>

                <div class="footer-contact-item">
                    <i class="fa-solid fa-globe contact-icon" aria-hidden="true"></i>
                    <a href="https://<?php echo esc_attr( $website ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $website ); ?></a>
                </div>

                <div class="footer-contact-item">
                    <i class="fa-solid fa-location-dot contact-icon" aria-hidden="true"></i>
                    <span><?php echo esc_html( $address ); ?></span>
                </div>
            </div><!-- .footer-col -->

        </div><!-- .footer-grid -->

        <!-- Footer bottom bar -->
        <div class="footer-bottom">
            <p>
                &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                <?php bloginfo( 'name' ); ?>.
                <?php esc_html_e( 'All Rights Reserved.', 'tgs-theme' ); ?>
            </p>
            <nav class="footer-legal" aria-label="<?php esc_attr_e( 'Legal links', 'tgs-theme' ); ?>">
                <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'tgs-theme' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/terms-and-conditions' ) ); ?>"><?php esc_html_e( 'Terms &amp; Conditions', 'tgs-theme' ); ?></a>
            </nav>
        </div><!-- .footer-bottom -->

    </div><!-- .container -->
</footer><!-- #site-footer -->

<?php wp_footer(); ?>
</body>
</html>

<?php
/* ─────────────────────────────────────────────
   FALLBACK MENUS (used when no WP menu assigned)
   ───────────────────────────────────────────── */

function tgs_footer_fallback_links() {
    $links = [
        home_url( '/' )           => 'Home',
        home_url( '/about-us' )   => 'About Us',
        home_url( '/services' )   => 'Services',
        home_url( '/industries' ) => 'Industries',
        home_url( '/solutions' )  => 'Solutions',
        home_url( '/contact' )    => 'Contact Us',
    ];
    echo '<ul>';
    foreach ( $links as $url => $label ) {
        printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
    }
    echo '</ul>';
}

function tgs_footer_fallback_services() {
    $services = [
        'IT Strategy & Consulting',
        'Cloud Solutions',
        'Cybersecurity Services',
        'Managed IT Services',
        'Software Development',
        'Data Analytics & BI',
    ];
    echo '<ul>';
    foreach ( $services as $s ) {
        printf(
            '<li><a href="%s">%s</a></li>',
            esc_url( home_url( '/services' ) ),
            esc_html( $s )
        );
    }
    echo '</ul>';
}
