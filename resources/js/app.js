document.addEventListener('DOMContentLoaded', function () {
new Swiper('.lapangan-slider', {
      loop: true,
      navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
      },
      pagination: {
            el: '.swiper-pagination',
            clickable: true,
      },
});
});

