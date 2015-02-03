;(function($) {
    $.entwine('boilerplate', function($){
        $('.color-picker').entwine({
            onmatch: function(){
                var self = this;
                this.on('click', function(e) {
                    $(this).iris({
                        hide: false,
                        palettes: ['#3f51b5', '#ff4081', '#212121', '#fff'],
                        change: function(event, ui) {
                            var $c, $r, $g, $b, $mid;
                            $(this).css('backgroundColor', ui.color.toString());
                        }
                    });
                });
                this._super();
            },
            onunmatch: function() {
                this._super();
            }
        });
    });
})(jQuery);