function initAccordionTeses() {
  const $headers = $('.accordion-header');
  console.log('Página inicializada...');

  if ($headers.length === 0) return; // Segurança caso a seção não exista na página

  $(document).off('click', '.accordion-header');
  $(document).on('click', '.accordion-header', function handleAccordionClick() {
    const $button = $(this);
    const $item = $button.closest('.accordion-item');
    const $content = $item.find('.accordion-content');
    const isOpen = $item.hasClass('active');

    // 1. Fecha os outros itens (efeito exclusivo)
    $('.accordion-item').removeClass('active');
    $('.accordion-item .accordion-content').css('max-height', '');

    // 2. Se o item clicado não estava aberto, abre ele
    if (!isOpen) {
      $item.addClass('active');
      // scrollHeight calcula a altura real do conteúdo interno
      $content.css('max-height', `${$content[0].scrollHeight}px`);
    }
  });
}

function initPage() {
  initAccordionTeses();
}

export {initPage};
