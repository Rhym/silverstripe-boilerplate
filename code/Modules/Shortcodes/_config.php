<?php

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