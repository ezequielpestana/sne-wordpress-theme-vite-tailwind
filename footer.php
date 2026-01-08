<?php

/**
 * The template for displaying the footer
 *
 * @package SNE_Tema
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

</main><!-- #primary -->

<footer id="colophon" class="site-footer bg-color-2 text-color-1 py-12">
    <div class="container mx-auto px-4">

        <!-- Footer Navigation -->
        <?php if (has_nav_menu('footer')) : ?>
            <div class="footer-navigation mb-6 pb-6 border-b border-gray-700">
                <nav aria-label="<?php esc_attr_e('Menu do Rodapé', 'sne-tema'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'flex flex-wrap justify-center gap-6 text-sm',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                    ?>
                </nav>
            </div>
        <?php endif; ?>

        <!-- Copyright -->
        <div class="site-info text-center text-sm text-color-1">
            <?php
            $copyright = get_theme_mod('footer_copyright', sprintf(__('© %d - Todos os direitos reservados.', 'sne-tema'), date('Y')));
            echo wp_kses_post($copyright);
            ?>
            <p>Nome da Empresa - CNPJ: 00.000.00/0001-00</p>
            <a href="mailto:contato@seunegocioeficiente.com">contato@nomedaempresa.com</a>

        </div><!-- .site-info -->
    </div>
</footer><!-- #colophon -->

<div id="cookie-banner" class="hidden fixed bottom-0 left-0 right-0 w-full p-4 z-[9999] shadow-2xl bg-color-2">
    <div class="container max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="text-color-1 m-0 text-sm md:text-base">
            Nosso site utiliza cookies para melhorar a experiência do usuário. 
            <a href="<?php echo get_site_url() . '/politica-de-privacidade'; ?>" class="text-color-5 underline hover:opacity-80 transition-opacity">
                Saiba mais
            </a>
        </p>
        <button id="accept-cookies" class="bg-color-5 hover:bg-color-5/90 text-color-1 px-6 py-2.5 rounded-lg border-0 cursor-pointer transition-all font-semibold whitespace-nowrap">
            Aceitar Cookies
        </button>
    </div>
</div>


</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>