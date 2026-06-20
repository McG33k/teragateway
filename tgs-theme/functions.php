<?php
/**
 * Tera-Gateway Synergies Theme - functions.php
 *
 * @package tgs-theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─────────────────────────────────────────────
// THEME SETUP
// ─────────────────────────────────────────────
function tgs_theme_setup() {
    load_theme_textdomain( 'tgs-theme', get_template_directory() . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ] );
    add_theme_support( 'custom-logo', [
        'height'      => 96,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );

    // Menus
    register_nav_menus( [
        'primary'  => __( 'Primary Navigation', 'tgs-theme' ),
        'footer-1' => __( 'Footer Quick Links', 'tgs-theme' ),
        'footer-2' => __( 'Footer Services',    'tgs-theme' ),
    ] );

    // Custom image sizes
    add_image_size( 'tgs-hero',    1440, 700, true );
    add_image_size( 'tgs-card',    600,  400, true );
    add_image_size( 'tgs-thumb',   300,  200, true );
    add_image_size( 'tgs-team',    400,  500, true );
}
add_action( 'after_setup_theme', 'tgs_theme_setup' );

// ─────────────────────────────────────────────
// ENQUEUE ASSETS
// ─────────────────────────────────────────────
function tgs_enqueue_assets() {
    $ver = wp_get_theme()->get( 'Version' );

    // Google Fonts: Inter + Poppins
    wp_enqueue_style(
        'tgs-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style( 'tgs-style', get_stylesheet_uri(), [ 'tgs-fonts' ], $ver );

    // Font Awesome (icons)
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );

    // Main JS
    wp_enqueue_script(
        'tgs-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        $ver,
        true   // load in footer
    );

    // Localize script data
    wp_localize_script( 'tgs-main', 'tgsData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'tgs_nonce' ),
        'homeUrl' => home_url(),
    ] );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'tgs_enqueue_assets' );

// ─────────────────────────────────────────────
// WIDGET AREAS
// ─────────────────────────────────────────────
function tgs_register_sidebars() {
    $shared = [
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ];

    register_sidebar( array_merge( $shared, [
        'name'        => __( 'Sidebar', 'tgs-theme' ),
        'id'          => 'sidebar-1',
        'description' => __( 'Main sidebar widgets.', 'tgs-theme' ),
    ] ) );

    register_sidebar( array_merge( $shared, [
        'name'        => __( 'Footer Column 1', 'tgs-theme' ),
        'id'          => 'footer-1',
        'description' => __( 'Footer widget area – column 1', 'tgs-theme' ),
    ] ) );

    register_sidebar( array_merge( $shared, [
        'name'        => __( 'Footer Column 2', 'tgs-theme' ),
        'id'          => 'footer-2',
        'description' => __( 'Footer widget area – column 2', 'tgs-theme' ),
    ] ) );
}
add_action( 'widgets_init', 'tgs_register_sidebars' );

// ─────────────────────────────────────────────
// THEME OPTIONS (Customizer)
// ─────────────────────────────────────────────
function tgs_customizer( WP_Customize_Manager $wp_customize ) {
    // Panel
    $wp_customize->add_panel( 'tgs_panel', [
        'title'    => __( 'TGS Theme Options', 'tgs-theme' ),
        'priority' => 30,
    ] );

    // ── Hero Section ──────────────────────────
    $wp_customize->add_section( 'tgs_hero', [
        'title' => __( 'Hero Section', 'tgs-theme' ),
        'panel' => 'tgs_panel',
    ] );

    $hero_fields = [
        'tgs_hero_heading'    => [ 'label' => 'Hero Heading',    'default' => 'Empowering Businesses Through <span class="accent-red">Technology</span>' ],
        'tgs_hero_subtext'    => [ 'label' => 'Hero Sub-text',   'default' => 'Tera-Gateway Synergies is a trusted IT consultancy delivering innovative, secure and scalable solutions that drive growth, efficiency and transformation.' ],
        'tgs_hero_btn_label'  => [ 'label' => 'Button Label',    'default' => 'Get Started' ],
        'tgs_hero_btn_url'    => [ 'label' => 'Button URL',      'default' => '/contact' ],
    ];

    foreach ( $hero_fields as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'wp_kses_post' ] );
        $wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'tgs_hero', 'type' => 'text' ] );
    }

    // Hero image
    $wp_customize->add_setting( 'tgs_hero_image', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'tgs_hero_image', [
        'label'   => __( 'Hero Background Image', 'tgs-theme' ),
        'section' => 'tgs_hero',
    ] ) );

    // ── Stats Bar ─────────────────────────────
    $wp_customize->add_section( 'tgs_stats', [
        'title' => __( 'Stats Bar', 'tgs-theme' ),
        'panel' => 'tgs_panel',
    ] );

    $stats = [
        [ 'num' => '100+', 'label' => 'Happy Clients' ],
        [ 'num' => '250+', 'label' => 'Projects Delivered' ],
        [ 'num' => '50+',  'label' => 'Experts' ],
        [ 'num' => '10+',  'label' => 'Years of Excellence' ],
    ];

    for ( $i = 1; $i <= 4; $i++ ) {
        $default_num   = $stats[ $i - 1 ]['num'];
        $default_label = $stats[ $i - 1 ]['label'];
        $wp_customize->add_setting( "tgs_stat_{$i}_num",   [ 'default' => $default_num,   'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_setting( "tgs_stat_{$i}_label", [ 'default' => $default_label, 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( "tgs_stat_{$i}_num",   [ 'label' => "Stat $i Number", 'section' => 'tgs_stats', 'type' => 'text' ] );
        $wp_customize->add_control( "tgs_stat_{$i}_label", [ 'label' => "Stat $i Label",  'section' => 'tgs_stats', 'type' => 'text' ] );
    }

    // ── CTA Banner ────────────────────────────
    $wp_customize->add_section( 'tgs_cta', [
        'title' => __( 'CTA Banner', 'tgs-theme' ),
        'panel' => 'tgs_panel',
    ] );
    $wp_customize->add_setting( 'tgs_cta_heading', [ 'default' => 'Ready to transform your business?', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_setting( 'tgs_cta_sub',     [ 'default' => "Let's build the future together.",  'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_setting( 'tgs_cta_btn',     [ 'default' => 'Contact Us Today',                  'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_setting( 'tgs_cta_url',     [ 'default' => '/contact',                          'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( 'tgs_cta_heading', [ 'label' => 'CTA Heading', 'section' => 'tgs_cta', 'type' => 'text' ] );
    $wp_customize->add_control( 'tgs_cta_sub',     [ 'label' => 'CTA Sub-text', 'section' => 'tgs_cta', 'type' => 'text' ] );
    $wp_customize->add_control( 'tgs_cta_btn',     [ 'label' => 'Button Label', 'section' => 'tgs_cta', 'type' => 'text' ] );
    $wp_customize->add_control( 'tgs_cta_url',     [ 'label' => 'Button URL',   'section' => 'tgs_cta', 'type' => 'url' ] );

    // ── Contact Info ──────────────────────────
    $wp_customize->add_section( 'tgs_contact_info', [
        'title' => __( 'Contact Details', 'tgs-theme' ),
        'panel' => 'tgs_panel',
    ] );
    $contact_fields = [
        'tgs_contact_email'   => [ 'label' => 'Email',   'default' => 'info@teragatewaysynergies.com' ],
        'tgs_contact_phone'   => [ 'label' => 'Phone',   'default' => '+263 XXX XXX XXX' ],
        'tgs_contact_website' => [ 'label' => 'Website', 'default' => 'www.teragatewaysynergies.com' ],
        'tgs_contact_address' => [ 'label' => 'Address', 'default' => 'Harare, Zimbabwe' ],
        'tgs_social_fb'       => [ 'label' => 'Facebook URL',  'default' => '#' ],
        'tgs_social_li'       => [ 'label' => 'LinkedIn URL',  'default' => '#' ],
        'tgs_social_tw'       => [ 'label' => 'Twitter/X URL', 'default' => '#' ],
        'tgs_social_yt'       => [ 'label' => 'YouTube URL',   'default' => '#' ],
    ];
    foreach ( $contact_fields as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'tgs_contact_info', 'type' => 'text' ] );
    }
}
add_action( 'customize_register', 'tgs_customizer' );

// ─────────────────────────────────────────────
// CUSTOM POST TYPES
// ─────────────────────────────────────────────

// Services CPT
function tgs_register_cpts() {
    register_post_type( 'tgs_service', [
        'label'  => __( 'Services', 'tgs-theme' ),
        'labels' => [
            'name'          => __( 'Services',     'tgs-theme' ),
            'singular_name' => __( 'Service',      'tgs-theme' ),
            'add_new_item'  => __( 'Add Service',  'tgs-theme' ),
            'edit_item'     => __( 'Edit Service',  'tgs-theme' ),
        ],
        'public'              => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-admin-tools',
        'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'has_archive'         => true,
        'rewrite'             => [ 'slug' => 'services' ],
    ] );

    register_post_type( 'tgs_team', [
        'label'       => __( 'Team Members', 'tgs-theme' ),
        'public'      => true,
        'show_in_rest'=> true,
        'menu_icon'   => 'dashicons-groups',
        'supports'    => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'rewrite'     => [ 'slug' => 'team' ],
    ] );

    register_post_type( 'tgs_testimonial', [
        'label'       => __( 'Testimonials', 'tgs-theme' ),
        'public'      => false,
        'show_ui'     => true,
        'show_in_rest'=> true,
        'menu_icon'   => 'dashicons-format-quote',
        'supports'    => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
    ] );
}
add_action( 'init', 'tgs_register_cpts' );

// ─────────────────────────────────────────────
// META BOXES
// ─────────────────────────────────────────────
function tgs_add_meta_boxes() {
    add_meta_box( 'tgs_service_meta', __( 'Service Details', 'tgs-theme' ), 'tgs_service_meta_cb', 'tgs_service', 'normal', 'high' );
    add_meta_box( 'tgs_team_meta',    __( 'Team Member Info', 'tgs-theme' ), 'tgs_team_meta_cb',   'tgs_team',    'normal', 'high' );
}
add_action( 'add_meta_boxes', 'tgs_add_meta_boxes' );

function tgs_service_meta_cb( WP_Post $post ) {
    wp_nonce_field( 'tgs_save_meta', 'tgs_meta_nonce' );
    $icon  = get_post_meta( $post->ID, '_tgs_service_icon',  true );
    $order = get_post_meta( $post->ID, '_tgs_service_order', true );
    echo '<p><label>' . __( 'Font Awesome Icon class (e.g. fa-solid fa-cloud)', 'tgs-theme' ) . '</label><br>';
    echo '<input type="text" name="tgs_service_icon" value="' . esc_attr( $icon ) . '" style="width:100%"></p>';
    echo '<p><label>' . __( 'Display Order', 'tgs-theme' ) . '</label><br>';
    echo '<input type="number" name="tgs_service_order" value="' . esc_attr( $order ) . '" style="width:80px"></p>';
}

function tgs_team_meta_cb( WP_Post $post ) {
    wp_nonce_field( 'tgs_save_meta', 'tgs_meta_nonce' );
    $role   = get_post_meta( $post->ID, '_tgs_team_role',     true );
    $email  = get_post_meta( $post->ID, '_tgs_team_email',    true );
    $linked = get_post_meta( $post->ID, '_tgs_team_linkedin',  true );
    echo '<p><label>' . __( 'Job Title / Role', 'tgs-theme' ) . '</label><br><input type="text" name="tgs_team_role" value="' . esc_attr( $role ) . '" style="width:100%"></p>';
    echo '<p><label>' . __( 'Email', 'tgs-theme' ) . '</label><br><input type="email" name="tgs_team_email" value="' . esc_attr( $email ) . '" style="width:100%"></p>';
    echo '<p><label>' . __( 'LinkedIn URL', 'tgs-theme' ) . '</label><br><input type="url" name="tgs_team_linkedin" value="' . esc_attr( $linked ) . '" style="width:100%"></p>';
}

function tgs_save_meta( int $post_id ) {
    if ( ! isset( $_POST['tgs_meta_nonce'] ) || ! wp_verify_nonce( $_POST['tgs_meta_nonce'], 'tgs_save_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $service_fields = [ 'tgs_service_icon' => '_tgs_service_icon', 'tgs_service_order' => '_tgs_service_order' ];
    foreach ( $service_fields as $key => $meta_key ) {
        if ( isset( $_POST[ $key ] ) ) update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $key ] ) );
    }
    $team_fields = [ 'tgs_team_role' => '_tgs_team_role', 'tgs_team_email' => '_tgs_team_email', 'tgs_team_linkedin' => '_tgs_team_linkedin' ];
    foreach ( $team_fields as $key => $meta_key ) {
        if ( isset( $_POST[ $key ] ) ) update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $key ] ) );
    }
}
add_action( 'save_post', 'tgs_save_meta' );

// ─────────────────────────────────────────────
// TEMPLATE TAGS / HELPERS
// ─────────────────────────────────────────────

/**
 * Retrieve the TGS logo markup (custom logo or text fallback).
 */
function tgs_logo_markup( string $class = '' ): string {
    if ( has_custom_logo() ) {
        return get_custom_logo();
    }
    return sprintf(
        '<a href="%s" class="site-logo %s"><span class="site-logo-text">Tera-Gateway <span>Synergies</span></span></a>',
        esc_url( home_url( '/' ) ),
        esc_attr( $class )
    );
}

/**
 * Get services for the homepage grid.
 *
 * @param int $limit
 * @return WP_Query
 */
function tgs_get_services( int $limit = 8 ): WP_Query {
    return new WP_Query( [
        'post_type'      => 'tgs_service',
        'posts_per_page' => $limit,
        'orderby'        => 'meta_value_num',
        'meta_key'       => '_tgs_service_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ] );
}

/**
 * Default services data (used when no CPT posts exist yet).
 */
function tgs_default_services(): array {
    return [
        [ 'icon' => 'fa-solid fa-chess-rook',        'title' => 'IT Strategy & Consulting',   'desc' => 'Align technology with business goals through expert advice, assessments and roadmap planning.' ],
        [ 'icon' => 'fa-solid fa-arrows-rotate',      'title' => 'Digital Transformation',     'desc' => 'Modernize operations, automate processes and deliver exceptional customer experiences.' ],
        [ 'icon' => 'fa-solid fa-cloud-arrow-up',     'title' => 'Cloud Solutions',             'desc' => 'Migrate, deploy and optimize cloud environments for scalability, flexibility and cost-efficiency.' ],
        [ 'icon' => 'fa-solid fa-shield-halved',      'title' => 'Cybersecurity Services',      'desc' => 'Protect your business with risk assessments, threat monitoring and robust security solutions.' ],
        [ 'icon' => 'fa-solid fa-network-wired',      'title' => 'Network & Infrastructure',    'desc' => 'Design, implement and manage reliable networks and IT infrastructure.' ],
        [ 'icon' => 'fa-solid fa-code',               'title' => 'Software Development',        'desc' => 'Build custom applications and integrate systems that streamline your business.' ],
        [ 'icon' => 'fa-solid fa-headset',            'title' => 'Managed IT Services',         'desc' => 'Proactive monitoring, support and maintenance to keep your systems running at peak performance.' ],
        [ 'icon' => 'fa-solid fa-chart-bar',          'title' => 'Data Analytics & BI',         'desc' => 'Turn your data into actionable insights with advanced analytics and reporting.' ],
    ];
}

/**
 * Default industries list.
 */
function tgs_default_industries(): array {
    return [
        [ 'icon' => 'fa-solid fa-heart-pulse',   'label' => 'Healthcare' ],
        [ 'icon' => 'fa-solid fa-landmark',       'label' => 'Financial Services' ],
        [ 'icon' => 'fa-solid fa-graduation-cap', 'label' => 'Education' ],
        [ 'icon' => 'fa-solid fa-industry',       'label' => 'Manufacturing' ],
        [ 'icon' => 'fa-solid fa-cart-shopping',  'label' => 'Retail & E-commerce' ],
        [ 'icon' => 'fa-solid fa-building-columns','label' => 'Government' ],
        [ 'icon' => 'fa-solid fa-tower-broadcast', 'label' => 'Telecommunications' ],
        [ 'icon' => 'fa-solid fa-hands-holding-circle','label' => 'NGOs' ],
    ];
}

// ─────────────────────────────────────────────
// BODY CLASSES
// ─────────────────────────────────────────────
function tgs_body_classes( array $classes ): array {
    if ( is_singular() && ! is_front_page() ) $classes[] = 'tgs-singular';
    if ( is_front_page() ) $classes[] = 'tgs-home';
    return $classes;
}
add_filter( 'body_class', 'tgs_body_classes' );

// ─────────────────────────────────────────────
// EXCERPT LENGTH
// ─────────────────────────────────────────────
function tgs_excerpt_length(): int { return 20; }
add_filter( 'excerpt_length', 'tgs_excerpt_length' );

function tgs_excerpt_more(): string { return '&hellip;'; }
add_filter( 'excerpt_more', 'tgs_excerpt_more' );

// ─────────────────────────────────────────────
// REMOVE EMOJI SCRIPTS (performance)
// ─────────────────────────────────────────────
remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles',     'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles',  'print_emoji_styles' );

// ─────────────────────────────────────────────
// CONTACT FORM (simple AJAX handler — use WPForms/CF7 for production)
// ─────────────────────────────────────────────
function tgs_handle_contact() {
    check_ajax_referer( 'tgs_nonce', 'nonce' );
    $name    = sanitize_text_field( $_POST['name']    ?? '' );
    $email   = sanitize_email(      $_POST['email']   ?? '' );
    $message = sanitize_textarea_field( $_POST['message'] ?? '' );

    if ( ! $name || ! is_email( $email ) || ! $message ) {
        wp_send_json_error( [ 'message' => __( 'Please fill in all required fields.', 'tgs-theme' ) ] );
    }

    $to      = get_option( 'admin_email' );
    $subject = sprintf( __( 'New enquiry from %s', 'tgs-theme' ), $name );
    $body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = [ "Reply-To: $name <$email>" ];

    $sent = wp_mail( $to, $subject, $body, $headers );
    if ( $sent ) {
        wp_send_json_success( [ 'message' => __( 'Thank you! We will be in touch soon.', 'tgs-theme' ) ] );
    } else {
        wp_send_json_error( [ 'message' => __( 'Message could not be sent. Please try again.', 'tgs-theme' ) ] );
    }
}
add_action( 'wp_ajax_tgs_contact',        'tgs_handle_contact' );
add_action( 'wp_ajax_nopriv_tgs_contact', 'tgs_handle_contact' );
