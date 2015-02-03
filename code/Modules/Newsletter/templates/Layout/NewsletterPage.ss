<% include PageHeader %>

<div class="container">
    <% if $Menu(2) %><div class="row"><% end_if %>
        <% include SideBar %>
        <% if $Menu(2) %><div class="col-xs-12 col-sm-9"><% end_if %>
        <% include Content %>
        $Subscribe
        <% if $Menu(2) %></div><!-- /.col-xs-12 col-sm-9 --><% end_if %>
    <% if $Menu(2) %></div><!-- /.row --><% end_if %>
</div><!-- /.container -->

<% include PageItems %>