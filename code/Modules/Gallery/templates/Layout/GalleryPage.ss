<% include Page_Header %>

<section class="gallery">
    <div class="container">
    <% if $Images %>
        <div class="gallery__item">
            <div class="carousel-container">
                <div class="carousel<% if $Images.Count > 1 %> carousel--multiple<% else %> carousel--single<% end_if %> owl-carousel ">
                    <% loop $Images %>
                        <div class="carousel__item carousel__item--{$FirstLast}">
                            <img src="{$CroppedImage(1140, 641).Link}" alt="{$Name}" title="{$Name}" />
                        </div><!-- /.carousel__item -->
                    <% end_loop %>
                </div><!-- /.carousel owl-carousel -->
                <% if $Images.Count > 1 %>
                    <div class="carousel-navigation">
                        <div class="carousel-navigation__item carousel-navigation__item--prev">{$SVG('chevron-left').extraClass('carousel-navigation__item__icon')}</div><!-- /.carousel-navigation__item -->
                        <div class="carousel-navigation__item carousel-navigation__item--next next">{$SVG('chevron-right').extraClass('carousel-navigation__item__icon')}</div><!-- /.carousel-navigation__item -->
                    </div><!-- /.carousel-navigation -->
                <% end_if %>
            </div><!-- /.carousel-container -->
        </div><!-- /.gallery__item -->
    <% end_if %>
    </div><!-- /.container -->
</section><!-- /.gallery -->

<% include Page_Content %>