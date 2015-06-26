;(function($) {
    var $colorPicker = $('.color-picker');
    $.entwine('boilerplate', function($){
        $(document).on('click', function(e){
            if (!$(e.target).is(".color-picker, .iris-picker, .iris-picker-inner")) {
                $colorPicker.iris('hide');
            }
        });
        $colorPicker.entwine({
            onmatch: function(){
                var palettes = $colorPicker.data('palette');
                $colorPicker.iris({
                    palettes: palettes,
                    change: function(event, ui) {
                        var $c, $r, $g, $b, $mid;
                        $(this).css('backgroundColor', ui.color.toString());
                    }
                });
                var self = this;
                this.on('click', function(e) {
                    $colorPicker.iris('hide');
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