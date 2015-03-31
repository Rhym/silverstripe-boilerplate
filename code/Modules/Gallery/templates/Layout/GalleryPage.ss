<% include PageHeader %>
<% cached $LastEdited %>
<div class="container">
    <% if $Images %>
        <section class="gallery loop<% if $NoMargin %> no-margin<% end_if %>">
            <div class="owl-carousel show-nav">
            <% loop $Images %>
                <div>
                <figure class="item {$FirstLast}">
                    <img src="{$CroppedImage(1140, 641).Link}" alt="{$Name}" title="{$Name}" />
                </figure><!-- /.item col-xs-6 col-sm-3 -->
                </div>
            <% end_loop %>
            </div><!-- /.owl-carousel -->
        </section><!-- /.gallery loop -->
    <% end_if %>
    <% include Content %>
</div><!-- /.container -->
<% end_cached %>