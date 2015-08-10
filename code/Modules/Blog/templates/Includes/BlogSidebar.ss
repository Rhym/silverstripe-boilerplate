<aside class="page__sidebar">
    <% if $BlogSidebarContent || $Parent.BlogSidebarContent %>
    <div class="page__sidebar__content">
        {$BlogSidebarContent}
        {$Parent.BlogSidebarContent}
    </div><!-- /.page__sidebar__content -->
    <% end_if %>
    <div class="page__sidebar__content">
        <ul class="navigation">
            <% if $AllChildren %>
                <% loop $AllChildren.Limit(10) %>
                    <li class="navigation__item is-{$LinkingMode}<% if $FirstLast %> is-{$FirstLast}<% end_if %>">
                        <a href="{$Link}" title="{$Title.XML}">
                            {$MenuTitle.XML}
                        </a>
                    </li><!-- /.navigation__item -->
                <% end_loop %>
            <% else %>
                <% loop $Parent.AllChildren.Limit(10) %>
                    <li class="navigation__item is-{$LinkingMode}<% if $FirstLast %> is-{$FirstLast}<% end_if %>">
                        <a href="{$Link}" title="{$Title.XML}">
                            {$MenuTitle.XML}
                        </a>
                    </li><!-- /.navigation__item -->
                <% end_loop %>
            <% end_if %>
        </ul><!-- /.navigation -->
    </div><!-- /.page__sidebar__content -->
</aside><!-- /.page__sidebar -->
