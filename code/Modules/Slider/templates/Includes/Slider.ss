<% if $SliderItems && $HideDefaultSlider !=1 %>
<section id="slider"<% if $SliderItems.Count > 1 %> class="has-multiple-items"<% end_if %>>
    <% if $FullWidth %><% else %><div class="container"><% end_if %>
        <div class="carousel owl-carousel<% if $FullWidth %> full-width<% end_if %>">
            <% loop $SliderItems %>
                <div class="item {$FirstLast}"<% if $Top.FullWidth > 0 %> style="max-height: {$Top.SliderHeight}px"<% end_if %>>
                    <% if $FormattedLink %><a href="{$FormattedLink}"><% end_if %>
                        <% if $Top.FullWidth %>
                            {$Image}
                        <% else %>
                            <% if $Top.SliderHeight %>
                                {$Image.croppedImage(1140, $Top.SliderHeight)}
                            <% else %>
                                {$Image.croppedImage(1140, 500)}
                            <% end_if %>
                        <% end_if %>
                        <% if $Caption %>
                            <div class="caption">
                                <div class="typography">
                                    {$Caption}
                                </div><!-- /.typography -->
                            </div><!-- /.caption -->
                        <% end_if %>
                    <% if $FormattedLink %></a><% end_if %>
                </div><!-- /.item -->
            <% end_loop %>
        </div><!-- /.carousel -->
    <% if $FullWidth %><% else %></div><!-- /.container --><% end_if %>
</section><!-- /#slider -->
<% else_if $SiteConfig.SliderImage && $HideDefaultSlider !=1 %>
<section id="slider" class="default-banner">
    <% if $FullWidth %><% else %><div class="container"><% end_if %>
    <div class="carousel owl-carousel<% if $FullWidth %> full-width<% end_if %>">
        <div class="item"<% if $SiteConfig.DefaultSliderHeight > 0 %> style="max-height: {$SiteConfig.DefaultSliderHeight}px"<% end_if %>>
            {$SiteConfig.SliderImage}
        </div><!-- /.item -->
    </div><!-- /.carousel -->
    <% if $FullWidth %><% else %></div><!-- /.container --><% end_if %>
</section><!-- /#slider .default-banner -->
<% end_if %>