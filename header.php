<?php
/**
 * The header for the theme
 *
 * @package SNE_Tema
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="<?php echo esc_url(SNE_TEMA_URI . '/assets/fontawesome/css/all.min.css'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site max-w-full">
    <a class="skip-link screen-reader-text sr-only" href="#primary">
        <?php esc_html_e('Pular para o conteúdo', 'sne-tema'); ?>
    </a>

    <header id="masthead" class="site-header fixed top-0 w-full z-50 transition-all duration-300 bg-color-1 shadow-md" x-data="{ menuOpen: false }">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center" style="height: <?php echo esc_attr(get_theme_mod('header_height', '80')); ?>px;">
                
                <!-- Logo -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="custom-logo-wrapper max-w-40">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title text-2xl font-bold">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-color-2 hover:text-color-3" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <?php
                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) : ?>
                            <p class="site-description text-sm text-gray-600">
                                <?php echo esc_html($description); ?>
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div><!-- .site-branding -->

                <!-- Navigation Desktop -->
                <nav id="site-navigation" class="main-navigation hidden sm:block" aria-label="<?php esc_attr_e('Menu Principal', 'sne-tema'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'flex gap-8 items-center text-color-2',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav><!-- #site-navigation -->

                <!-- Mobile Menu Button -->
                <button 
                    @click="menuOpen = !menuOpen" 
                    :aria-expanded="menuOpen" 
                    :aria-label="menuOpen ? 'Fechar menu' : 'Abrir menu'"
                    class="menu-toggle sm:hidden cursor-pointer focus:outline-none"
                >
                    <i class="fa-solid text-color-2 text-4xl transition-transform duration-300" :class="menuOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div 
            x-show="menuOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            @click.outside="menuOpen = false"
            class="menu-mobile sm:hidden bg-color-1 shadow-lg"
        >
            <div id="menu-mobile-options" class="container  mx-auto px-4 py-6">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'mobile-primary-menu',
                    'menu_class'     => 'flex flex-col gap-4',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>
            </div>
        </div>
    </header><!-- #masthead -->

    <?php 
    // Breadcrumbs - compatível com plugins SEO
    if (!is_front_page() && !is_home()) {
        sne_tema_breadcrumbs();
    }
    ?>

    <main id="primary" class="site-main" style="margin-top: <?php echo esc_attr(get_theme_mod('header_height', '80')); ?>px;">
