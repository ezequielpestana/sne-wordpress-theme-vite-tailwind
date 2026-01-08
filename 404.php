<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package SNE_Tema
 * @since 1.0.0
 */

get_header();
?>

<div class="container mx-auto px-4 py-20">
    <div class="error-404 not-found text-center max-w-2xl mx-auto">
        
        <div class="page-content bg-color-1 rounded-lg shadow-xl p-12">
            
            <!-- 404 Number -->
            <div class="error-number mb-6">
                <h1 class="text-9xl font-bold text-color-1 opacity-20">404</h1>
            </div>

            <header class="page-header mb-8">
                <h2 class="page-title text-4xl font-bold text-color-2 mb-4">
                    <?php esc_html_e('Oops! Página não encontrada', 'sne-tema'); ?>
                </h2>
                <p class="text-lg text-gray-600">
                    <?php esc_html_e('A página que você está procurando não existe ou foi movida.', 'sne-tema'); ?>
                </p>
            </header>

            <!-- Search -->
            <div class="error-search mb-8">
                <p class="text-gray-700 mb-4">
                    <?php esc_html_e('Tente fazer uma busca:', 'sne-tema'); ?>
                </p>
                <?php get_search_form(); ?>
            </div>

            <!-- Actions -->
            <div class="error-actions flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <?php esc_html_e('Voltar para Home', 'sne-tema'); ?>
                </a>
                
                <?php if (has_nav_menu('primary')) : ?>
                    <a href="#" onclick="window.history.back(); return false;" class="btn-secondary">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <?php esc_html_e('Voltar', 'sne-tema'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Recent Posts -->
            <?php
            $recent_posts = wp_get_recent_posts(array(
                'numberposts' => 3,
                'post_status' => 'publish'
            ));
            
            if (!empty($recent_posts)) :
            ?>
                <div class="recent-posts mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-2xl font-bold text-color-2 mb-6">
                        <?php esc_html_e('Posts Recentes', 'sne-tema'); ?>
                    </h3>
                    <div class="grid md:grid-cols-3 gap-4">
                        <?php foreach ($recent_posts as $post) : ?>
                            <div class="post-item">
                                <a href="<?php echo esc_url(get_permalink($post['ID'])); ?>" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <h4 class="font-medium text-color-2 mb-2">
                                        <?php echo esc_html($post['post_title']); ?>
                                    </h4>
                                    <span class="text-sm text-gray-500">
                                        <?php echo esc_html(get_the_date('', $post['ID'])); ?>
                                    </span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php
                wp_reset_postdata();
            endif;
            ?>

        </div>

    </div>
</div>

<?php
get_footer();
