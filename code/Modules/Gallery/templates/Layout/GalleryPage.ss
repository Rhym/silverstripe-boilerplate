<% include PageHeader %>
<% cached $LastEdited %>
<div class="container">
    <article class="article article--gallery">
        <% if $Images %>
            <div class="article__image">
                <div class="owl-carousel carousel">
                    <% loop $Images %>
                        <div>
                            <img src="{$CroppedImage(1140, 641).Link}" alt="{$Name}" title="{$Name}" />
                        </div>
                    <% end_loop %>
                </div><!-- /.owl-carousel carousel -->
            </div><!-- /.article__image -->
        <% end_if %>
        <% if $Content %>
            <div class="article__content typography">
                {$Content}
            </div><!-- /.article__content typography -->
        <% end_if %>
    </article><!-- /.article article--gallery -->
</div><!-- /.container -->
<% end_cached %>