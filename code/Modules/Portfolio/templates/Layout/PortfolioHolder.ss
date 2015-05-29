<% include PageHeader %>

<div class="container">
    <div class="row">
        <div class="page__content">
            <% cached $LastEdited %>
                <% include Content %>
            <% end_cached %>
            <div class="ajax-content">
                <% include PortfolioHolder_Item %>
            </div><!-- /.ajax-content -->
        </div><!-- /.page__content has-sidebar -->
    </div><!-- /.row -->
</div><!-- /.container -->