window.onscroll = function () {
     myFunction();

};

var header = document.getElementById("myheader");
var sticky = header.offsetTop;

function myFunction() {
     if (window.pageYOffset > sticky) {
          header.classList.add("bgwhite");
     } else {
          header.classList.remove("bgwhite");
     }
}

$('#slider-image').owlCarousel({
     rtl: true,
     center: true,
     items: 2,
     loop: true,
     nav: false,
     dots: true,
     margin: 25,
     responsive: {
          0: {
               items: 1
          },
          576: {
               items: 2
          },
          768: {
               items: 3
          },
          992:{
               items: 4
          },
     }
});
$('#slider-testimonial').owlCarousel({
     rtl: true,
     center: true,
     items: 1,
     loop: true,
     nav: false,
     dots: false,
     margin: 25,
     autoplay:true,
     autoplayTimeout:2000,
     autoplayHoverPause:true,
     responsive: {
          0: {
               items: 1
          },
          768: {
               items: 2
          },
          992:{
               items: 3
          },
     }
});



jQuery(document).ready(function ($) {
     function scrollToSection(event) {
          event.preventDefault();
          var $section = $($(this).attr('href'));
          $('html, body').animate({
               scrollTop: $section.offset().top
          }, 500);
     }
     $('[data-scroll]').on('click', scrollToSection);
}(jQuery));


function OnePageMenuScroll() {
     var windscroll = $(window).scrollTop();
     if (windscroll >= 100) {
          var menuAnchor = $('.nav-main .scrollToLink').children('a');
          menuAnchor.each(function () {
               // grabing section id dynamically
               var sections = $(this).attr('href');
               $(sections).each(function () {
                    // checking is scroll bar are in section
                    if ($(this).offset().top <= windscroll + 100) {
                         // grabing the dynamic id of section
                         var Sectionid = $(sections).attr('id');
                         // removing current class from others
                         $('.nav-main').find('li').removeClass('current');
                         // adding current class to related navigation
                         $('.nav-main').find('a[href*=\\#' + Sectionid + ']').parent().addClass('current');
                    }
               });
          });
     } else {
          $('.nav-main li.current').removeClass('current');
          $('.nav-main li:first').addClass('current');
     }
}
$(window).on('scroll', function() {
     if ($('#navbarNav').length) {
         var headerScrollPos = 100;
         var stricky = $('#navbarNav');
         if ($(window).scrollTop() > headerScrollPos) {
             stricky.removeClass('slideIn animated');
             stricky.addClass('stricky-fixed slideInDown animated');
         } else if ($(this).scrollTop() <= headerScrollPos) {
             stricky.removeClass('stricky-fixed slideInDown animated');
             stricky.addClass('slideIn animated');
         }
     };
     OnePageMenuScroll();
 });