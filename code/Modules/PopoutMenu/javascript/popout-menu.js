;(function($) {
    $(document).ready(function(){

        /** =========================================
         * Popout Menu
         ==========================================*/

        var body = $('body'),
            button = $('.toggle-menu');

        button.on('click', function(e){
            body.toggleClass('show-menu');
        });

        $('.open-children').on('click', function(e){
            e.preventDefault();
            var target = $(this).data('target');
            $(target).toggleClass('active');
            $(this).toggleClass('active');
            return false;
        });

    });

})(jQuery);