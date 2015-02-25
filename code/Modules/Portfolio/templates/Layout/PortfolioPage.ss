<% include PageHeader %>
<% cached LastEdited %>
<div class="container">
    <% include Content %>
    <% if $PortfolioImages %>
        <section class="portfolio page">
            <% loop $PortfolioImages %>
                <div class="item">
                    <% if $Content %>
                        <div class="row">
                            <% if $TextRight %>
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
            <% end_loop %>
        </section><!-- /.portfolio page -->
    <% end_if %>
</div><!-- /.container -->
<% end_cached %>
<% include ImageNavigation %>