<?php
/**
 * Single post template.
 *
 * @package tgs-theme
 */

get_header();
?>

<main id="main-content" class="section-py" tabindex="-1">
    <div class="container" style="max-width:840px">

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="page-header" style="margin-bottom:32px">
                    <?php
                    $cats = get_the_category();
                    if ( $cats ) :
                        echo '<p style="font-size:.75rem;letter-spacing:.1em;text-transform:uppercase;font-weight:600;color:var(--tgs-navy);margin-bottom:8px">';
                        echo esc_html( $cats[0]->name );
                        echo '</p>';
                    endif;
                    ?>
                    <h1 class="section-title" style="font-size:clamp(1.6rem,4vw,2.6rem)"><?php the_title(); ?></h1>
                    <div class="section-divider left" aria-hidden="true"></div>
                    <p style="font-size:.85rem;color:var(--tgs-muted);margin-top:12px">
                        <?php
                        printf(
                            esc_html__( 'By %1$s · %2$s', 'tgs-theme' ),
                            '<strong>' . esc_html( get_the_author() ) . '</strong>',
                            esc_html( get_the_date() )
                        );
                        ?>
                    </p>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <figure style="margin-bottom:40px;border-radius:12px;overflow:hidden">
                        <?php the_post_thumbnail( 'tgs-hero', [ 'loading' => 'eager', 'style' => 'width:100%;max-height:460px;object-fit:cover' ] ); ?>
                    </figure>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="post-footer" style="margin-top:48px;padding-top:24px;border-top:1px solid var(--tgs-border)">
                    <?php the_tags( '<p style="font-size:.85rem;color:var(--tgs-muted)">' . __( 'Tags: ', 'tgs-theme' ), ', ', '</p>' ); ?>
                    <?php
                    the_post_navigation( [
                        'prev_text' => '&laquo; %title',
                        'next_text' => '%title &raquo;',
                    ] );
                    ?>
                </footer>

            </article>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>

        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>
