<% if $PreviousLink || $NextLink %>
    <nav class="previous-next section ajax-control">
        <div class="container">
            <div class="previous-next__item previous-next__item--previous">
                <% if $PreviousLink %>
                    <% with $PreviousLink %>
                        <a href="{$Link}" title="{$Title}" class="previous-next__item__link"><i class="fa fa-angle-left"></i> {$MenuTitle}</a><!-- /.previous-next__item__link -->
                    <% end_with %>
                <% end_if %>
            </div><!--- /.previous-next__item previous-next__item--previous -->
            <div class="previous-next__item previous-next__item--next">
                <% if $NextLink %>
                    <% with $NextLink %>
                        <a href="{$Link}" title="{$Title}" class="previous-next__item__link">{$MenuTitle} <i class="fa fa-angle-right"></i></a><!-- /.previous-next__item__link -->
                    <% end_with %>
                <% end_if %>
            </div><!--- /.previous-next__item previous-next__item--next -->
        </div><!-- /.container -->
    </nav><!-- /.previous-next section ajax-control -->
<% end_if %>