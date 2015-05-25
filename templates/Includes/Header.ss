<nav id="header" role="navigation">
    <div class="container">
        <div class="row">
            <div class="left col-xs-6 col-sm-3">
                <% if $SiteConfig.LogoImage %>
                    <div class="logo"><a href="{$BaseHref}" rel="home">{$SiteConfig.LogoImage}</a></div><!-- /.logo -->
                <% else %>
                    <% if $SiteConfig.Title %><h2 class="heading"><a href="{$BaseHref}" rel="home">{$SiteConfig.Title}</a></h2><!-- /.heading --><% end_if %>
                <% end_if %>
            </div><!-- /.left col-xs-6 col-sm-3 -->
            <div class="right col-xs-6 col-sm-9">
                <% include Navigation %>
            </div><!-- /.right col-xs-6 col-sm-9 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</nav><!-- /.header -->