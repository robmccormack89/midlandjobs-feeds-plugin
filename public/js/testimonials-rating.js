jQuery(function(){
  var tesimonials_swiper = new Swiper('#slideshow_tesimonials', {
    slidesPerView: 1,
    spaceBetween: 0,
    // autoplay: {
    //   delay: 4000,
    //   disableOnInteraction: true,
    // },
    // init: false,
    pagination: {
      el: '.swiper-pagination',
      dynamicBullets: true,
    },
  });
});