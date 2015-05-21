<% include PageHeader %>
<div class="container">
    <% cached $LastEdited %>
    <% include Content %>
    <% end_cached %>
    <div class="ajax-content">
        <% include PortfolioHolder_Item %>
    </div><!-- /.ajax-content -->
</div><!-- /.container -->