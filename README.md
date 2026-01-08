# SNE Tema - WordPress Acelerado

Tema WordPress pré-configurado com Vite e Tailwind CSS para desenvolvimento rápido de sites institucionais, portfólios e blogs.

Este tema é distribuído gratuitamente sob licença GPL.
Caso precise de desenvolvimento personalizado, novas funcionalidades, performance, SEO ou suporte profissional, entre em contato: contato@seunegocioeficiente.com

## 🚀 Características

- ⚡ **Vite** - Build tool moderno e rápido
- 🎨 **Tailwind CSS** - Framework CSS utility-first
- 🎯 **Sistema de Cores Personalizável** - Gestão fácil via arquivo
- 📱 **Responsivo** - Mobile-first design
- 🔧 **Header Fixo** - Com suporte a logo customizada
- 📝 **Blog Completo** - Templates prontos para posts e arquivos
- 🎨 **Customizer** - Configurações fáceis pelo painel WordPress
- ♿ **Acessível** - HTML5 semântico e ARIA labels

## 📦 Instalação

### 1. Instalar o tema

Copie a pasta `SNE-Tema` para o diretório de temas do WordPress:
```
wp-content/themes/
```

### 2. Instalar dependências

No diretório do tema, execute:

```bash
npm install
```

## 🛠️ Desenvolvimento

### Pré-requisitos

**IMPORTANTE:** Para usar o modo de desenvolvimento com Vite, você DEVE ativar o debug no WordPress:

1. Abra o arquivo `wp-config.php` na raiz do WordPress
2. Localize a linha: `define( 'WP_DEBUG', false );`
3. Altere para: `define( 'WP_DEBUG', true );`

### Iniciar servidor de desenvolvimento

```bash
npm run dev
```

O Vite iniciará um servidor de desenvolvimento em `http://localhost:3000` com Hot Module Replacement (HMR).

**Funcionalidades:**
- ✅ Recarregamento automático ao editar arquivos PHP
- ✅ HMR instantâneo para arquivos CSS e JavaScript
- ✅ Detecção de mudanças otimizada (50ms)

### Build para produção

```bash
npm run build
```

Os arquivos compilados serão gerados em `assets/dist/`.

**Lembre-se:** Ao fazer deploy, defina `WP_DEBUG` como `false` no servidor de produção.

## 📁 Estrutura do Projeto

```
SNE-Tema/
├── assets/
│   ├── src/
│   │   ├── main.css        (CSS com Tailwind v4)
│   │   └── main.js         (JavaScript principal)
│   └── dist/               (gerado após build)
├── 404.php
├── archive.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── single.php
├── style.css
├── package.json
├── postcss.config.js
└── vite.config.js
```

## 🎨 Tailwind CSS v4

O tema usa **Tailwind CSS v4** com a nova sintaxe simplificada.

### Personalização

Para personalizar o Tailwind, edite o arquivo [assets/src/main.css](assets/src/main.css):

```css
@import "tailwindcss";

/* Adicione suas customizações aqui */
@theme {
  --color-primary: #3B82F6;
}
```

### Usar classes Tailwind

```html
<div class="bg-blue-500 text-white p-4 rounded-lg">
  Conteúdo
</div>
```

## 📋 Configurações do Tema

### Logo

1. Acesse **Aparência > Personalizar > Identidade do Site**
2. Clique em **Selecionar Logo**
3. Faça upload da sua logo

### Menus

O tema suporta 2 menus:

- **Menu Principal** - Exibido no header
- **Menu Rodapé** - Exibido no footer

Configure em **Aparência > Menus**

### Widgets

Áreas de widgets disponíveis:

- **Sidebar Blog** - Lateral do blog
- **Footer Coluna 1, 2 e 3** - Três colunas no rodapé

Configure em **Aparência > Widgets**

- Para desabilitar o seach padrão do wordpress vá em Aparência > Widgets e exclua o campo que aparece para
adicionar texto ao campo de pesquisa, clicando nos ... e depois em excluir.

## 🔧 Personalização

### Adicionar JavaScript personalizado

Edite [assets/src/main.js](assets/src/main.js) para adicionar funcionalidades JavaScript.

### Modificar estilos CSS

Edite [assets/src/main.css](assets/src/main.css) para adicionar estilos personalizados.

## 📝 Templates Disponíveis

- **index.php** - Lista de posts (blog)
- **single.php** - Post individual
- **page.php** - Página estática
- **archive.php** - Arquivo de categoria/tag
- **404.php** - Página não encontrada

## 🚀 Deploy

1. Execute o build de produção:
```bash
npm run build
```

2. Faça upload da pasta do tema para o servidor

3. Ative o tema no painel WordPress

**Nota:** Não é necessário fazer upload da pasta `node_modules` ou dos arquivos de configuração do npm.

## 🛠️ Requisitos

- WordPress 6.0+
- PHP 7.4+
- Node.js 16+
- npm ou yarn

## 📄 Licença

Este tema está licenciado sob a GPL v2 ou posterior.

## 🤝 Suporte

Para dúvidas e suporte, entre em contato através do site: https://seunegocioeficiente.com

## 🔄 Atualizações

Mantenha o tema sempre atualizado para receber novos recursos e correções de segurança.

---

Desenvolvido com ❤️ por SNE
