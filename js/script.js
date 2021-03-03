$('.review__wrapper').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: true,
    responsive: [
        {
          breakpoint: 1276,
          settings: {
            arrows: false
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 720,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }]
});