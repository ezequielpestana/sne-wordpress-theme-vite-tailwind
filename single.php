<?php
/**
 * The template for displaying all single posts
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
            
            <?php
            while (have_posts()) :
                the_post();
                ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post bg-color-1 rounded-lg shadow-md overflow-hidden'); ?> itemscope itemtype="https://schema.org/BlogPosting">
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail mb-8" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                            <?php 
                            $thumbnail_id = get_post_thumbnail_id();
                            $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'full');
                            $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                            ?>
                            <?php the_post_thumbnail('full', array('class' => 'w-full h-auto', 'itemprop' => 'url')); ?>
                            <meta itemprop="url" content="<?php echo esc_url($thumbnail_url); ?>">
                            <meta itemprop="width" content="<?php echo esc_attr(wp_get_attachment_metadata($thumbnail_id)['width']); ?>">
                            <meta itemprop="height" content="<?php echo esc_attr(wp_get_attachment_metadata($thumbnail_id)['height']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="post-content p-8">
                        <header class="entry-header mb-6">
                            <div class="entry-meta text-sm text-color-2 mb-3">
                                <time class="published" datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished">
                                    <?php echo esc_html(get_the_date()); ?>
                                </time>
                                <meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                                <span class="separator mx-2">•</span>
                                <span class="author vcard" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                    <?php esc_html_e('Por', 'sne-tema'); ?> <span itemprop="name"><?php the_author(); ?></span>
                                </span>
                            </div>

                            <?php the_title('<h1 class="entry-title mt-3 text-4xl font-bold text-color-2 mb-4" itemprop="headline">', '</h1>'); ?>
                            
                            <!-- Schema.org metadata oculto -->
                            <meta itemprop="mainEntityOfPage" content="<?php the_permalink(); ?>">
                            <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" style="display:none;">
                                <meta itemprop="name" content="<?php bloginfo('name'); ?>">
                                <?php if (has_custom_logo()) : ?>
                                    <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                                        <meta itemprop="url" content="<?php echo esc_url(wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full')); ?>">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </header>

                        <div class="entry-content" itemprop="articleBody">
                            <?php
                            the_content();

                            wp_link_pages(array(
                                'before' => '<div class="page-links mt-6">' . esc_html__('Páginas:', 'sne-tema'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <?php if (has_tag()) : ?>
                            <footer class="entry-footer mt-8 pt-6 border-t border-gray-200">
                                <div class="tags-links">
                                    <?php the_tags('<span class="font-medium text-color-2">' . esc_html__('Tags:', 'sne-tema') . '</span> ', ', ', ''); ?>
                                </div>
                            </footer>
                        <?php endif; ?>
                    </div>

                </article>

                <?php
                // Navegação entre posts personalizada
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                
                if ($prev_post || $next_post) :
                ?>
                    <nav class="post-navigation mt-8 w-full">
                        <div class="flex flex-col sm:flex-row w-full gap-4">
                            <?php if ($prev_post) : ?>
                                <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="flex-1 bg-color-1 hover:bg-color-4 hover:text-white transition-colors rounded-lg shadow-md p-6 flex flex-col justify-center">
                                    <span class="text-sm font-semibold text-color-3 mb-2">
                                        <?php esc_html_e('← Anterior', 'sne-tema'); ?>
                                    </span>
                                    <span class="text-lg font-bold text-color-2">
                                        <?php echo esc_html(get_the_title($prev_post)); ?>
                                    </span>
                                </a>
                            <?php else : ?>
                                <div class="flex-1"></div>
                            <?php endif; ?>
                            
                            <?php if ($next_post) : ?>
                                <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="flex-1 bg-color-1 hover:bg-color-4 hover:text-white transition-colors rounded-lg shadow-md p-6 flex flex-col justify-center text-right">
                                    <span class="text-sm font-semibold text-color-3 mb-2">
                                        <?php esc_html_e('Próximo →', 'sne-tema'); ?>
                                    </span>
                                    <span class="text-lg font-bold text-color-2">
                                        <?php echo esc_html(get_the_title($next_post)); ?>
                                    </span>
                                </a>
                            <?php else : ?>
                                <div class="flex-1"></div>
                            <?php endif; ?>
                        </div>
                    </nav>
                <?php endif; ?>

                <?php
                // Comentários
                if (comments_open() || get_comments_number()) :
                    ?>
                    <div class="comments-area mt-8 bg-color-1 rounded-lg shadow-md p-8">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>

            <?php endwhile; ?>

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
