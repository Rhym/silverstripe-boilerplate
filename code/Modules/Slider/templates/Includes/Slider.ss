<% if $SliderItems && $HideDefaultSlider !=1 %>
    <section class="slider<% if $SliderItems.Count > 1 %> slider--multiple<% end_if %>">
        <div class="carousel owl-carousel">
            <% loop $SliderItems %>
                <div class="carousel__item carousel__item--{$FirstLast}"<% if $Top.SliderHeight > 0 %> style="max-height: {$Top.SliderHeight}px"<% end_if %>>
                    <% if $Top.SliderHeight %>
                        {$Image.croppedImage(1600, $Top.SliderHeight)}
                    <% else %>
                        {$Image.setWidth(1600)}
                    <% end_if %>
                    <% if $Caption %>
                        <div class="carousel__item__caption typography">
                            {$Caption}
                        </div><!-- /.carousel__item__caption -->
                    <% end_if %>
                </div><!-- /.carousel__item -->
            <% end_loop %>
        </div><!-- /.carousel owl-carousel -->
    </section><!-- /.slider -->
<% else_if $SiteConfig.SliderImage && $HideDefaultSlider !=1 %>
    <section class="slider slider--default">
        <div class="carousel owl-carousel">
            <div class="carousel__item"<% if $SiteConfig.DefaultSliderHeight > 0 %> style="max-height: {$SiteConfig.DefaultSliderHeight}px"<% end_if %>>
                {$SiteConfig.SliderImage}
            </div><!-- /.carousel__item -->
        </div><!-- /.carousel owl-carousel -->
    </section><!-- /.slider -->
<% end_if %>