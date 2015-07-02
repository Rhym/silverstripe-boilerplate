<div class="container">
    <div class="row">
        <div class="page__content<% if $Menu(2) && $HideSidebar != 1 %> has-sidebar<% end_if %>">
            <h1 class="page__content__heading">{$Title}</h1><!-- /.page__content__heading -->
            <% include Content %>
        </div><!-- /.page__content has-sidebar -->
        <% include Sidebar %>
    </div><!-- /.row -->
</div><!-- /.container -->