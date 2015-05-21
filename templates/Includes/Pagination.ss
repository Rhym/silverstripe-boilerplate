<% if $PaginatedPages.MoreThanOnePage %>
<ul class="pagination ajax-control">
    <% if $PaginatedPages.NotFirstPage %>
        <li><a class="prev" href="{$PaginatedPages.PrevLink}">Prev</a></li>
    <% else %>
        <li><span>Prev</span></li>
    <% end_if %>
    <% loop $PaginatedPages.Pages %>
        <% if $CurrentBool %>
            <li class="active"><span>{$PageNum}</span></li><!-- /.active -->
        <% else %>
            <% if $Link %>
                <li><a href="{$Link}">{$PageNum}</a></li>
            <% else %>
                <li><%t Pagination.Ellipsis '...' %></li>
            <% end_if %>
        <% end_if %>
    <% end_loop %>
    <% if $PaginatedPages.NotLastPage %>
        <li><a class="next" href="$PaginatedPages.NextLink">Next</a></li>
    <% else %>
        <li><span>Next</span></li>
    <% end_if %>
</ul><!-- /.pagination ajax-control -->
<% end_if %>