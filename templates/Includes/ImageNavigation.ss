<% if $ImageNavigation %>
    <% with $ImageNavigation %>
        <section class="image-navigation">
            <div class="container">
                <a href="{$Link}" title="{$Title}">
                    <h4 class="heading">{$MenuTitle.XML}</h4><!-- /.heading -->
                    <div class="image">
                        <img src="{$Image.CroppedImage(1140, 300).URL}" alt="{$Image.Name}"/>
                    </div><!-- /.image -->
                </a>
                <i class="fa fa-chevron-down icon"></i>
            </div><!-- /.container -->
        </section><!-- /.image-navigation -->
    <% end_with %>
<% end_if %>