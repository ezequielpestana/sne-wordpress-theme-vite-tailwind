<?php
/**
 * Template para exibição de comentários
 *
 * @package SNE_Tema
 */

// Proteção: sair se acessado diretamente
if (!defined('ABSPATH')) {
    exit;
}

// Se o post está protegido por senha e o usuário não inseriu a senha, retornar
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area md:py-12">
    
    <?php if (have_comments()) : ?>
        <h2 class="comments-title text-2xl md:text-3xl font-bold mb-6 text-color-neutral-900">
            <?php
            $comments_number = get_comments_number();
            if ('1' === $comments_number) {
                printf(esc_html__('1 comentário', 'sne-tema'));
            } else {
                printf(
                    esc_html(_n('%s comentário', '%s comentários', $comments_number, 'sne-tema')),
                    number_format_i18n($comments_number)
                );
            }
            ?>
        </h2>

        <ol class="comment-list space-y-6">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
                'callback'    => function($comment, $args, $depth) {
                    ?>
                    <li id="comment-<?php comment_ID(); ?>" <?php comment_class('comment bg-color-1 rounded-lg p-4 md:p-6'); ?>>
                        <article class="comment-body">
                            <footer class="comment-meta flex items-start gap-4 mb-4">
                                <div class="comment-author-avatar flex-shrink-0">
                                    <?php echo get_avatar($comment, 50, '', '', array('class' => 'rounded-full')); ?>
                                </div>
                                <div class="flex-1">
                                    <div class="comment-metadata text-sm text-color-neutral-600 mb-1">
                                        <cite class="fn font-semibold text-color-neutral-900">
                                            <?php comment_author_link(); ?>
                                        </cite>
                                        <span class="mx-2">•</span>
                                        <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>" class="hover:text-color-2">
                                            <time datetime="<?php comment_time('c'); ?>">
                                                <?php printf(esc_html__('%s atrás', 'sne-tema'), human_time_diff(get_comment_time('U'), current_time('timestamp'))); ?>
                                            </time>
                                        </a>
                                    </div>
                                    <?php if ('0' == $comment->comment_approved) : ?>
                                        <p class="comment-awaiting-moderation text-sm text-yellow-600 bg-yellow-50 px-3 py-2 rounded mb-2">
                                            <?php esc_html_e('Seu comentário está aguardando moderação.', 'sne-tema'); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </footer>
                            
                            <div class="comment-content prose prose-sm max-w-none text-color-neutral-700">
                                <?php comment_text(); ?>
                            </div>

                            <div class="reply mt-3">
                                <?php
                                comment_reply_link(array_merge($args, array(
                                    'depth'     => $depth,
                                    'max_depth' => $args['max_depth'],
                                    'reply_text' => '<span class="text-sm text-color-2 hover:text-color-3 font-medium">Responder</span>'
                                )));
                                ?>
                            </div>
                        </article>
                    </li>
                    <?php
                }
            ));
            ?>
        </ol>

        <?php
        // Paginação de comentários
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        ?>
            <nav class="comment-navigation mt-8" role="navigation">
                <div class="nav-links flex justify-between">
                    <div class="nav-previous">
                        <?php previous_comments_link('<span class="text-color-2 hover:text-color-3">&larr; Comentários anteriores</span>'); ?>
                    </div>
                    <div class="nav-next">
                        <?php next_comments_link('<span class="text-color-2 hover:text-color-3">Próximos comentários &rarr;</span>'); ?>
                    </div>
                </div>
            </nav>
        <?php endif; ?>

    <?php endif; // have_comments() ?>

    <?php
    // Se os comentários estão fechados e existem comentários, mostrar mensagem
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
    ?>
        <p class="no-comments text-color-neutral-600 bg-color-1 p-4 rounded-lg">
            <?php esc_html_e('Os comentários estão fechados.', 'sne-tema'); ?>
        </p>
    <?php endif; ?>

    <?php
    // Formulário de comentários
    if (comments_open()) :
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ($req ? " aria-required='true' required" : '');
        $consent = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';
        
        // Mensagem personalizada para usuário logado
        $user = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';
        $logged_in_message = sprintf(
            esc_html__('Conectado como %1$s. %2$sEditar perfil%3$s. %4$sSair%5$s?', 'sne-tema'),
            '<strong>' . $user_identity . '</strong>',
            '<a href="' . esc_url(get_edit_user_link()) . '" class="underline hover:text-color-2">',
            '</a>',
            '<a href="' . esc_url(wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '" class="underline hover:text-color-2">',
            '</a>'
        );
        
        comment_form(array(
            'title_reply'          => '<span class="text-2xl md:text-3xl font-bold text-color-2 block text-center">Deixe um comentário sobre esse artigo</span>',
            'title_reply_to'       => '<span class="text-2xl md:text-3xl font-bold text-color-2">Responder para %s</span>',
            'cancel_reply_link'    => 'Cancelar resposta',
            'label_submit'         => 'Enviar comentário',
            'comment_field'        => '<p class="comment-form-comment mb-4 flex flex-col items-center">
                <label for="comment" class="block text-sm font-medium text-color-2 mb-2 w-full max-w-md text-left">' . esc_html__('Comentário', 'sne-tema') . ' <span class="required text-red-500">*</span></label>
                <textarea id="comment" name="comment" rows="6" aria-required="true" required class="w-full max-w-md px-4 py-3 border border-color-3 rounded-lg focus:ring-2 focus:ring-color-3 focus:border-color-2 resize-none"></textarea>
            </p>',
            'fields'               => array(
                'author' => '<p class="comment-form-author mb-4 flex flex-col items-center">
                    <label for="author" class="block text-sm font-medium text-color-2 mb-2 w-full max-w-md text-left">' . esc_html__('Nome', 'sne-tema') . ($req ? ' <span class="required text-red-500">*</span>' : '') . '</label>
                    <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" class="w-full max-w-md px-4 py-3 border border-color-3 rounded-lg focus:ring-2 focus:ring-color-3 focus:border-color-2"' . $aria_req . ' />
                </p>',
                'email'  => '<p class="comment-form-email mb-4 flex flex-col items-center">
                    <label for="email" class="block text-sm font-medium text-color-2 mb-2 w-full max-w-md text-left">' . esc_html__('Email', 'sne-tema') . ($req ? ' <span class="required text-red-500">*</span>' : '') . '</label>
                    <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" class="w-full max-w-md px-4 py-3 border border-color-3 rounded-lg focus:ring-2 focus:ring-color-3 focus:border-color-2"' . $aria_req . ' />
                </p>',
                'url'    => '<p class="comment-form-url mb-4 flex flex-col items-center">
                    <label for="url" class="block text-sm font-medium text-color-2 mb-2 w-full max-w-md text-left">' . esc_html__('Site', 'sne-tema') . '</label>
                    <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" class="w-full max-w-md px-4 py-3 border border-color-3 rounded-lg focus:ring-2 focus:ring-color-3 focus:border-color-2" />
                </p>',
                'cookies' => '<p class="comment-form-cookies-consent mb-4 flex justify-center items-center gap-2 max-w-md mx-auto px-1">
                    <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />
                    <label for="wp-comment-cookies-consent" class="text-sm text-color-2">' . esc_html__('Salvar meus dados neste navegador para a próxima vez que eu comentar.', 'sne-tema') . '</label>
                </p>',
            ),
            'submit_button'        => '<div class="flex justify-center"><button type="submit" id="submit" class="bg-color-2 cursor-pointer mt-5 hover:bg-color-3 text-white font-semibold px-6 py-6 rounded-lg transition-colors duration-200">%4$s</button></div>',
            'class_form'           => 'comment-form mt-8 bg-color-1 md:p-8 rounded-lg text-center',
            'class_submit'         => '',
            'logged_in_as'         => '<p class="logged-in-as text-sm text-color-2 mb-4 max-w-md mx-auto px-1">' . $logged_in_message . '</p>',
            'comment_notes_before' => '<p class="comment-notes text-sm text-color-2 mb-4 max-w-md mx-auto px-1">' . esc_html__('Seu endereço de email não será publicado. Campos obrigatórios são marcados com *', 'sne-tema') . '</p>',
            'comment_notes_after'  => '',
        ));
    endif;
    ?>

</div>
