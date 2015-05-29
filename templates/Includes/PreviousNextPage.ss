<% if $PreviousLink || $NextLink %>
<section class="previous-next section ajax-control">
    <div class="container">
        <article class="previous-next__item previous-next__item--previous">
        <% if $PreviousLink %>
            <% with $PreviousLink %>
                <a href="{$Link}" title="{$Title}"><i class="fa fa-angle-left"></i> {$MenuTitle}</a>
            <% end_with %>
        <% end_if %>
        </article><!--- /.col-xs-6 item-previous -->
        <article class="previous-next__item previous-next__item--next">
        <% if $NextLink %>
            <% with $NextLink %>
                <a href="{$Link}" title="{$Title}">{$MenuTitle} <i class="fa fa-angle-right"></i></a>
            <% end_with %>
        <% end_if %>
        </article><!--- /.col-xs-6 item-next -->
    </div><!-- /.container -->
</section><!-- /.previous-next section ajax-control -->
<% end_if %>