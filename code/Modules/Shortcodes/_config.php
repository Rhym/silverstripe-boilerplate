<?php

/** -----------------------------------------
 * HTMLEditorField
 *
 * Adding styles, and buttons
 * to the HTMLEditorField
-------------------------------------------*/

/**
 * Remove buttons from TinyMCE
 *
 * ====== List of available buttons ======
 *
 * bold
 * italic
 * underline
 * strikethrough
 * justifyleft
 * justifycenter
 * justifyright
 * justifyfull
 * bullist
 * numlist
 * outdent
 * indent
 * cut
 * copy
 * paste
 * undo
 * redo
 * link
 * unlink
 * image
 * cleanup
 * help
 * code
 * hr
 * removeformat
 * formatselect
 * fontselect
 * fontsizeselect
 * styleselect
 * sub
 * sup
 * forecolor
 * backcolor
 * forecolorpicker
 * backcolorpicker
 * charmap
 * visualaid
 * anchor
 * newdocument
 * blockquote
 * separator ( | is possible as separator, too)
 *
 * ====== Plugins with the button name same as plugin name ======
 *
 * advhr
 * emotions
 * fullpage
 * fullscreen
 * iespell
 * media
 * nonbreaking
 * pagebreak
 * preview
 * print
 * spellchecker
 * visualchars
 *
 * ====== Plugins with custom buttons ======
 *
 * advlink
 *      Will override the "link" button
 * advimage
 *      Will override the "image" button
 * paste
 *      pastetext
 *      pasteword
 *      selectall
 * searchreplace
 *      search
 *      replace
 * insertdatetime
 *      insertdate
 *      inserttime
 * table
 *      tablecontrols
 *      table
 *      row_props
 *      cell_props
 *      delete_col
 *      delete_row
 *      col_after
 *      col_before
 *      row_after
 *      row_before
 *      split_cells
 *      merge_cells
 * directionality
 *      ltr
 *      rtl
 * layer
 *      moveforward
 *      movebackward
 *      absolute
 *      insertlayer
 * save
 *      save
 *      cancel
 * style
 *      styleprops
 * xhtmlxtras
 *      cite
 *      abbr
 *      acronym
 *      ins
 *      del
 *      attribs
 * template
 *      template
 *
 */
HtmlEditorConfig::get('cms')->setButtonsForLine(1, 'styleselect', 'formatselect', 'separator', 'bullist', 'numlist', 'separator', 'justifyleft', 'justifycenter', 'justifyright', 'separator', 'image', 'separator', 'sslink', 'unlink', 'separator', 'bold', 'italic', 'blockquote', 'separator', 'pastetext', 'pasteword', 'separator', 'code');
HtmlEditorConfig::get('cms')->setButtonsForLine(2, '');
HtmlEditorConfig::get('cms')->setButtonsForLine(3, '');
HtmlEditorConfig::get('cms')->disablePlugins('table', 'contextmenu');

/** -----------------------------------------
 * Pricing Table
-------------------------------------------*/

ShortcodeParser::get('default')->register('pricing_table', function($args, $list, $parser, $shortcode) {
    $title = (isset($args['title']) && $args['title']) ? $args['title'] : 'Title';
    $amount = (isset($args['amount']) && $args['amount']) ? $args['amount'] : '100';
    $buttonText = (isset($args['button_text']) && $args['button_text']) ? $args['button_text'] : 'Button Text';
    $buttonURL = (isset($args['button_URL']) && $args['button_URL']) ? $args['button_URL'] : '#';

    return sprintf(
        '<div class="pricing-table">'.
            '<div class="price">'.
                '<h3 class="heading">%s</h3>'.
                '<div class="amount">%s</div>'.
                '<a href="%s" class="btn btn-primary btn-lg btn-block">%s</a>'.
            '</div>'.
            '<div class="list">'.$list.'</div>'.
        '</div>',
        $title,
        $amount,
        $buttonURL,
        $buttonText
    );
});