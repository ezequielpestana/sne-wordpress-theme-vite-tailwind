<?php
/**
 * Template para o formulário de pesquisa
 *
 * @package SNE_Tema
 * @since 1.0.0
 */
?>

<form role="search" method="get" class="search-form w-full" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="flex flex-col gap-2 w-full">
        <label for="s" class="text-color-2 font-semibold text-sm">
            <?php esc_html_e('Pesquisar', 'sne-tema'); ?>
        </label>
        <div class="flex gap-2 w-full min-w-0">
            <input 
                type="search" 
                id="s" 
                name="s" 
                value="<?php echo get_search_query(); ?>" 
                placeholder="<?php esc_attr_e('Digite sua busca...', 'sne-tema'); ?>"
                class="flex-1 min-w-0 px-3 py-2 text-sm border-1 border-color-2 rounded-lg focus:outline-none focus:border-color-3"
                required
            />
            <button 
                type="submit" 
                class="px-4 sm:px-6 py-2 bg-color-2 text-white rounded-lg hover:opacity-90 transition-opacity font-medium text-sm whitespace-nowrap flex-shrink-0"
            >
                <?php esc_html_e('Buscar', 'sne-tema'); ?>
            </button>
        </div>
    </div>
</form>
