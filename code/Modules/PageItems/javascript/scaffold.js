;(function($) {
    $.entwine('boilerplate', function($){
        $('.pagebuilder-collection').entwine({
            onmatch: function(){
                var self = this,
                    gridster;
                $(function(){ //DOM Ready
                    gridster = $(".pagebuilder-collection").gridster({
                        widget_base_dimensions: [100, 40],
                        widget_margins: [5, 5],

                        // Grid X axis size
                        min_cols: 10,
                        max_size_x: 10
                    }).data('gridster');
                });

                this._super();
            },
            onunmatch: function() {
                this._super();
            }
        });
    });
})(jQuery);