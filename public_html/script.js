

$(window).scroll(function() {    
  var scroll = $(window).scrollTop();

   //>=, not <=
  if (scroll >= 100) {
      //clearHeader, not clearheader - caps H
      $("header").addClass("scrolled");
  }
  else {
    $("header").removeClass("scrolled");

  }
}); //missing );


$(".accordion-header").click(function () {
  $(this).toggleClass('-show');
  $(this).parent('.accordion-item').siblings().children('.accordion-header').removeClass('-show');
});



$(".schedule-mobile").click(function () {
  $('.right').removeClass('-hide');
});

$('.schedule-mobile').click(function () {
  if ($("#myVideo").prop('muted')) {
    $("#myVideo").prop('muted', false);
    $(this).toggleClass('unmute');
    // or toggle class, style it with a volume icon sprite, change background-position
  } else {
    $("#myVideo").prop('muted', true);
    $(this).toggleClass('unmute');
  }
});


$(".close").click(function () {
  $('.right').addClass('-hide');
});

$('.close').click(function () {
  if ($("#myVideo").prop('muted')) {
    $("#myVideo").prop('muted', false);
    $(this).toggleClass('unmute');
    // or toggle class, style it with a volume icon sprite, change background-position
  } else {
    $("#myVideo").prop('muted', true);
    $(this).toggleClass('unmute');
  }
});


$(".about-scroll").click(function () {
  $('html, body').animate({
    scrollTop: $("#about").offset().top - 100
  }, 1000);
});

$(".footer-scroll").click(function () {
  $('html, body').animate({
    scrollTop: $("#footer").offset().top
  }, 1000);
});

AOS.init();


const swiper = new Swiper('.swiper', {
  // Optional parameters
  direction: 'horizontal',
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true, 
  
  // Responsive breakpoints
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 1,
      spaceBetween: 20
    },
    // when window width is >= 480px
    480: {
      slidesPerView: 1,
      spaceBetween: 30
    },
    // when window width is >= 640px
    640: {
      slidesPerView: 2,
      spaceBetween: 40
    },
    1024: {
      slidesPerView: 3,
      spaceBetween: 40
    }
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

});