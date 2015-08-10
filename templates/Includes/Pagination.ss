<% if $PaginatedPages.MoreThanOnePage %>
    <ul class="pagination ajax-control">
        <% if $PaginatedPages.NotFirstPage %>
            <li class="pagination__item">
                <a class="pagination__item__link pagination__item__link--prev" href="{$PaginatedPages.PrevLink}"><%t Pagination.PreviousText "Prev" %></a>
            </li><!-- /.pagination__item -->
        <% else %>
            <li class="pagination__item">
                <span class="pagination__item__link pagination__item__link--prev is-disabled"><%t Pagination.PreviousText "Prev" %></span>
            </li><!-- /.pagination__item -->
        <% end_if %>
        <% loop $PaginatedPages.Pages %>
            <% if $CurrentBool %>
                <li class="pagination__item is-{$EvenOdd}<% if $FirstLast %> is-{$FirstLast}<% end_if %> is-active">
                    <span class="pagination__item__link is-active">{$PageNum}</span>
                </li><!-- /.pagination__item -->
            <% else %>
                <% if $Link %>
                    <li class="pagination__item is-{$EvenOdd}<% if $FirstLast %> is-{$FirstLast}<% end_if %>">
                        <a href="{$Link}" class="pagination__item__link">{$PageNum}</a>
                    </li><!-- /.pagination__item -->
                <% else %>
                    <li class="pagination__item is-{$EvenOdd}<% if $FirstLast %> is-{$FirstLast}<% end_if %>">
                        <span class="pagination__item__link is-disabled"><%t Pagination.Ellipsis "..." %></span>
                    </li><!-- /.pagination__item -->
                <% end_if %>
            <% end_if %>
        <% end_loop %>
        <% if $PaginatedPages.NotLastPage %>
            <li class="pagination__item">
                <a class="pagination__item__link pagination__item__link--next" href="$PaginatedPages.NextLink"><%t Pagination.NextText "Next" %></a>
            </li><!-- /.pagination__item -->
        <% else %>
            <li class="pagination__item">
                <span class="pagination__item__link pagination__item__link--next is-disabled"><%t Pagination.NextText "Next" %></span>
            </li><!-- /.pagination__item -->
        <% end_if %>
    </ul><!-- /.pagination ajax-control -->
<% end_if %>
