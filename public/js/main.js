// swiper JS
var swiper = new Swiper('.mySwiper', {
    slidesPerView: 1,
    spaceBetween: 10,
    breakpoints: {
        640: {
        slidesPerView: 2,
        spaceBetween: 20,
        },
        768: {
        slidesPerView: 3,
        spaceBetween: 30,
        },
        1024: {
        slidesPerView: 3,
        spaceBetween: 40,
        },
    },
    pagination: {
        el: '.swiper-pagination',
        // type: 'fraction',
        clickable: true,
    },
});