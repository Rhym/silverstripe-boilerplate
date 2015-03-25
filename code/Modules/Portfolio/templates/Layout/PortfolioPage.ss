<% include PageHeader %>
<div class="container">
    <% cached $LastEdited %>
    <% include Content %>
    <% end_cached %>
    <% if $PortfolioImages %>
        <section class="portfolio page">
            <% loop $PortfolioImages %>
            <% cached $LastEdited %>
            <div class="item">
            <% if $Content %>
                <div class="row">
                    <% if $ContentPosition = 'Right' %>
                    <div class="col-sm-9">
                        {$Image.setWidth(848)}
                    </div><!-- /.col-sm-9 -->
                    <div class="col-sm-3">
                        <aside class="typography caption-right">
                            {$Content}
                        </aside><!-- /.typography -->
                    </div><!-- /.col-sm-3 -->
                    <% else %>
                    <div class="col-sm-3">
                        <aside class="typography caption-left">
                            {$Content}
                        </aside><!-- /.typography -->
                    </div><!-- /.col-sm-3 -->
                    <div class="col-sm-9">
                        {$Image.setWidth(848)}
                    </div><!-- /.col-sm-9 -->
                    <% end_if %>
                </div><!-- /.row -->
            <% else %>
                {$Image.setWidth(1140)}
            <% end_if %>
            </div><!-- /.item -->
            <% end_cached %>
            <% end_loop %>
        </section><!-- /.portfolio page -->
    <% end_if %>
</div><!-- /.container -->
<% include ImageNavigation %>