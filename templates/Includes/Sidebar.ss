<% cache 'SidebarMenuCache' %>
    <% if $Menu(2) && $HideSidebar != 1 %>
        <aside class="page__sidebar">
            <% with $Level(1) %>
                <div class="page__sidebar__content">
                    <ul class="navigation">
                        <% include Sidebar_Menu %>
                    </ul><!-- /.navigation -->
                </div><!-- /.page__sidebar__content -->
            <% end_with %>
        </aside><!-- /.sidebar -->
    <% end_if %>
<% end_cache %>