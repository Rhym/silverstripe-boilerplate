<div class="<% if $Animated %>animated <% end_if %>column {$Size}"<% if $Animated %> data-animation="{$Animated}"<% end_if %>>
    <article class="item image {$EvenOdd} {$FirstLast}<% if $HoverImage %> has-hover<% end_if %>">
        <div class="inner">
            <% if $LinkSwitch %>
                <a href="{$LinkSwitch}">
                    <div class="main">$Image</div><!-- /.main -->
                    <% if $HoverImage %><div class="hover">{$HoverImage}</div><!-- /.hover --><% end_if %>
                </a>
            <% else %>
                <div class="main">$Image</div><!-- /.main -->
                <% if $HoverImage %><div class="hover">{$HoverImage}</div><!-- /.hover --><% end_if %>
            <% end_if %>
        </div><!-- /.inner -->
    </article><!-- /.item image -->
</div><!-- /.column {$Size} -->
<% if $ClearRow %><div class="clearfix"></div><% end_if %>