;(function($) {
    $(document).ready(function(){

        /*---------------------------------------------*\
            Gallery
        \*---------------------------------------------*/

        $('.has-events').on('click', function(e){
            e.preventDefault();
            $toggleID = $(this).data('show');
            if($($toggleID).hasClass('active')){
                return false;
            }
            $('.events-toggle').stop(false, true).slideUp(100).removeClass('active');
            $($toggleID).stop(false, true).slideDown(100).addClass('active');
            return false;
        });

    });
})(jQuery);