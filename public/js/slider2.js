$(document).ready(function () {
    var carousel = $(".owl-carousel");

    carousel.owlCarousel({
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            },
        },
        loop: false,
        center: true,
        autoWidth: false,
        responsiveClass: true,
        onTranslated: function (event) {
            var currentItem = event.item.index;

            $(".owl-item")
                .not(".cloned")
                .removeClass("zoom")
                .find("img")
                .css({
                    "transform": "scale(0.9) translateY(-30px)",
                    "opacity": "1",
                    "transition": "transform 0.4s ease, opacity 0.4s ease"
                });

            $(".owl-item")
                .eq(currentItem)
                .addClass("zoom")
                .find("img")
                .css({
                    "transform": "scale(1.3) translateY(-50px)",
                    "opacity": "1",
                    "transition": "transform 0.4s ease, opacity 0.4s ease",
                });
        },
    });

    setTimeout(function () {
        var firstItem = carousel.find(".owl-item").eq(0);
        firstItem.addClass("zoom").find("img").css({
            "transform": "scale(1.3)",
            "opacity": "1",
            "transition": "transform 0.4s ease, opacity 0.4s ease",
        });
    }, 0);

    $(".owl-dots").hide();

    $(".owl-prev").click(function () {
        carousel.trigger("prev.owl.carousel");
    });

    $(".owl-next").click(function () {
        carousel.trigger("next.owl.carousel");
    });
});