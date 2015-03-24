<% if $Menu(2) && $HideSidebar != 1 %>
    <section class="sidebar col-sm-3">
        <aside class="navigation">
            <ul>
            <% with $Level(1) %>
            <% if $Children %><li><h4 class="heading">{$MenuTitle.XML}</h4><!-- /.heading --></li><% end_if %>
            <% include SidebarMenu %>
            <% end_with %>
            </ul>
        </aside><!-- /.navigation -->
    </section><!-- /.sidebar col-sm-3 -->
<% end_if %>