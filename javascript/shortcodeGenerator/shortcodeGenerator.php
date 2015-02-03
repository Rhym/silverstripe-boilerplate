<?php

$shortcode = trim($_GET['type']);
$args = array(
    'title' => '',
    'out' => ''
);

switch($shortcode) {
    case 'pricing_table':
        $args['title'] = 'Pricing Table';
        $args['out'] .= '<table style="width: 100%;">';
        $args['out'] .= '<tr><td><label for="title">Title</label></td><td><input class="text" name="title" type="text" /></td></tr>';
        $args['out'] .= '<tr><td><label for="amount">Amount</label></td><td><input class="text" name="amount" type="text" /></td></tr>';
        $args['out'] .= '<tr><td><label for="button_text">Button Text</label></td><td><input class="text" name="button_text" type="text" /></td></tr>';
        $args['out'] .= '<tr><td><label for="button_URL">Button URL</label></td><td><input class="text" name="button_URL" type="text" /></td></tr>';
        $args['out'] .= '<tr><td><label for="list">List Items</label></td><td><textarea rows="8" id="list" class="textarea" name="list" ></textarea></td></tr>';
        $args['out'] .= '</table>';
        break;
    default:
        $args['title'] = 'Default';
        $args['out'] = 'No short code selected';
}


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $args['title'] ?></title>
    <script type="text/javascript" src="../../../framework/thirdparty/tinymce/tiny_mce_popup.js"></script>
    <script type="text/javascript" src="../../../boilerplate/javascript/jquery.1.11.1.min.js"></script>
    <style type="text/css">
        <!--
            .textarea{
                width: 100%;
            }
        -->
    </style>
    <script type="text/javascript">
        function setContent(){
            var content;

            switch('<?php echo $shortcode; ?>'){
                case 'pricing_table':
                    var list = $('#list').val().replace(/\r\n|\r|\n/g,"</li><li>"),
                        title = $('input[name="title"]').val(),
                        amount = $('input[name="amount"]').val(),
                        button_text = $('input[name="button_text"]').val(),
                        button_URL = $('input[name="button_URL"]').val();
                    content = '[pricing_table title="'+title+'" amount="'+amount+'" button_text="'+button_text+'" button_URL="'+button_URL+'"]';
                    content+='<ul><li>'+list+'</li></ul>';
                    content+='[/pricing_table]';
                    break;
                default:
                    content = '';
            }

            parent.tinymce.activeEditor.execCommand('mceInsertContent', false, content);
            tinyMCEPopup.close();
            return false;
        }
    </script>
<!--    <script type="text/javascript" src="../../../framework/thirdparty/tinymce/tiny_mce_popup.js"></script>-->
</head>
<body style="display:none; overflow:hidden;">

    <form name="source" onsubmit="return PasteWordDialog.insert();" action="#">

        <?php echo $args['out']; ?>

        <div class="mceActionPanel">
            <input type="button" id="" name="" value="{#insert}" onclick="setContent();" />
            <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
        </div>
    </form>

</body>
</html>