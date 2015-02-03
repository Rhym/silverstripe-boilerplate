<div class="menu-wrap">
    <div class="container">
        <button class="menu-icon toggle-menu"><i class="fa fa-times"></i></button><!-- /.menu-icon -->
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
</div><!-- /.menu-wrap -->