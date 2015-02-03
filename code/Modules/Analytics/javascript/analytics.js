;(function($) {
    $.entwine('flot', function($){
        $('#placeholder').entwine({
            onmatch: function(){
                var self = this;
                var data = [
                    { label: "New Visitors",  data: 330, color: '#338dc1'},
                    { label: "Returning Visitors",  data: 36, color: '#b0bec7'}
                ];
                jQuery.plot('#placeholder', data, {
                    series: {
                        pie: {
                            innerRadius: 0.5,
                            show: true,
                            label: {
                                color: '#000'
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                });
                this._super();
            },
            onunmatch: function() {
                this._super();
            }
        });
    });
})(jQuery);