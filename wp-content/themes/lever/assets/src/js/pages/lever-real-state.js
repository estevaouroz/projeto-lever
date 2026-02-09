function initAccordionTeses() {
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    
    if (accordionHeaders.length === 0) return; // Segurança caso a seção não exista na página

    accordionHeaders.forEach(button => {
        button.addEventListener('click', () => {
            const accordionItem = button.parentElement;
            const content = accordionItem.querySelector('.accordion-content');
            const isOpen = accordionItem.classList.contains('active');

            // 1. Fecha os outros itens (efeito exclusivo)
            document.querySelectorAll('.accordion-item').forEach(item => {
                item.classList.remove('active');
                item.querySelector('.accordion-content').style.maxHeight = null;
            });

            // 2. Se o item clicado não estava aberto, abre ele
            if (!isOpen) {
                accordionItem.classList.add('active');
                // scrollHeight calcula a altura real do conteúdo interno
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    });
}


function initPage() {
    console.log("Página inicializada...");
    console.warn('INIT PAGE HOME');
    initAccordionTeses();
}

export {initPage};
