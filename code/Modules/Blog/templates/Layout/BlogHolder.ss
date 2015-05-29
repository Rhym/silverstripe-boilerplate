<% include PageHeader %>

<div class="container">
    <div class="row">
        <% include BlogSidebar %>
        <div class="page__content has-sidebar">
            <% include Content %>
            <div class="ajax-content">
                <% include BlogHolder_Item %>
            </div><!-- /.ajax-content -->
        </div><!-- /.page__content has-sidebar -->
    </div><!-- /.row -->
</div><!-- /.container -->