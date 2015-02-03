<div class="<% if $Animated %>animated <% end_if %>column {$Size}"<% if $Animated %> data-animation="{$Animated}"<% end_if %>>
    <article class="item slider {$EvenOdd} {$FirstLast}">
        <div class="inner">
            <div id="carousel_{$ID}" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <% loop $SliderImages %>
                        <div class="item $FirstLast<%if $First %> active<% end_if %>">
                            <img src="{$Link}" alt="{$Title.XML}" />
                        </div><!-- /.item -->
                    <% end_loop %>
                </div><!-- /.carousel-inner -->
                <% if $SliderImages.Count > 1 %>
                    <ol class="carousel-indicators">
                        <% loop $SliderImages %>
                            <li data-target="#carousel_{$Up.ID}" data-slide-to="{$Pos(0)}" class="<% if $First %> active<% end_if %>"></li>
                        <% end_loop %>
                    </ol>
                <% end_if %>
            </div><!-- /.carousel slide -->
        </div><!-- /.inner -->
    </article><!-- /.item slider -->
</div><!-- /.column {$Size} -->
<% if $ClearRow %><div class="clearfix"></div><% end_if %>