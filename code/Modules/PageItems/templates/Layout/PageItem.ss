<div class="<% if $Animated %>animated <% end_if %>column {$Size}"<% if $Animated %> data-animation="{$Animated}"<% end_if %>>
    <article class="inner typography">
        {$Content}
    </article><!-- /.inner typography -->
</div><!-- /.column {$Size} -->
<% if $ClearRow %><div class="clearfix"></div><% end_if %>