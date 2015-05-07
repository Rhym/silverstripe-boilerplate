<% include PageHeader %>
<div class="container">
    <% cached $LastEdited %>
    <% include Content %>
    <% end_cached %>
    <% if $PortfolioImages %>
        <section class="portfolio section">
            <div class="loop">
                <% loop $PortfolioImages %>
                <div class="item {$EvenOdd} {$FirstLast}">
                <% if $Content %>
                    <div class="row">
                        <% if $ContentPosition = 'Left' %>
                        <div class="col-sm-9">
                            {$Image.setWidth(848)}
                        </div><!-- /.col-sm-9 -->
                        <div class="col-sm-3">
                            <aside class="typography caption-right">
                                {$Content}
                            </aside><!-- /.typography caption-right -->
                        </div><!-- /.col-sm-3 -->
                        <% else_if $ContentPosition = 'Right' %>
                        <div class="col-sm-3">
                            <aside class="typography caption-left">
                                {$Content}
                            </aside><!-- /.typography caption-left -->
                        </div><!-- /.col-sm-3 -->
                        <div class="col-sm-9">
                            {$Image.setWidth(848)}
                        </div><!-- /.col-sm-9 -->
                        <% else %>
                        <div class="col-sm-12">
                            {$Image.setWidth(1140)}
                        </div><!-- /.col-sm-12 -->
                        <div class="col-sm-12">
                            <aside class="typography caption-full">
                                {$Content}
                            </aside><!-- /.typography caption-full -->
                        </div><!-- /.col-sm-12 -->
                        <% end_if %>
                    </div><!-- /.row -->
                <% else %>
                    {$Image.setWidth(1140)}
                <% end_if %>
                </div><!-- /.item -->
                <% end_loop %>
            </div><!-- /.loop -->
        </section><!-- /.portfolio section -->
    <% end_if %>
</div><!-- /.container -->
<% include PreviousNextPage %>