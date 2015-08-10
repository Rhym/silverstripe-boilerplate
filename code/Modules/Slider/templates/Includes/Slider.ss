<% cache 'SliderCache' %>
    <% if $SliderItems && $HideDefaultSlider !=1 %>
        <section class="slider<% if $SliderItems.Count > 1 %> slider--multiple<% else %> slider--default<% end_if %>">
            <div class="carousel-container">
                <div class="carousel<% if $SliderItems.Count > 1 %> carousel--multiple<% else %> carousel--single<% end_if %> owl-carousel">
                    <% loop $SliderItems %>
                        <div class="carousel__item is-{$EvenOdd}<% if $FirstLast %> is-{$FirstLast}<% end_if %>"<% if $Top.SliderHeight > 0 %> style="max-height: {$Top.SliderHeight}px"<% end_if %>>
                            <% if $Top.SliderHeight %>
                                {$Image.croppedImage(1600, $Top.SliderHeight).SrcSet}
                            <% else %>
                                {$Image.setWidth(1600).SrcSet}
                            <% end_if %>
                            <% if $Caption %>
                                <div class="carousel__item__caption typography">
                                    {$Caption}
                                </div><!-- /.carousel__item__caption -->
                            <% end_if %>
                        </div><!-- /.carousel__item -->
                    <% end_loop %>
                </div><!-- /.carousel owl-carousel -->
                <div class="carousel-navigation">
                    <div class="carousel-navigation__item carousel-navigation__item--prev">{$SVG('chevron-left').extraClass('carousel-navigation__item__icon')}</div><!-- /.carousel-navigation__item -->
                    <div class="carousel-navigation__item carousel-navigation__item--next next">{$SVG('chevron-right').extraClass('carousel-navigation__item__icon')}</div><!-- /.carousel-navigation__item -->
                </div><!-- /.carousel-navigation -->
            </div><!-- /.carousel-container -->
        </section><!-- /.slider -->
    <% else_if $SiteConfig.SliderImage && $HideDefaultSlider !=1 %>
        <section class="slider slider--default">
            <div class="carousel carousel--single owl-carousel">
                <div class="carousel__item"<% if $SiteConfig.DefaultSliderHeight > 0 %> style="max-height: {$SiteConfig.DefaultSliderHeight}px"<% end_if %>>
                    {$SiteConfig.SliderImage.SrcSet}
                </div><!-- /.carousel__item -->
            </div><!-- /.carousel owl-carousel -->
        </section><!-- /.slider -->
    <% end_if %>
<% end_cache %>
