<nav class="header" role="navigation">
    <div class="container">
        <div class="row">
            <div class="header__item header__item--logo">
                <% if $SiteConfig.LogoImage %>
                    <div class="header__item__logo"><a href="{$BaseHref}" rel="home">{$SiteConfig.LogoImage}</a></div><!-- /.header__item__logo -->
                <% else %>
                    <% if $SiteConfig.Title %><h2 class="header__item__heading"><a href="{$BaseHref}" rel="home">{$SiteConfig.Title}</a></h2><!-- /.header__item__heading --><% end_if %>
                <% end_if %>
            </div><!-- /.header__item -->
            <div class="header__item header__item--navigation">
                <% include Menu %>
            </div><!-- /.header__item -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</nav><!-- /.header -->