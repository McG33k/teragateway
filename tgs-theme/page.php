<?php
/**
 * Default page template.
 *
 * @package tgs-theme
 */

get_header();
?>

<main id="main-content" class="section-py" tabindex="-1">
    <div class="container">

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="page-header" style="margin-bottom:40px">
                    <h1 class="section-title"><?php the_title(); ?></h1>
                    <div class="section-divider left" aria-hidden="true"></div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <figure style="margin-bottom:40px;border-radius:12px;overflow:hidden">
                        <?php the_post_thumbnail( 'tgs-hero', [ 'loading' => 'eager', 'style' => 'width:100%;max-height:420px;object-fit:cover' ] ); ?>
                    </figure>
                <?php endif; ?>

                <div class="entry-content" style="max-width:780px">
                    <?php
                    the_content();
                    wp_link_pages( [
                        'before' => '<nav class="page-links"><span>' . __( 'Pages:', 'tgs-theme' ) . '</span>',
                        'after'  => '</nav>',
                    ] );
                    ?>
                </div>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>
