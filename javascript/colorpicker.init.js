;(function($) {
    $.entwine('boilerplate', function($){
        $(document).on('click', function(e){
            if (!$(e.target).is(".color-picker, .iris-picker, .iris-picker-inner")) {
                $('.color-picker').iris('hide');
                return false;
            }
        });
        $('.color-picker').entwine({
            onmatch: function(){
                $('.color-picker').iris({
                    palettes: ['#3f51b5', '#ff4081', '#212121', '#fff'],
                    change: function(event, ui) {
                        var $c, $r, $g, $b, $mid;
                        $(this).css('backgroundColor', ui.color.toString());
                    }
                });
                var self = this;
                this.on('click', function(e) {
                    $('.colour-picker').iris('hide');
                    $(this).iris('show');
                });
                this._super();
            },
            onunmatch: function() {
                this._super();
            }
        });
    });
})(jQuery);