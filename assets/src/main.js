// Main JavaScript file
import './main.css';

// Importar e inicializar Alpine.js
import Alpine from 'alpinejs';

// Registrar Alpine globalmente para debug (opcional)
window.Alpine = Alpine;

// Inicializar Alpine.js
Alpine.start();

// Ajustar header e menu mobile quando admin bar estiver presente
function adjustHeaderForAdminBar() {
  const body = document.body;
  const header = document.getElementById('masthead');
  const mobileMenu = document.querySelector('.menu-mobile');
  
  if (!header) return;
  
  // Verifica se o usuário está logado (classe admin-bar presente)
  if (body.classList.contains('admin-bar')) {
    // Define altura da admin bar baseado no tamanho da tela
    const adminBarHeight = window.innerWidth > 782 ? 32 : 46;
    const headerHeight = 80; // Altura padrão do header
    
    header.style.top = `${adminBarHeight}px`;
    
    // Ajustar menu mobile para aparecer abaixo do header + admin bar
    if (mobileMenu) {
      mobileMenu.style.top = `${adminBarHeight + headerHeight}px`;
    }
  } else {
    header.style.top = '0px';
    
    // Menu mobile volta para posição normal (só abaixo do header)
    if (mobileMenu) {
      mobileMenu.style.top = '80px';
    }
  }
}

// Executar ao carregar a página
document.addEventListener('DOMContentLoaded', adjustHeaderForAdminBar);

// Ajustar também ao redimensionar a janela (para trocar entre mobile/desktop)
window.addEventListener('resize', adjustHeaderForAdminBar);

// Sistema de Cookie Consent
function initCookieBanner() {
  const banner = document.getElementById('cookie-banner');
  const acceptButton = document.getElementById('accept-cookies');
  
  if (!banner || !acceptButton) return;
  
  // Verificar se o usuário já aceitou os cookies
  const cookieAccepted = localStorage.getItem('sne_cookie_consent');
  
  if (!cookieAccepted) {
    // Mostrar banner se ainda não aceitou
    banner.classList.remove('hidden');
  }
  
  // Event listener para aceitar cookies
  acceptButton.addEventListener('click', function() {
    // Salvar no localStorage que o usuário aceitou
    localStorage.setItem('sne_cookie_consent', 'accepted');
    localStorage.setItem('sne_cookie_consent_date', new Date().toISOString());
    
    // Esconder o banner com animação suave
    banner.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
    banner.style.opacity = '0';
    banner.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
      banner.classList.add('hidden');
      banner.style.opacity = '';
      banner.style.transform = '';
    }, 300);
  });
}

// Inicializar cookie banner quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', initCookieBanner);

// Aceitar HMR para recarregamento instantâneo
if (import.meta.hot) {
  import.meta.hot.accept();
}