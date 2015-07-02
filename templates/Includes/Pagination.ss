<% if $PaginatedPages.MoreThanOnePage %>
    <ul class="pagination ajax-control">
        <% if $PaginatedPages.NotFirstPage %>
            <li class="pagination__item">
                <a class="pagination__item__link pagination__item__link--prev" href="{$PaginatedPages.PrevLink}">Prev</a>
            </li><!-- /.pagination__item -->
        <% else %>
            <li class="pagination__item">
                <span class="pagination__item__link pagination__item__link--prev pagination__item__link--disabled">Prev</span>
            </li><!-- /.pagination__item -->
        <% end_if %>
        <% loop $PaginatedPages.Pages %>
            <% if $CurrentBool %>
                <li  class="pagination__item pagination__item">
                    <span class="pagination__item__link pagination__item__link--active">{$PageNum}</span>
                </li><!-- /.pagination__item -->
            <% else %>
                <% if $Link %>
                    <li class="pagination__item">
                        <a href="{$Link}" class="pagination__item__link">{$PageNum}</a>
                    </li><!-- /.pagination__item -->
                <% else %>
                    <li class="pagination__item">
                        <span class="pagination__item__link pagination__item__link--disabled">...</span>
                    </li><!-- /.pagination__item -->
                <% end_if %>
            <% end_if %>
        <% end_loop %>
        <% if $PaginatedPages.NotLastPage %>
            <li class="pagination__item">
                <a class="pagination__item__link pagination__item__link--next" href="$PaginatedPages.NextLink">Next</a>
            </li><!-- /.pagination__item -->
        <% else %>
            <li class="pagination__item">
                <span class="pagination__item__link pagination__item__link--next pagination__item__link--disabled">Next</span>
            </li><!-- /.pagination__item -->
        <% end_if %>
    </ul><!-- /.pagination ajax-control -->
<% end_if %>