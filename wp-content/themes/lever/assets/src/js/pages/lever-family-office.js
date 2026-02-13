function initAccordionFamilyOffice() {
  const $accordion = $('#family-office .accordion');

  if (!$accordion.length) {
    return;
  }

  $accordion.find('.accordion-body').each(function setInitialState() {
    this.style.maxHeight = '0px';
  });

  $(document).off('click.familyOfficeAccordion', '#family-office .accordion-header');

  $(document).on('click.familyOfficeAccordion', '#family-office .accordion-header', function handleAccordionClick() {
    const $currentHeader = $(this);
    const $currentBody = $currentHeader.next('.accordion-body');
    const isOpen = $currentHeader.hasClass('-show');

    $accordion.find('.accordion-header').removeClass('-show');
    $accordion.find('.accordion-body').each(function closeAll() {
      this.style.maxHeight = '0px';
    });

    if (!isOpen) {
      $currentHeader.addClass('-show');
      if ($currentBody.length) {
        $currentBody[0].style.maxHeight = `${$currentBody[0].scrollHeight}px`;
      }
    }
  });
}

function initPage() {
  initAccordionFamilyOffice();
}

export {initPage};
