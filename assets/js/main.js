var planCarousel = function() {
    $('.plan_carousel').owlCarousel({
        center: true,
        loop: true,
        items:1,
        margin: 30,
        stagePadding: 0,
        nav: false,
        autoplay:true,
        autoplayTimeout:1500,
        autoplayHoverPause:true,
        responsive:{
                0:{
                    items: 1,
                    navigation: true,
                    nav: true,
                    slideBy: 1
                },
                640:{
                    items: 2,
                    navigation: true,
                    nav: true,
                    slideBy: 1
                },
                1200:{
                    items: 4,
                    navigation: true,
                    nav: true,
                    slideBy: 1
                }
            }
    });
};
planCarousel();
