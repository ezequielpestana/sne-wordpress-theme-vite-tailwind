# Suporte a SEO - SNE Tema

## 📋 Visão Geral

O tema SNE agora possui suporte completo a SEO com implementação de recursos nativos e compatibilidade total com os principais plugins SEO do WordPress.

## ✅ Recursos Implementados

### 1. **Meta Tags Open Graph**
- Open Graph básico para redes sociais (Facebook, LinkedIn, etc.)
- Meta tags específicas para artigos (published_time, modified_time, section, tags)
- Twitter Cards para melhor compartilhamento no Twitter
- Imagens otimizadas para compartilhamento

**Localização:** `functions.php` - função `sne_tema_output_seo_meta_tags()`

### 2. **Link Canonical**
- Links canônicos automáticos em páginas, posts, categorias, tags e archives
- Previne conteúdo duplicado
- Melhora indexação nos motores de busca

**Localização:** `functions.php` - função `sne_tema_add_canonical()`

### 3. **Breadcrumbs (Migalhas de Pão)**
- Suporte nativo a breadcrumbs
- Compatibilidade automática com plugins SEO:
  - Yoast SEO
  - Rank Math
  - SEOPress
  - Breadcrumb NavXT
- Fallback para breadcrumb nativo do tema

**Localização:** 
- `functions.php` - funções `sne_tema_breadcrumbs()` e `sne_tema_custom_breadcrumbs()`
- `header.php` - exibição automática após o header

### 4. **Estrutura Semântica HTML5**
- Tags semânticas adequadas (`<article>`, `<time>`, `<nav>`, etc.)
- Atributos `datetime` em elementos `<time>`
- Estrutura de `author` com classes adequadas
- Meta tags de datas de publicação e modificação

**Localização:** 
- `single.php` - estrutura completa de artigo
- `archive.php` - estrutura de listagem

### 5. **Schema.org Markup (JSON-LD e Microdata)**

#### JSON-LD (Organization)
- Schema para organização no site todo
- Informações da empresa/site
- Logo da organização
- Possibilidade de adicionar perfis de redes sociais

**Localização:** `functions.php` - função `sne_tema_schema_org_json_ld()`

#### Microdata (BlogPosting)
- Schema.org markup inline com `itemscope` e `itemprop`
- Estrutura completa de artigo (BlogPosting)
- Informações de autor (Person)
- Informações de publicador (Organization)
- Imagem do post com metadados
- Datas de publicação e modificação

**Localização:**
- `single.php` - BlogPosting completo
- `archive.php` - BlogPosting na listagem

## 🔌 Plugins SEO Suportados

O tema detecta automaticamente se algum plugin SEO está ativo e desativa suas funções nativas para evitar conflitos:

### 1. **Yoast SEO** ✅
- Breadcrumbs: `yoast_breadcrumb()`
- Meta tags gerenciadas pelo plugin
- Link canonical gerenciado pelo plugin

### 2. **Rank Math** ✅
- Breadcrumbs: `rank_math_the_breadcrumbs()`
- Meta tags gerenciadas pelo plugin
- Schema.org gerenciado pelo plugin

### 3. **All in One SEO (AIOSEO)** ✅
- Meta tags gerenciadas pelo plugin
- Breadcrumbs gerenciados pelo plugin
- Schema.org gerenciado pelo plugin

### 4. **SEOPress** ✅
- Breadcrumbs: `seopress_display_breadcrumbs()`
- Meta tags gerenciadas pelo plugin
- Schema.org gerenciado pelo plugin

### 5. **The SEO Framework** ✅
- Meta tags gerenciadas pelo plugin
- Link canonical gerenciado pelo plugin
- Schema.org gerenciado pelo plugin

## 🎯 Como Funciona a Detecção de Plugins

O tema verifica a presença dos plugins usando:

```php
// Yoast SEO
function_exists('wpseo_auto_load')

// Rank Math
class_exists('RankMath')

// All in One SEO
class_exists('AIOSEO\\Plugin\\AIOSEO')

// SEOPress
class_exists('SEOPress\\Core\\Kernel')

// The SEO Framework
function_exists('the_seo_framework')
```

Quando algum plugin é detectado, as funções nativas do tema são desativadas automaticamente para aquele recurso específico.

## 📐 Estrutura de Schema.org Implementada

### Organization (Site Global)
```json
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Nome do Site",
  "url": "https://seusite.com",
  "description": "Descrição do site",
  "logo": "URL do logo"
}
```

### BlogPosting (Posts/Artigos)
```html
<article itemscope itemtype="https://schema.org/BlogPosting">
  <h1 itemprop="headline">Título</h1>
  <time itemprop="datePublished">2026-01-07</time>
  <meta itemprop="dateModified" content="2026-01-07">
  <div itemprop="author" itemscope itemtype="https://schema.org/Person">
    <span itemprop="name">Autor</span>
  </div>
  <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
    <meta itemprop="name" content="Site">
  </div>
  <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
    <meta itemprop="url" content="URL da imagem">
  </div>
  <div itemprop="articleBody">Conteúdo...</div>
</article>
```

## 📝 Notas Importantes

1. **Sem Conflitos**: O tema foi projetado para NÃO conflitar com plugins SEO
2. **Performance**: As verificações são leves e não impactam performance
3. **Padrões Web**: Segue os padrões do Schema.org e Open Graph Protocol

## 🔧 Personalização

### Adicionar Perfis de Redes Sociais ao Schema

Edite a função `sne_tema_schema_org_json_ld()` em `functions.php`:

```php
$social_profiles = array(
    'https://facebook.com/seuperfil',
    'https://twitter.com/seuperfil',
    'https://instagram.com/seuperfil',
    'https://linkedin.com/company/suaempresa',
);
```

### Personalizar Breadcrumbs

Edite a função `sne_tema_custom_breadcrumbs()` em `functions.php` para alterar:
- Separador
- Ícone home
- Estrutura HTML
- Classes CSS

## ✅ Checklist de SEO

- [x] Link Canonical
- [x] Meta Tags Open Graph
- [x] Twitter Cards
- [x] Schema.org JSON-LD (Organization)
- [x] Schema.org Microdata (BlogPosting)
- [x] Breadcrumbs
- [x] Estrutura HTML5 Semântica
- [x] Tags `<time>` com datetime
- [x] Informações de autor
- [x] Compatibilidade com plugins SEO principais
- [x] Meta tags de imagem
- [x] Article metadata (published/modified time)
- [x] Title tag otimizado
---

**Última atualização:** Janeiro 2026  
**Versão do tema:** 1.0.0
