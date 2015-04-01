<?php

$formats = array(
    array(
        'title' => 'Heading - h1',
        'selector' => 'h1,h2,h3,h4,h5,h6',
        'classes' => 'h1',
        'wrapper' => false,
    ),
    array(
        'title' => 'Heading - h2',
        'selector' => 'h1,h2,h3,h4,h5,h6',
        'classes' => 'h2',
        'wrapper' => false,
    ),
    array(
        'title' => 'Heading - h3',
        'selector' => 'h1,h2,h3,h4,h5,h6',
        'classes' => 'h3',
        'wrapper' => false,
    ),
    array(
        'title' => 'Text - Primary',
        'block' => 'span',
        'classes' => 'text-primary',
        'wrapper' => true,
        'merge_siblings' => false
    ),
    array(
        'title' => 'Text - Secondary',
        'block' => 'span',
        'classes' => 'text-secondary',
        'wrapper' => true,
        'merge_siblings' => false
    ),
    array(
        'title' => 'Button - Default',
        'selector' => 'a, button',
        'classes' => 'btn btn-default',
        'wrapper' => false,
    ),
    array(
        'title' => 'Button - Primary',
        'selector' => 'a, button',
        'classes' => 'btn btn-primary',
        'wrapper' => false,
    ),
    array(
        'title' => 'Button - Secondary',
        'selector' => 'a, button',
        'classes' => 'btn btn-secondary',
        'wrapper' => false,
    ),
    array(
        'title' => 'Button - Link',
        'selector' => 'a, button',
        'classes' => 'btn-link',
        'wrapper' => false,
    ),
    array(
        'title' => 'Button - Bordered',
        'selector' => 'a, button',
        'classes' => 'btn-bordered',
        'wrapper' => false,
    ),
    array(
        'title' => 'Button - Large',
        'selector' => 'a, button',
        'classes' => 'btn-lg',
        'wrapper' => false,
    ),
    array(
        'title' => 'Button - Small',
        'selector' => 'a, button',
        'classes' => 'btn-sm',
        'wrapper' => false,
    ),
    array(
        'title' => 'Alert - Success',
        'block' => 'div',
        'classes' => 'alert alert-success',
        'wrapper' => true,
        'merge_siblings' => false
    ),
    array(
        'title' => 'Alert - Info',
        'block' => 'div',
        'classes' => 'alert alert-info',
        'wrapper' => true,
        'merge_siblings' => false
    ),
    array(
        'title' => 'Alert - Warning',
        'block' => 'div',
        'classes' => 'alert alert-warning',
        'wrapper' => true,
        'merge_siblings' => false
    ),
    array(
        'title' => 'Alert - Danger',
        'block' => 'div',
        'classes' => 'alert alert-danger',
        'wrapper' => true,
        'merge_siblings' => false
    ),
    array(
        'title' => 'List - Checklist',
        'selector' => 'ul',
        'classes' => 'checklist',
        'wrapper' => false
    ),
    array(
        'title' => 'List - Deletelist',
        'selector' => 'ul',
        'classes' => 'deletelist',
        'wrapper' => false
    ),
    array(
        'title' => 'Table',
        'selector' => 'table',
        'classes' => 'table',
        'wrapper' => false
    ),
    array(
        'title' => 'Table - Striped',
        'selector' => 'table',
        'classes' => 'table table-striped',
        'wrapper' => false
    ),
    array(
        'title' => 'Table - Bordered',
        'selector' => 'table',
        'classes' => 'table table-bordered',
        'wrapper' => false
    ),
    array(
        'title' => 'Table - Condensed',
        'selector' => 'table',
        'classes' => 'table table-condensed',
        'wrapper' => false
    ),
    array(
        'title' => 'Table - Responsive',
        'block' => 'div',
        'classes' => 'table-responsive',
        'wrapper' => true,
        'merge_siblings' => false
    )
);

HtmlEditorConfig::get('cms')->setOption('style_formats', $formats);
HtmlEditorConfig::get('cms')->setOption('theme_advanced_blockformats','p,h2,h3,h4');

/* -----------------------------------------
 * HTMLEditorField
------------------------------------------*/

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
HtmlEditorConfig::get('cms')->setButtonsForLine(1, 'styleselect', 'formatselect', 'separator', 'bullist', 'numlist', 'separator', 'justifyleft', 'justifycenter', 'justifyright', 'separator', 'image', 'separator', 'sslink', 'unlink', 'separator', 'bold', 'blockquote', 'separator', 'pastetext', 'pasteword', 'separator', 'code');
HtmlEditorConfig::get('cms')->setButtonsForLine(2, '');
HtmlEditorConfig::get('cms')->setButtonsForLine(3, '');
HtmlEditorConfig::get('cms')->disablePlugins('table', 'contextmenu');

/* -----------------------------------------
 * Pricing Table
------------------------------------------*/

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