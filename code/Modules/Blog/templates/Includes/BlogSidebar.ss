<section class="sidebar col-sm-4 col-lg-3">
    <aside class="sidebar-nav widget">
        <% if $BlogSidebarContent || $Parent.BlogSidebarContent %>
            <aside class="content typography">
                {$BlogSidebarContent}
                {$Parent.BlogSidebarContent}
            </aside><!-- /.content typography -->
        <% end_if %>
        <ul>
            <% if $AllChildren %>
                <% loop $AllChildren.Limit(10) %>
                    <li class="{$LinkingMode}">
                        <a href="{$Link}" class="{$LinkingMode}" title="{$Title.XML}">
                            {$MenuTitle.XML}
                        </a>
                    </li>
                <% end_loop %>
            <% else %>
                <% loop $Parent.AllChildren.Limit(10) %>
                    <li class="{$LinkingMode}">
                        <a href="{$Link}" class="{$LinkingMode}" title="{$Title.XML}">
                            {$MenuTitle.XML}
                        </a>
                    </li>
                <% end_loop %>
            <% end_if %>
        </ul>
    </aside><!-- /.sidebar-nav -->
</section><!-- /.sidebar col-sm-4 col-lg-3 -->