jQuery(document).ready(function ($) {
    $('.burger-button').click((e) => {
        e.preventDefault()
        $('ul.menu-container-list').toggleClass('open')
    })

    $('.next-button').click(function(e) {
        e.preventDefault();

        let carouselContainer = $(this).closest('.carousel-container');
        let carouselElement = carouselContainer.find('.carousel');
        let carouselItemWidth = carouselElement.find('.carousel-item').first().outerWidth();
        let scrollAmount = carouselElement.scrollLeft() + carouselItemWidth;

        carouselElement.animate({ scrollLeft: scrollAmount }, 800);

        let prevButton = carouselContainer.find('.prev-button');
        prevButton.show();
    });

    $('.prev-button').click(function(e) {
        e.preventDefault();

        let carouselContainer = $(this).closest('.carousel-container');
        let carouselElement = carouselContainer.find('.carousel');
        let carouselItemWidth = carouselElement.find('.carousel-item').first().outerWidth();
        let scrollAmount = carouselElement.scrollLeft() - carouselItemWidth;

        carouselElement.animate({ scrollLeft: scrollAmount }, 800);

        let prevButton = carouselContainer.find('.prev-button');
        if (scrollAmount <= 0) {
            prevButton.hide();
        }
    });

    $('.carousel').scroll(function() {
        let carouselContainer = $(this).closest('.carousel-container');
        let carouselElement = carouselContainer.find('.carousel');
        let prevButton = carouselContainer.find('.prev-button');

        if (carouselElement.scrollLeft() <= 0) {
            prevButton.hide();
        } else {
            prevButton.show();
        }
    });

    $('.carousel-container').each(function() {
        const carousel = $(this).find('.carousel');
        carousel.scrollLeft(0);

        let pos = { left: 0, x: 0 };
        carousel.on('mousedown', mouseDownHandler);

        function mouseDownHandler(e) {
            pos = {
                left: carousel.scrollLeft(),
                x: e.clientX,
            };

            $(document).on('mousemove', mouseMoveHandler);
            $(document).on('mouseup', mouseUpHandler);

            carousel.css('cursor', 'grabbing');
            carousel.css('user-select', 'none');
        }

        function mouseMoveHandler(e) {
            const dx = e.clientX - pos.x;
            carousel.scrollLeft(pos.left - dx);
        }

        function mouseUpHandler() {
            $(document).off('mousemove', mouseMoveHandler);
            $(document).off('mouseup', mouseUpHandler);

            carousel.css('cursor', 'grab');
            carousel.css('user-select', 'auto');
        }
    });



})

