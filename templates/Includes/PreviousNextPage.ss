<% if $PreviousLink || $NextLink %>
    <nav class="previous-next ajax-control">
        <div class="container">
            <div class="previous-next__item previous-next__item--previous">
                <% if $PreviousLink %>
                    <% with $PreviousLink %>
                        <a href="{$Link}" title="{$Title}" class="previous-next__item__link">{$MenuTitle}</a><!-- /.previous-next__item__link -->
                    <% end_with %>
                <% end_if %>
            </div><!--- /.previous-next__item -->
            <div class="previous-next__item previous-next__item--next">
                <% if $NextLink %>
                    <% with $NextLink %>
                        <a href="{$Link}" title="{$Title}" class="previous-next__item__link">{$MenuTitle}</a><!-- /.previous-next__item__link -->
                    <% end_with %>
                <% end_if %>
            </div><!--- /.previous-next__item -->
        </div><!-- /.container -->
    </nav><!-- /.previous-next ajax-control -->
<% end_if %>