<?php
/**
 * The template for displaying archive pages
 *
 * @package SNE_Tema
 * @since 1.0.0
 */

get_header();
?>
<div class="container mx-auto px-4 py-12 ">
    <div class="grid grid-cols-1 <?php echo is_active_sidebar('sidebar-blog') ? 'lg:grid-cols-3' : ''; ?> gap-8">
        
        <div class="<?php echo is_active_sidebar('sidebar-blog') ? 'lg:col-span-2' : ''; ?>">
            
            <div class="mb-8 w-full overflow-hidden">
                <div class="w-full sm:max-w-md mx-auto lg:mx-0">
                    <?php get_search_form(); ?>
                </div>
            </div>
            
            <?php if (have_posts()) : ?>

                <header class="page-header mb-8 bg-color-1 rounded-lg shadow-md p-8">
                    <?php
                    the_archive_title('<h1 class="page-title text-4xl font-bold text-color-2 mb-2">', '</h1>');
                    the_archive_description('<div class="archive-description text-gray-600">', '</div>');
                    ?>
                </header>

                <div class="posts-grid grid gap-8">
                    <?php
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow'); ?> itemscope itemtype="https://schema.org/BlogPosting">
                            
                            <div class="grid <?php echo has_post_thumbnail() ? 'md:grid-cols-3' : ''; ?> gap-0">
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail md:col-span-1" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php 
                                            $thumbnail_id = get_post_thumbnail_id();
                                            the_post_thumbnail('sne-thumbnail', array('class' => 'w-full h-full object-cover', 'itemprop' => 'url')); 
                                            ?>
                                        </a>
                                        <meta itemprop="url" content="<?php echo esc_url(get_the_post_thumbnail_url()); ?>">
                                    </div>
                                <?php endif; ?>

                                <div class="post-content p-6 <?php echo has_post_thumbnail() ? 'md:col-span-2' : ''; ?>">
                                    <header class="entry-header mb-4">
                                        <div class="entry-meta text-sm text-gray-500 mb-2">
                                            <time class="published" datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished">
                                                <?php echo esc_html(get_the_date()); ?>
                                            </time>
                                            <meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                                            <?php if (has_category()) : ?>
                                                <span class="separator mx-2">•</span>
                                                <span itemprop="articleSection"><?php the_category(', '); ?></span>
                                            <?php endif; ?>
                                            <span style="display:none;" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                                <span itemprop="name"><?php the_author(); ?></span>
                                            </span>
                                        </div>

                                        <?php
                                        the_title('<h2 class="entry-title text-2xl font-bold mb-3" itemprop="headline"><a href="' . esc_url(get_permalink()) . '" class="text-color-2 hover:text-color-1" itemprop="url">', '</a></h2>');
                                        ?>
                                        <meta itemprop="mainEntityOfPage" content="<?php the_permalink(); ?>">
                                    </header>

                                    <div class="entry-summary text-gray-700 mb-4" itemprop="description">
                                        <?php the_excerpt(); ?>
                                    </div>

                                    <a href="<?php the_permalink(); ?>" class="read-more inline-flex items-center text-color-1 hover:text-color-3 font-medium">
                                        <?php esc_html_e('Leia mais', 'sne-tema'); ?>
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
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
                        <?php esc_html_e('Desculpe, não foi possível encontrar o que você está procurando nesta categoria.', 'sne-tema'); ?>
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
