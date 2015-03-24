<% include PageHeader %>
<div class="container">
    <div class="row">
        <% include SideBar %>
        <div class="col-xs-12 <% if $Menu(2) && $HideSidebar != 1 %>col-sm-9<% end_if %>">
            <% include Content %>
        </div><!-- /.col-xs-12 col-sm-9 -->
    </div><!-- /.row -->
</div><!-- /.container -->