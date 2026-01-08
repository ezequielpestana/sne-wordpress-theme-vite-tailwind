<?php
/**
 * The template for displaying all pages
 *
 * @package SNE_Tema
 * @since 1.0.0
 */

get_header();
?>

<div class="container mx-auto px-4 py-12">
    
    <?php
    while (have_posts()) :
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('page-content bg-color-1 rounded-lg shadow-md p-8'); ?>>
            
            <header class="entry-header mb-8">
                <?php the_title('<h1 class="entry-title text-4xl font-bold text-color-2">', '</h1>'); ?>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail mb-8">
                    <?php the_post_thumbnail('full', array('class' => 'w-full h-auto rounded-lg')); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content prose max-w-none">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links mt-6">' . esc_html__('Páginas:', 'sne-tema'),
                    'after'  => '</div>',
                ));
                ?>
            </div>

        </article>

        <?php
        // Comentários se habilitados
        if (comments_open() || get_comments_number()) :
            ?>
            <div class="comments-area mt-8 bg-color-1 rounded-lg shadow-md p-8">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>

    <?php endwhile; ?>

</div>

<?php
get_footer();
