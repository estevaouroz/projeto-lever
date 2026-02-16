function initAccordionTeses() {
  const $headers = $('.accordion-header');
  console.log('Página inicializada...');

  if ($headers.length === 0) return;
  
  $(document).off('click', '.accordion-header');
  $(document).on('click', '.accordion-header', function handleAccordionClick() {
    const $button = $(this);
    const $item = $button.closest('.accordion-item');
    const $content = $item.find('.accordion-content');
    const isOpen = $item.hasClass('active');

    $('.accordion-item').removeClass('active');
    $('.accordion-item .accordion-content').css('max-height', '');

    if (!isOpen) {
      $item.addClass('active');
      $content.css('max-height', `${$content[0].scrollHeight}px`);
    }
  });
}

function initSideModals() {
    const triggers = document.querySelectorAll('.open-sidebar');
    const closeBtns = document.querySelectorAll('.close-modal, .modal-overlay-bg');

    triggers.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-target');
            const modal = document.getElementById(target);
            if(modal) modal.classList.add('active');
            document.body.style.overflow = 'hidden'; 
        });
    });

    closeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.side-modal').forEach(m => m.classList.remove('active'));
            document.body.style.overflow = ''; 
        });
    });
}

function initPage() {
  initAccordionTeses();
  initSideModals()
}

export {initPage};
