<nav id="header" role="navigation">
    <div class="container">
        <div class="row">
            <div id="logo" class="col-xs-6 col-sm-3">
                <% if $SiteConfig.LogoImage %>
                    <a href="{$BaseHref}" rel="home">{$SiteConfig.LogoImage}</a>
                <% else %>
                    <% if $SiteConfig.Title %><h2 class="heading"><a href="{$BaseHref}" rel="home">{$SiteConfig.Title}</a></h2><!-- /.heading --><% end_if %>
                    <% if $SiteConfig.Tagline %><h3 class="tagline">{$SiteConfig.Tagline}</h3><!-- /.tagline --><% end_if %>
                <% end_if %>
            </div><!-- /#logoContainer .col-xs-6 col-sm-3 -->
            <div id="navigation" class="col-xs-6 col-sm-9">
                <% include Navigation %>
            </div><!-- /#navigationContainer .col-xs-6 col-sm-9 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</nav><!-- /.header -->