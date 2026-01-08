<?php
/**
 * The main template file
 *
 * @package SNE_Tema
 * @since 1.0.0
 */

get_header();
?>

<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 <?php echo is_active_sidebar('sidebar-blog') ? 'lg:grid-cols-3' : ''; ?> gap-8">
        
        <div class="<?php echo is_active_sidebar('sidebar-blog') ? 'lg:col-span-2' : ''; ?>">
            
            <div class="mb-8 w-full overflow-hidden">
                <div class="w-full sm:max-w-md mx-auto lg:mx-0">
                    <?php get_search_form(); ?>
                </div>
            </div>
            
            <?php if (have_posts()) : ?>
                <header class="page-header mb-8">
                    <?php if (is_home() && !is_front_page()) : ?>
                        <h1 class="page-title text-4xl font-bold text-color-2">
                            <?php single_post_title(); ?>
                        </h1>
                    <?php else : ?>
                        <h1 class="page-title text-4xl font-bold text-color-2">
                            <?php esc_html_e('Artigos', 'sne-tema'); ?>
                        </h1>
                    <?php endif; ?>
                </header>

                <div class="posts-grid grid gap-8">
                    <?php
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card bg-color-1 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow'); ?>>
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('sne-featured', array('class' => 'w-full h-64 object-cover')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="post-content p-6">
                                <header class="entry-header mb-4">
                                    <div class="entry-meta text-sm text-color-2 mb-2">
                                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo esc_html(get_the_date()); ?>
                                        </time>
                                        <?php if (has_category()) : ?>
                                            <span class="separator mx-2">•</span>
                                            <?php the_category(', '); ?>
                                        <?php endif; ?>
                                    </div>

                                    <?php
                                    the_title('<h2 class="entry-title text-2xl font-bold mb-3"><a href="' . esc_url(get_permalink()) . '" class="text-color-2 hover:text-color-3">', '</a></h2>');
                                    ?>
                                </header>

                                <div class="entry-summary text-color-2 mb-4">
                                    <?php the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="read-more inline-flex items-center text-color-2 hover:text-color-3 font-medium">
                                    <?php esc_html_e('Leia mais', 'sne-tema'); ?>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div>

                <?php
                // Paginação
                the_posts_pagination(array(
                    'mid_size'           => 2,
                    'prev_text'          => __('&laquo; Anterior', 'sne-tema'),
                    'next_text'          => __('Próximo &raquo;', 'sne-tema'),
                    'class'              => 'pagination mt-12',
                    'screen_reader_text' => __('Navegação de posts', 'sne-tema'),
                ));
                ?>

            <?php else : ?>

                <div class="no-results bg-color-1 rounded-lg shadow-md p-8 text-center">
                    <h1 class="text-3xl font-bold text-color-2 mb-4">
                        <?php esc_html_e('Nenhum conteúdo encontrado', 'sne-tema'); ?>
                    </h1>
                    <p class="text-gray-600 mb-6">
                        <?php esc_html_e('Desculpe, não foi possível encontrar o que você está procurando.', 'sne-tema'); ?>
                    </p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
                        <?php esc_html_e('Voltar para Home', 'sne-tema'); ?>
                    </a>
                </div>

            <?php endif; ?>

        </div>

        <?php if (is_active_sidebar('sidebar-blog')) : ?>
            <aside id="secondary" class="widget-area">
                <?php dynamic_sidebar('sidebar-blog'); ?>
            </aside>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
