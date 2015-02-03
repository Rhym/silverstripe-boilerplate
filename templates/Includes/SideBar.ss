<% if $Menu(2) && $HideSidebar != 1 %>
    <section class="sidebar col-sm-3">
        <aside class="widget">
            <ul>
            <% with $Level(1) %>
                <% if $Children %><li><h4 class="heading">{$MenuTitle.XML}</h4><!-- /.heading --></li><% end_if %>
                <% include SidebarMenu %>
            <% end_with %>
            </ul>
        </aside><!-- /.widget -->
    </section><!-- /.sidebar col-sm-3 -->
<% end_if %>