jQuery(function($) {
    if($('.entry-content table').length > 0){
        $('.entry-content table').each(function(i, obj) {
            $(this).addClass('table');
            $(this).after( "<div class='table-reponsive table"+i+"'></div>" );
            $(this).appendTo(".table"+i+"");
            $(this).find('thead').addClass('table-dark');
        });
    }

    $('.slider-logo').slick({
        dots: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToShow: 5,
        slidesToScroll: 5,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 5,
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
});