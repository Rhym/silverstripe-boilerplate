<% include PageHeader %>
<% cached $LastEdited %>
    <section class="gallery">
        <div class="container">
        <% if $Images %>
            <div class="gallery__item">
                <div class="owl-carousel carousel">
                    <% loop $Images %>
                        <div>
                            <img src="{$CroppedImage(1140, 641).Link}" alt="{$Name}" title="{$Name}" />
                        </div>
                    <% end_loop %>
                </div><!-- /.owl-carousel carousel -->
            </div><!-- /.gallery__item -->
        <% end_if %>
        </div><!-- /.container -->
    </section><!-- /.gallery -->
<% end_cached %>

<% include Page_Content %>