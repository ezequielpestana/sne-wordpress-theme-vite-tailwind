<?php
/**
 * SNE Tema - Functions and definitions
 *
 * @package SNE_Tema
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define constantes do tema
define('SNE_TEMA_VERSION', '1.0.0');
define('SNE_TEMA_DIR', get_template_directory());
define('SNE_TEMA_URI', get_template_directory_uri());

/**
 * Configuração do tema
 */
function sne_tema_setup() {
    // Suporte a tradução
    load_theme_textdomain('sne-tema', SNE_TEMA_DIR . '/languages');
    
    // Adicionar suporte a title tag
    add_theme_support('title-tag');
    
    // Adicionar suporte a imagens destacadas
    add_theme_support('post-thumbnails');
    
    // Adicionar suporte a logo customizada
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Adicionar suporte a HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // Adicionar suporte a feeds automáticos
    add_theme_support('automatic-feed-links');
    
    // Adicionar suporte a refresh seletivo no customizer
    add_theme_support('customize-selective-refresh-widgets');
    
    // Adicionar suporte a estilos de blocos
    add_theme_support('wp-block-styles');
    
    // Adicionar suporte a editor de largura
    add_theme_support('align-wide');
    
    // Adicionar suporte a estilos do editor
    add_theme_support('editor-styles');
    
    // Registrar menus de navegação
    register_nav_menus(array(
        'primary' => esc_html__('Menu Principal', 'sne-tema'),
        'footer'  => esc_html__('Menu Rodapé', 'sne-tema'),
    ));
    
    // Tamanhos de imagens personalizados
    add_image_size('sne-featured', 1200, 675, true);
    add_image_size('sne-thumbnail', 400, 300, true);
}
add_action('after_setup_theme', 'sne_tema_setup');

/**
 * Registrar áreas de widgets
 */
function sne_tema_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar Artigos', 'sne-tema'),
        'id'            => 'sidebar-blog',
        'description'   => esc_html__('Área de widgets para artigos', 'sne-tema'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-8">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4 text-color-2">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'sne_tema_widgets_init');

/**
 * Carregar assets do Vite no head
 */
function sne_tema_vite_head() {
    $is_development = defined('WP_DEBUG') && WP_DEBUG && file_exists(SNE_TEMA_DIR . '/assets/src/main.js');
    
    if ($is_development) {
        echo '<script type="module" src="http://localhost:3000/@vite/client"></script>' . "\n";
        echo '<script type="module" src="http://localhost:3000/assets/src/main.js"></script>' . "\n";
    }
}
add_action('wp_head', 'sne_tema_vite_head', 0);

/**
 * Carregar assets do Vite
 */
function sne_tema_enqueue_scripts() {

    

    // Verificar se estamos em modo de desenvolvimento
    $is_development = defined('WP_DEBUG') && WP_DEBUG && file_exists(SNE_TEMA_DIR . '/assets/src/main.js');
    
    if (!$is_development) {
        // Modo de produção - carregar assets compilados
        $manifest_path = SNE_TEMA_DIR . '/assets/dist/.vite/manifest.json';
        
        if (file_exists($manifest_path)) {
            $manifest = json_decode(file_get_contents($manifest_path), true);
            
            if (isset($manifest['assets/src/main.js'])) {
                $main_js = $manifest['assets/src/main.js'];
                
                // Enfileirar CSS
                if (isset($main_js['css'])) {
                    foreach ($main_js['css'] as $css_file) {
                        wp_enqueue_style(
                            'sne-tema-main',
                            SNE_TEMA_URI . '/assets/dist/' . $css_file,
                            array(),
                            SNE_TEMA_VERSION
                        );
                    }
                }
                
                // Enfileirar JavaScript
                wp_enqueue_script(
                    'sne-tema-main',
                    SNE_TEMA_URI . '/assets/dist/' . $main_js['file'],
                    array(),
                    SNE_TEMA_VERSION,
                    true
                );
                
                // Adicionar atributo type="module"
                add_filter('script_loader_tag', function($tag, $handle) {
                    if ($handle === 'sne-tema-main') {
                        $tag = str_replace('<script ', '<script type="module" ', $tag);
                    }
                    return $tag;
                }, 10, 2);
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'sne_tema_enqueue_scripts');

/**
 * Configurar tamanho do excerpt
 */
function sne_tema_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'sne_tema_excerpt_length');

/**
 * Modificar o "mais" do excerpt
 */
function sne_tema_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'sne_tema_excerpt_more');

/**
 * Desabilitar widget de pesquisa padrão do WordPress
 */
function sne_tema_unregister_search_widget() {
    unregister_widget('WP_Widget_Search');
}
add_action('widgets_init', 'sne_tema_unregister_search_widget', 11);

/**
 * Processar formulário de contato via AJAX
 */
function sne_tema_send_contact_form() {
    // Verificar nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'contact_form_nonce')) {
        wp_send_json_error('Erro de segurança. Recarregue a página e tente novamente.');
        return;
    }

    // Validar campos obrigatórios
    $nome = isset($_POST['nome']) ? sanitize_text_field($_POST['nome']) : '';
    $whatsapp = isset($_POST['whatsapp']) ? sanitize_text_field($_POST['whatsapp']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $tipo_projeto = isset($_POST['tipo_projeto']) ? sanitize_text_field($_POST['tipo_projeto']) : '';
    $mensagem = isset($_POST['mensagem']) ? sanitize_textarea_field($_POST['mensagem']) : '';

    // Validações
    if (empty($nome) || empty($whatsapp) || empty($email) || empty($tipo_projeto) || empty($mensagem)) {
        wp_send_json_error('Por favor, preencha todos os campos obrigatórios.');
        return;
    }

    if (!is_email($email)) {
        wp_send_json_error('Por favor, insira um e-mail válido.');
        return;
    }

    // Preparar o e-mail
    $to = get_option('admin_email'); // Email do admin do WordPress
    $subject = 'Novo Contato - ' . $tipo_projeto;
    
    $message = "Nova mensagem de contato recebida:\n\n";
    $message .= "Nome: " . $nome . "\n";
    $message .= "WhatsApp: " . $whatsapp . "\n";
    $message .= "E-mail: " . $email . "\n";
    $message .= "Tipo de Projeto: " . $tipo_projeto . "\n\n";
    $message .= "Mensagem:\n" . $mensagem . "\n\n";
    $message .= "---\n";
    $message .= "Enviado em: " . date('d/m/Y H:i:s') . "\n";
    $message .= "Site: " . get_bloginfo('name');

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . $email . '>',
        'Reply-To: ' . $email
    );

    // Enviar e-mail
    $sent = wp_mail($to, $subject, $message, $headers);

    if ($sent) {
        // Opcional: Salvar no banco de dados
        $contact_data = array(
            'post_title'   => $nome . ' - ' . $tipo_projeto,
            'post_content' => $mensagem,
            'post_status'  => 'private',
            'post_type'    => 'contact_form',
            'meta_input'   => array(
                'nome' => $nome,
                'whatsapp' => $whatsapp,
                'email' => $email,
                'tipo_projeto' => $tipo_projeto,
            )
        );
        
        // Descomentar para salvar no banco de dados (precisa registrar o post type primeiro)
        // wp_insert_post($contact_data);

        wp_send_json_success('Mensagem enviada com sucesso!');
    } else {
        wp_send_json_error('Erro ao enviar mensagem. Por favor, tente novamente ou entre em contato via WhatsApp.');
    }
}
add_action('wp_ajax_send_contact_form', 'sne_tema_send_contact_form');
add_action('wp_ajax_nopriv_send_contact_form', 'sne_tema_send_contact_form');

/**
 * ========================================
 * FUNÇÕES DE SEO E META TAGS
 * ========================================
 */

/**
 * Adicionar link canonical
 */
function sne_tema_add_canonical() {
    // Verificar se algum plugin SEO já está adicionando canonical
    if (function_exists('wpseo_auto_load') || // Yoast SEO
        class_exists('RankMath') || // Rank Math
        class_exists('AIOSEO\\Plugin\\AIOSEO') || // All in One SEO
        class_exists('SEOPress\\Core\\Kernel') || // SEOPress
        function_exists('the_seo_framework')) { // The SEO Framework
        return;
    }
    
    if (is_singular()) {
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '" />' . "\n";
    } elseif (is_front_page()) {
        echo '<link rel="canonical" href="' . esc_url(home_url('/')) . '" />' . "\n";
    } elseif (is_category()) {
        echo '<link rel="canonical" href="' . esc_url(get_category_link(get_queried_object_id())) . '" />' . "\n";
    } elseif (is_tag()) {
        echo '<link rel="canonical" href="' . esc_url(get_tag_link(get_queried_object_id())) . '" />' . "\n";
    } elseif (is_archive()) {
        echo '<link rel="canonical" href="' . esc_url(get_post_type_archive_link(get_post_type())) . '" />' . "\n";
    }
}
add_action('wp_head', 'sne_tema_add_canonical', 1);

/**
 * Adicionar meta tags Open Graph e Twitter Cards
 */
function sne_tema_output_seo_meta_tags() {
    // Verificar se algum plugin SEO já está ativo
    if (function_exists('wpseo_auto_load') || // Yoast SEO
        class_exists('RankMath') || // Rank Math
        class_exists('AIOSEO\\Plugin\\AIOSEO') || // All in One SEO
        class_exists('SEOPress\\Core\\Kernel') || // SEOPress
        function_exists('the_seo_framework')) { // The SEO Framework
        return;
    }
    
    // Open Graph Type
    $og_type = is_singular() ? 'article' : 'website';
    
    // Título
    $title = wp_get_document_title();
    
    // Descrição
    $description = '';
    if (is_singular()) {
        if (has_excerpt()) {
            $description = get_the_excerpt();
        } else {
            $description = wp_trim_words(get_the_content(), 30, '...');
        }
    } elseif (is_category() || is_tag() || is_archive()) {
        $description = get_the_archive_description();
    } else {
        $description = get_bloginfo('description');
    }
    $description = wp_strip_all_tags($description);
    
    // URL
    $url = is_singular() ? get_permalink() : home_url(add_query_arg(null, null));
    
    // Imagem
    $image = '';
    if (is_singular() && has_post_thumbnail()) {
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
    } elseif (has_custom_logo()) {
        $image = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');
    }
    
    // Site Name
    $site_name = get_bloginfo('name');
    
    // Output Meta Tags
    echo "\n<!-- Open Graph Meta Tags -->\n";
    echo '<meta property="og:locale" content="' . esc_attr(get_locale()) . '" />' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($og_type) . '" />' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '" />' . "\n";
    
    if ($image) {
        echo '<meta property="og:image" content="' . esc_url($image) . '" />' . "\n";
        echo '<meta property="og:image:secure_url" content="' . esc_url($image) . '" />' . "\n";
    }
    
    // Article specific
    if (is_singular('post')) {
        echo '<meta property="article:published_time" content="' . esc_attr(get_the_date('c')) . '" />' . "\n";
        echo '<meta property="article:modified_time" content="' . esc_attr(get_the_modified_date('c')) . '" />' . "\n";
        
        $categories = get_the_category();
        if ($categories) {
            foreach ($categories as $category) {
                echo '<meta property="article:section" content="' . esc_attr($category->name) . '" />' . "\n";
            }
        }
        
        $tags = get_the_tags();
        if ($tags) {
            foreach ($tags as $tag) {
                echo '<meta property="article:tag" content="' . esc_attr($tag->name) . '" />' . "\n";
            }
        }
    }
    
    // Twitter Cards
    echo "\n<!-- Twitter Card Meta Tags -->\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '" />' . "\n";
    
    if ($image) {
        echo '<meta name="twitter:image" content="' . esc_url($image) . '" />' . "\n";
    }
    
    echo "\n";
}
add_action('wp_head', 'sne_tema_output_seo_meta_tags', 1);

/**
 * Breadcrumbs compatível com plugins SEO
 * Exibe apenas se algum plugin SEO estiver ativo
 */
function sne_tema_breadcrumbs() {
    $breadcrumb_output = false;
    
    // Yoast SEO
    if (function_exists('yoast_breadcrumb')) {
        echo '<div class="breadcrumbs-wrapper bg-color-1 py-4 border-b border-gray-200">';
        echo '<div class="container mx-auto px-4">';
        echo '<nav class="breadcrumbs text-sm" aria-label="Breadcrumb">';
        yoast_breadcrumb('<div id="breadcrumbs" class="yoast-breadcrumbs">', '</div>');
        echo '</nav>';
        echo '</div>';
        echo '</div>';
        $breadcrumb_output = true;
    }
    // Rank Math
    elseif (function_exists('rank_math_the_breadcrumbs')) {
        echo '<div class="breadcrumbs-wrapper bg-color-1 py-4 border-b border-gray-200">';
        echo '<div class="container mx-auto px-4">';
        echo '<nav class="breadcrumbs text-sm" aria-label="Breadcrumb">';
        rank_math_the_breadcrumbs();
        echo '</nav>';
        echo '</div>';
        echo '</div>';
        $breadcrumb_output = true;
    }
    // SEOPress
    elseif (function_exists('seopress_display_breadcrumbs')) {
        echo '<div class="breadcrumbs-wrapper bg-color-1 py-4 border-b border-gray-200">';
        echo '<div class="container mx-auto px-4">';
        echo '<nav class="breadcrumbs text-sm" aria-label="Breadcrumb">';
        seopress_display_breadcrumbs();
        echo '</nav>';
        echo '</div>';
        echo '</div>';
        $breadcrumb_output = true;
    }
    // Breadcrumb NavXT
    elseif (function_exists('bcn_display')) {
        echo '<div class="breadcrumbs-wrapper bg-color-1 py-4 border-b border-gray-200">';
        echo '<div class="container mx-auto px-4">';
        echo '<nav class="breadcrumbs text-sm" aria-label="Breadcrumb">';
        bcn_display();
        echo '</nav>';
        echo '</div>';
        echo '</div>';
        $breadcrumb_output = true;
    }
    
    // Se nenhum plugin estiver ativo, não exibe breadcrumb
}

/**
 * Adicionar suporte a título SEO se nenhum plugin estiver ativo
 */
function sne_tema_document_title_parts($title) {
    // Verificar se algum plugin SEO está ativo
    if (function_exists('wpseo_auto_load') || 
        class_exists('RankMath') || 
        class_exists('AIOSEO\\Plugin\\AIOSEO') || 
        class_exists('SEOPress\\Core\\Kernel') || 
        function_exists('the_seo_framework')) {
        return $title;
    }
    
    // Melhorar título padrão
    if (is_front_page() && is_home()) {
        $title['title'] = get_bloginfo('name');
        $title['tagline'] = get_bloginfo('description');
    }
    
    return $title;
}
add_filter('document_title_parts', 'sne_tema_document_title_parts');

/**
 * Adicionar suporte a Schema.org JSON-LD para o site
 */
function sne_tema_schema_org_json_ld() {
    // Verificar se algum plugin SEO já está adicionando schema
    if (function_exists('wpseo_auto_load') || 
        class_exists('RankMath') || 
        class_exists('AIOSEO\\Plugin\\AIOSEO') || 
        class_exists('SEOPress\\Core\\Kernel') || 
        function_exists('the_seo_framework')) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'description' => get_bloginfo('description'),
    );
    
    if (has_custom_logo()) {
        $schema['logo'] = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');
    }
    
    // Social media profiles (se configurado)
    $social_profiles = array();
    // Você pode adicionar links de redes sociais aqui
    
    if (!empty($social_profiles)) {
        $schema['sameAs'] = $social_profiles;
    }
    
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n" . '</script>' . "\n";
}
add_action('wp_head', 'sne_tema_schema_org_json_ld');
