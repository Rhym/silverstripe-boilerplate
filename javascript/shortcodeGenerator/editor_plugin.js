(function() {
    tinymce.create('tinymce.plugins.shortcodeGenerator', {

        init : function(ed, url) {
            var self = this;

            ed.addButton ('shortcodeGenerator', {
                'title' : 'Shortcode Generator',
                'image' : url+'/myplugin.png',
                'cmd': 'shordcodePopup'
            });

            ed.addCommand("shordcodePopup", function() {
                ed.windowManager.open({
                    file: url + "/shortcodeGenerator.php?type=pricing_table",
                    width: parseInt(400),
                    //height: parseInt(600),
                    inline: 1
                });
            });

        }
    });

    tinymce.PluginManager.add('shortcodeGenerator', tinymce.plugins.shortcodeGenerator);

})();