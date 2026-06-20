<?php
/**
 * Main index template — used for blog and any page without a specific template.
 *
 * @package tgs-theme
 */

get_header();
?>

<main id="main-content" class="section-py" tabindex="-1">
    <div class="container">

        <?php if ( is_home() && ! is_front_page() ) : ?>
            <header class="page-header" style="margin-bottom:40px">
                <h1 class="section-title"><?php single_post_title(); ?></h1>
                <div class="section-divider left"></div>
            </header>
        <?php endif; ?>

        <div class="index-layout" style="display:grid;grid-template-columns:2fr 1fr;gap:48px;align-items:start">

            <!-- Posts -->
            <div class="posts-area">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>
                                 style="margin-bottom:40px;padding-bottom:40px;border-bottom:1px solid var(--tgs-border)">

                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                    <?php the_post_thumbnail( 'tgs-card', [ 'loading' => 'lazy', 'style' => 'width:100%;height:240px;object-fit:cover;border-radius:8px;margin-bottom:20px' ] ); ?>
                                </a>
                            <?php endif; ?>

                            <p style="font-size:.75rem;letter-spacing:.08em;text-transform:uppercase;color:var(--tgs-navy);font-weight:600;margin-bottom:8px">
                                <?php echo esc_html( get_the_date() ); ?>
                            </p>

                            <h2 style="font-size:1.3rem;margin-bottom:12px">
                                <a href="<?php the_permalink(); ?>" style="color:var(--tgs-dark-navy)">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <p><?php the_excerpt(); ?></p>

                            <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="margin-top:16px;font-size:.8rem;padding:10px 20px">
                                <?php esc_html_e( 'Read More', 'tgs-theme' ); ?> &rsaquo;
                            </a>
                        </article>
                    <?php endwhile; ?>

                    <!-- Pagination -->
                    <div class="pagination" style="margin-top:32px">
                        <?php the_posts_pagination( [
                            'prev_text' => '&laquo; ' . __( 'Previous', 'tgs-theme' ),
                            'next_text' => __( 'Next', 'tgs-theme' ) . ' &raquo;',
                        ] ); ?>
                    </div>

                <?php else : ?>
                    <p><?php esc_html_e( 'No posts found.', 'tgs-theme' ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside id="secondary" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'tgs-theme' ); ?>">
                <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-1' ); ?>
                <?php endif; ?>
            </aside>

        </div>
    </div>
</main>

<?php get_footer(); ?>
