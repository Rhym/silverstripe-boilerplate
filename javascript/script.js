;(function($) {
    $(document).ready(function(){

        /*---------------------------------------------*\
            Carousel
        \*---------------------------------------------*/

        $('.owl-carousel').owlCarousel({
            items: 1,
            dots: false
        });

        /*---------------------------------------------*\
            Animation - https://github.com/imakewebthings/waypoints
        \*---------------------------------------------*/

        //$('.animated').waypoint(function(){
        //    var animation = $(this).data('animation');
        //    $(this).addClass(animation);
        //},{
        //    context: '.content-wrap',
        //    offset:'75%'
        //});

        /*---------------------------------------------*\
            Gallery
        \*---------------------------------------------*/

        // Closes all open modals when the navigation is used.
        $('.modal-navigation').on('click', function(){
            $('.modal').modal('hide');
        });

    });
})(jQuery);