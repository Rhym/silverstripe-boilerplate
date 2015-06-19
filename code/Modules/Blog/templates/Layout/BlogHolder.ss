<% include Page_Header %>

<div class="container">
    <div class="row">
        <div class="page__content has-sidebar">
            <h1 class="page__content__heading">{$Title}</h1><!-- /.page__content__heading -->
            <% include Content %>
            <div class="ajax-content">
                <% include BlogHolder_Item %>
            </div><!-- /.ajax-content -->
        </div><!-- /.page__content has-sidebar -->
        <% include BlogSidebar %>
    </div><!-- /.row -->
</div><!-- /.container -->