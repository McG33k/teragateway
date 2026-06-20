<?php
/**
 * Front page template — mirrors the TGS design mockup exactly.
 * Sections: Hero → Services → Stats Bar → About → Industries → CTA Banner
 *
 * @package tgs-theme
 */

get_header();
?>

<main id="main-content" tabindex="-1">

<!-- ════════════════════════════════════════════
     HERO SECTION
     ════════════════════════════════════════════ -->
<section id="hero" aria-label="<?php esc_attr_e( 'Hero', 'tgs-theme' ); ?>">
    <div class="container">
        <div class="hero-inner">

            <!-- Left: content -->
            <div class="hero-content">
                <h1 class="animate-in">
                    <?php
                    echo wp_kses(
                        get_theme_mod(
                            'tgs_hero_heading',
                            'Empowering Businesses Through <span class="accent-red">Technology</span>'
                        ),
                        [ 'span' => [ 'class' => [] ], 'br' => [] ]
                    );
                    ?>
                </h1>

                <p class="animate-in delay-1">
                    <?php
                    echo esc_html(
                        get_theme_mod(
                            'tgs_hero_subtext',
                            'Tera-Gateway Synergies is a trusted IT consultancy delivering innovative, secure and scalable solutions that drive growth, efficiency and transformation.'
                        )
                    );
                    ?>
                </p>

                <div class="hero-cta animate-in delay-2">
                    <a href="<?php echo esc_url( get_theme_mod( 'tgs_hero_btn_url', home_url( '/contact' ) ) ); ?>"
                       class="btn btn-primary btn-arrow">
                        <?php echo esc_html( get_theme_mod( 'tgs_hero_btn_label', 'Get Started' ) ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '#about' ) ); ?>" class="btn btn-outline">
                        <?php esc_html_e( 'Learn More', 'tgs-theme' ); ?>
                    </a>
                </div>

                <!-- 3 trust badges -->
                <div class="hero-badges animate-in delay-3">
                    <div class="hero-badge">
                        <div class="badge-icon" aria-hidden="true"><i class="fa-solid fa-users"></i></div>
                        <span class="badge-label"><?php esc_html_e( 'Expert Team', 'tgs-theme' ); ?></span>
                    </div>
                    <div class="hero-badge">
                        <div class="badge-icon" aria-hidden="true"><i class="fa-solid fa-shield-halved"></i></div>
                        <span class="badge-label"><?php esc_html_e( 'Secure Solutions', 'tgs-theme' ); ?></span>
                    </div>
                    <div class="hero-badge">
                        <div class="badge-icon" aria-hidden="true"><i class="fa-solid fa-chart-line"></i></div>
                        <span class="badge-label"><?php esc_html_e( 'Business Growth', 'tgs-theme' ); ?></span>
                    </div>
                </div>
            </div><!-- .hero-content -->

            <!-- Right: image with diagonal blue overlay -->
            <div class="hero-image-wrap" aria-hidden="true">
                <?php
                $hero_img = get_theme_mod( 'tgs_hero_image', '' );
                if ( $hero_img ) :
                ?>
                    <img src="<?php echo esc_url( $hero_img ); ?>"
                         alt=""
                         loading="eager"
                         decoding="async">
                <?php else : ?>
                    <!-- Placeholder SVG tech graphic when no image is set -->
                    <svg viewBox="0 0 600 500" xmlns="http://www.w3.org/2000/svg" style="position:absolute;inset:0;width:100%;height:100%;z-index:3;opacity:0.15">
                        <circle cx="300" cy="250" r="180" fill="none" stroke="white" stroke-width="1.5"/>
                        <circle cx="300" cy="250" r="120" fill="none" stroke="white" stroke-width="1"/>
                        <circle cx="300" cy="70"  r="24"  fill="white" opacity="0.6"/>
                        <circle cx="460" cy="180" r="20"  fill="white" opacity="0.5"/>
                        <circle cx="480" cy="360" r="18"  fill="white" opacity="0.4"/>
                        <circle cx="300" cy="430" r="22"  fill="white" opacity="0.5"/>
                        <circle cx="130" cy="340" r="18"  fill="white" opacity="0.4"/>
                        <circle cx="120" cy="160" r="20"  fill="white" opacity="0.5"/>
                        <circle cx="300" cy="250" r="40"  fill="none" stroke="white" stroke-width="2" opacity="0.4"/>
                        <!-- Cloud icon in center -->
                        <text x="300" y="265" text-anchor="middle" fill="white" font-size="48" opacity="0.7">☁</text>
                    </svg>
                <?php endif; ?>
            </div><!-- .hero-image-wrap -->

        </div><!-- .hero-inner -->
    </div><!-- .container -->
</section><!-- #hero -->


<!-- ════════════════════════════════════════════
     OUR SERVICES
     ════════════════════════════════════════════ -->
<section id="services" class="section-py" aria-labelledby="services-heading">
    <div class="container">

        <div class="services-header">
            <h2 id="services-heading" class="section-title">
                <?php esc_html_e( 'Our Services', 'tgs-theme' ); ?>
            </h2>
            <div class="section-divider" aria-hidden="true"></div>
        </div>

        <div class="services-grid">
            <?php
            $services_query = tgs_get_services();

            if ( $services_query->have_posts() ) :
                while ( $services_query->have_posts() ) :
                    $services_query->the_post();
                    $icon = get_post_meta( get_the_ID(), '_tgs_service_icon', true ) ?: 'fa-solid fa-gear';
                    ?>
                    <article class="service-card">
                        <div class="service-icon" aria-hidden="true">
                            <i class="<?php echo esc_attr( $icon ); ?>"></i>
                        </div>
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo esc_html( get_the_excerpt() ); ?></p>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();

            else :
                // Fallback: show hardcoded defaults
                foreach ( tgs_default_services() as $service ) :
                    ?>
                    <article class="service-card">
                        <div class="service-icon" aria-hidden="true">
                            <i class="<?php echo esc_attr( $service['icon'] ); ?>"></i>
                        </div>
                        <h3><?php echo esc_html( $service['title'] ); ?></h3>
                        <p><?php echo esc_html( $service['desc'] ); ?></p>
                    </article>
                    <?php
                endforeach;

            endif;
            ?>
        </div><!-- .services-grid -->

    </div><!-- .container -->
</section><!-- #services -->


<!-- ════════════════════════════════════════════
     STATS BAR
     ════════════════════════════════════════════ -->
<div id="stats-bar" aria-label="<?php esc_attr_e( 'Key figures', 'tgs-theme' ); ?>">
    <div class="container">
        <div class="stats-grid">

            <?php
            $stat_icons = [
                'fa-solid fa-face-smile',
                'fa-regular fa-calendar-check',
                'fa-solid fa-people-group',
                'fa-solid fa-award',
            ];

            $stat_defaults = [
                [ '100+', 'Happy Clients' ],
                [ '250+', 'Projects Delivered' ],
                [ '50+',  'Experts' ],
                [ '10+',  'Years of Excellence' ],
            ];

            for ( $i = 1; $i <= 4; $i++ ) :
                $num   = get_theme_mod( "tgs_stat_{$i}_num",   $stat_defaults[ $i - 1 ][0] );
                $label = get_theme_mod( "tgs_stat_{$i}_label", $stat_defaults[ $i - 1 ][1] );
                ?>
                <div class="stat-item">
                    <div class="stat-icon" aria-hidden="true">
                        <i class="<?php echo esc_attr( $stat_icons[ $i - 1 ] ); ?>"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?php echo esc_html( $num ); ?></div>
                        <div class="stat-label"><?php echo esc_html( $label ); ?></div>
                    </div>
                </div>
            <?php endfor; ?>

        </div><!-- .stats-grid -->
    </div><!-- .container -->
</div><!-- #stats-bar -->


<!-- ════════════════════════════════════════════
     ABOUT / WHY CHOOSE US
     ════════════════════════════════════════════ -->
<section id="about" class="section-py" aria-labelledby="about-heading">
    <div class="container">
        <div class="about-grid">

            <!-- Left: About copy -->
            <div class="about-left">
                <span class="section-label"><?php esc_html_e( 'About Us', 'tgs-theme' ); ?></span>
                <h2 id="about-heading" class="section-title">
                    <?php
                    echo wp_kses(
                        __( 'Your Partner in <span class="accent-red">Technology</span> Excellence', 'tgs-theme' ),
                        [ 'span' => [ 'class' => [] ] ]
                    );
                    ?>
                </h2>
                <div class="section-divider left" aria-hidden="true"></div>

                <p>
                    <?php esc_html_e( 'Tera-Gateway Synergies helps organizations navigate the evolving digital landscape with innovative solutions and dependable support. We are committed to delivering measurable results and long-term value.', 'tgs-theme' ); ?>
                </p>


                <?php
                // Show about image if it exists
                $about_page = get_page_by_path( 'about-us' );
                if ( $about_page && has_post_thumbnail( $about_page->ID ) ) :
                    ?>
                    <div class="about-image">
                        <?php echo get_the_post_thumbnail( $about_page->ID, 'tgs-card', [ 'alt' => __( 'TGS team', 'tgs-theme' ), 'loading' => 'lazy' ] ); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right: Why choose us -->
            <div class="about-right">
                <h3><?php esc_html_e( 'Why Choose Us', 'tgs-theme' ); ?></h3>

                <div class="why-item">
                    <div class="why-icon" aria-hidden="true"><i class="fa-solid fa-handshake"></i></div>
                    <div class="why-content">
                        <h4><?php esc_html_e( 'Client-Centered Approach', 'tgs-theme' ); ?></h4>
                        <p><?php esc_html_e( 'We listen, understand and deliver solutions tailored to your needs.', 'tgs-theme' ); ?></p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-icon" aria-hidden="true"><i class="fa-solid fa-lightbulb"></i></div>
                    <div class="why-content">
                        <h4><?php esc_html_e( 'Innovation-Driven', 'tgs-theme' ); ?></h4>
                        <p><?php esc_html_e( 'We leverage the latest technologies to keep you ahead of the curve.', 'tgs-theme' ); ?></p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-icon" aria-hidden="true"><i class="fa-solid fa-headset"></i></div>
                    <div class="why-content">
                        <h4><?php esc_html_e( 'Reliable Support', 'tgs-theme' ); ?></h4>
                        <p><?php esc_html_e( "We're with you every step of the way – before, during and after implementation.", 'tgs-theme' ); ?></p>
                    </div>
                </div>

            </div><!-- .about-right -->

        </div><!-- .about-grid -->
    </div><!-- .container -->
</section><!-- #about -->


<!-- ════════════════════════════════════════════
     INDUSTRIES WE SERVE
     ════════════════════════════════════════════ -->
<section id="industries" class="section-py" aria-labelledby="industries-heading">
    <div class="container">

        <div class="industries-header">
            <h2 id="industries-heading" class="section-title">
                <?php esc_html_e( 'Industries We Serve', 'tgs-theme' ); ?>
            </h2>
            <div class="section-divider" aria-hidden="true"></div>
        </div>

        <div class="industries-grid">
            <?php foreach ( tgs_default_industries() as $industry ) : ?>
                <div class="industry-item">
                    <div class="industry-icon" aria-hidden="true">
                        <i class="<?php echo esc_attr( $industry['icon'] ); ?>"></i>
                    </div>
                    <span class="industry-label"><?php echo esc_html( $industry['label'] ); ?></span>
                </div>
            <?php endforeach; ?>
        </div><!-- .industries-grid -->

    </div><!-- .container -->
</section><!-- #industries -->


<!-- ════════════════════════════════════════════
     CTA BANNER
     ════════════════════════════════════════════ -->
<section id="cta-banner" aria-label="<?php esc_attr_e( 'Call to action', 'tgs-theme' ); ?>">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-text">
                <h2><?php echo esc_html( get_theme_mod( 'tgs_cta_heading', 'Ready to transform your business?' ) ); ?></h2>
                <p><?php echo esc_html( get_theme_mod( 'tgs_cta_sub', "Let's build the future together." ) ); ?></p>
            </div>
            <a href="<?php echo esc_url( get_theme_mod( 'tgs_cta_url', home_url( '/contact' ) ) ); ?>"
               class="btn btn-white btn-arrow">
                <?php echo esc_html( get_theme_mod( 'tgs_cta_btn', 'Contact Us Today' ) ); ?>
            </a>
        </div><!-- .cta-inner -->
    </div><!-- .container -->
</section><!-- #cta-banner -->

</main><!-- #main-content -->

<?php get_footer(); ?>
