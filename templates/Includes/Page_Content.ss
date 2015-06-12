<div class="container">
    <div class="row">
        <% include SideBar %>
        <div class="page__content<% if $Menu(2) && $HideSidebar != 1 %> has-sidebar<% end_if %>">
            <% include Content %>
        </div><!-- /.page__content has-sidebar -->
    </div><!-- /.row -->
</div><!-- /.container -->