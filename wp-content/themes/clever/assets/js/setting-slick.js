$('.main-banner__content').slick({
  infinite: true,
  // autoplay: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  dots: false,
  arrows: true,
  responsive: [{
      breakpoint: 1200,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 900,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        // autoplay: true,
        arrows: false,
        autoplaySpeed: 1000
      }
    }
  ]
});

$('.pre-navbar__carousel').slick({
  autoplay: true,
  autoplaySpeed: 3500,
  slidesToShow: 1,
  infinite: true,
  // slidesToScroll: 1,
  dots: false,
  arrows: false,
});




$('.main-video__carousel').slick({
  centerMode: true,
  centerPadding: '0',
  arrows: true,
  dots: true,
  slidesToShow: 3,
  responsive: [{
      breakpoint: 997,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: false,
        dots: true,
        autoplay: false,
        centerPadding: '0',
        slidesToShow: 1
      }
    }
  ]
});


$('.main-products__carousel').slick({
  infinite: true,
  slidesToShow: 5,
  slidesToScroll: 1,

  dots: false,
  arrows: true,
  prevArrow: '<div> <div class="slick-prev-arrow"><i class="fa fa-chevron-left" aria-hidden="true"></i><p class="be">Antes</p></div> </div>', //$('.slick-prev-arrow'),
  nextArrow: '<div class="slick-next-arrow"><p class="af">Después</p><i class="fa fa-chevron-right" aria-hidden="true"></i></div>', //$('.slick-next-arrow'),
  responsive: [{
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        arrows: true,
      }
    },
    {
      breakpoint: 900,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        // autoplay: true,
        autoplaySpeed: 1000,
      }
    }
  ]
});

$('.main-products__carousel .slick-next').attr('value', 'Siguiente');