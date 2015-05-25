<nav class="menu-wrap">
    <div class="container">
        <header class="header">
            <div class="row">
                <div class="left col-xs-6 col-sm-3">
                    <div class="logo">
                        <% if $SiteConfig.LogoImage || $SiteConfig.MobileLogoImage %>
                            <a href="{$BaseHref}">
                                <% if $SiteConfig.MobileLogoImage %>
                                    {$SiteConfig.MobileLogoImage}
                                <% else %>
                                    {$SiteConfig.LogoImage}
                                <% end_if %>
                            </a>
                        <% end_if %>
                    </div><!-- /.logo -->
                </div><!-- /.left col-xs-6 col-sm-3 -->
                <div class="right col-xs-6 col-sm-9">
                    <ul>
                        <li class="hamburger-menu"><button class="menu-icon toggle-menu"><i class="icon fa fa-times"></i><span class="text">Close</span></button><!-- /.menu-icon --></li>
                    </ul>
                </div><!-- /.right col-xs-6 col-sm-9 -->
            </div><!-- /.row -->
        </header><!-- /.header -->
        <nav class="menu">
            <ul>
                <% loop $Menu(1) %>
                    <li class="parent {$LinkingMode} {$EvenOdd} {$FirstLast}">
                        <a href="{$Link}" title="{$Title.XML}">{$MenuTitle.XML}</a>
                        <% if $Children %>
                            <div class="open-children" data-target="#child_{$Pos}"><i class="fa fa-caret-down"></i></div><!-- /.open -->
                            <ul id="child_{$Pos}" class="children">
                                <% loop $Children %>
                                    <li><a href="{$Link}" title="{$Title.XML}">{$MenuTitle.XML}</a></li>
                                <% end_loop %>
                            </ul><!-- /.children -->
                        <% end_if %>
                    </li>
                <% end_loop %>
            </ul>
        </nav><!-- /.menu -->
        <% if $SearchForm %>
            <div class="search">
                {$SearchForm}
            </div><!-- /.search -->
        <% end_if %>
    </div><!-- /.container -->
</nav><!-- /.menu-wrap -->