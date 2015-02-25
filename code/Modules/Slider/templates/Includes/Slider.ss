<% if $SliderItems && $HideDefaultSlider !=1 %>
    <section id="slider">
        <% if $FullWidth %><% else %><div class="container"><% end_if %>
            <div class="carousel owl-carousel<% if $FullWidth %> full-width<% end_if %>">
                <% loop $SliderItems %>
                    <div class="item {$FirstLast}"<% if $Top.FullWidth %> style="max-height: {$Top.SliderHeight}px"<% end_if %>>
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
                                    <div class="typography<% if $ColorScheme %> light<% end_if %>">
                                        {$Caption}
                                    </div><!-- /.typography -->
                                </div><!-- /.caption -->
                            <% end_if %>
                        <% if $FormattedLink %></a><% end_if %>
                    </div><!-- /.item -->
                <% end_loop %>
                <%--<% if $SliderItems.Count > 1 %>--%>
                    <%--<ol class="carousel-indicators">--%>
                        <%--<% loop $SliderItems %>--%>
                            <%--<li data-target="#pageSlider" data-slide-to="{$Pos(0)}" class="<% if $First %> active<% end_if %>"></li>--%>
                        <%--<% end_loop %>--%>
                    <%--</ol>--%>
                    <%--<div class="hidden-xs">--%>
                        <%--<a class="left carousel-control" href="#pageSlider" data-slide="prev">--%>
                            <%--<span class="fa fa-angle-left"></span>--%>
                        <%--</a><!-- /.left carousel-control -->--%>
                        <%--<a class="right carousel-control icon-prev" href="#pageSlider" data-slide="next">--%>
                            <%--<span class="fa fa-angle-right"></span>--%>
                        <%--</a><!-- /.right carousel-control icon-prev -->--%>
                    <%--</div><!-- /.hidden-xs -->--%>
                <%--<% end_if %>--%>
            </div><!-- /.carousel -->
        <% if $FullWidth %><% else %></div><!-- /.container --><% end_if %>
        <%--<% if $SliderItems.Count > 1 %>--%>
            <%--<section class="mobile-slider-controls visible-xs">--%>
                <%--<div class="container">--%>
                    <%--<a href="#pageSlider" data-slide="prev">--%>
                        <%--<span class="fa fa-angle-left"></span>--%>
                    <%--</a>--%>
                    <%--<a href="#pageSlider" data-slide="next">--%>
                        <%--<span class="fa fa-angle-right"></span>--%>
                    <%--</a>--%>
                <%--</div><!-- /.container -->--%>
            <%--</section><!-- /.mobile-slider-controls visible-xs -->--%>
        <%--<% end_if %>--%>
    </section><!-- /#slider -->
<% else_if $SiteConfig.SliderImage && $HideDefaultSlider !=1 %>
    <section id="sliderContainer" class="default">
        <div id="pageSlider" class="carousel slide full-width">
            <div class="carousel-inner">
                <div class="item active"<% if $SiteConfig.DefaultSliderHeight %> style="max-height: {$SiteConfig.DefaultSliderHeight}px"<% end_if %>>
                    {$SiteConfig.SliderImage}
                </div><!-- /.item -->
            </div><!-- /.carousel-inner -->
        </div><!-- /#pageSlider .carousel slide -->
    </section><!-- /#sliderContainer -->
<% end_if %>