<% if $Menu(2) && $HideSidebar != 1 %>
<section class="page__sidebar">
    <aside class="page__sidebar__content">
        <ul class="navigation">
            <% with $Level(1) %>
                <% if $Children %><li class="navigation__item"><h4 class="navigation__item__heading">{$MenuTitle.XML}</h4><!-- /.navigation__item__heading --></li><!-- /.navigation__item --><% end_if %>
                <% include SidebarMenu %>
            <% end_with %>
        </ul><!-- /.navigation -->
    </aside><!-- /.page__sidebar__content -->
</section><!-- /.sidebar -->
<% end_if %>