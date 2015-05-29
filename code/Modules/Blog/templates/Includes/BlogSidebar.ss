<section class="page__sidebar">
    <% if $BlogSidebarContent || $Parent.BlogSidebarContent %>
    <aside class="page__sidebar__content">
        {$BlogSidebarContent}
        {$Parent.BlogSidebarContent}
    </aside><!-- /.page__sidebar__content -->
    <% end_if %>
    <aside class="page__sidebar__content">
        <ul class="navigation">
            <% if $AllChildren %>
                <% loop $AllChildren.Limit(10) %>
                    <li class="navigation__item navigation__item--{$LinkingMode}">
                        <a href="{$Link}" title="{$Title.XML}">
                            {$MenuTitle.XML}
                        </a>
                    </li><!-- /.navigation__item -->
                <% end_loop %>
            <% else %>
                <% loop $Parent.AllChildren.Limit(10) %>
                    <li class="navigation__item navigation__item--{$LinkingMode}">
                        <a href="{$Link}" title="{$Title.XML}">
                            {$MenuTitle.XML}
                        </a>
                    </li><!-- /.navigation__item -->
                <% end_loop %>
            <% end_if %>
        </ul><!-- /.navigation -->
    </aside><!-- /.page__sidebar__content -->
</section><!-- /.page__sidebar -->