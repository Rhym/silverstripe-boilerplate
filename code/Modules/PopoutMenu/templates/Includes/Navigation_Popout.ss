<nav class="menu-wrap" tabindex="-1">
    <div class="container">
        <header class="header">
            <div class="row">
                <div class="header__item header__item--logo">
                    <div class="header__item__logo">
                        <% if $SiteConfig.LogoImage || $SiteConfig.MobileLogoImage %>
                            <a href="{$BaseHref}">
                                <% if $SiteConfig.MobileLogoImage %>
                                    {$SiteConfig.MobileLogoImage}
                                <% else %>
                                    {$SiteConfig.LogoImage}
                                <% end_if %>
                            </a>
                        <% end_if %>
                    </div><!-- /.header__item__logo -->
                </div><!-- /.header__item header__item--logo -->
                <div class="header__item header__item--navigation">
                    <ul class="menu">
                        <li class="menu__item menu__item--icon"><button class="menu__item__icon menu__item__icon--menu toggle-menu"><i class="menu__item__icon__icon fa fa-times"></i><span class="menu__item__icon__text">Close</span></button><!-- /.menu-icon --></li>
                    </ul><!-- /.menu -->
                </div><!-- /.header__item header__item--navigation -->
            </div><!-- /.row -->
        </header><!-- /.menu-wrap__header -->
        <ul class="menu-wrap__menu">
            <% loop $Menu(1) %>
                <li class="menu-wrap__menu__item menu-wrap__menu__item--{$LinkingMode} menu-wrap__menu__item--{$EvenOdd}<% if $FirstLast %> menu-wrap__menu__item--{$FirstLast}<% end_if %>">
                    <a href="{$Link}" class="menu-wrap__menu__item__link" title="{$Title.XML}">{$MenuTitle.XML}</a>
                    <% if $Children %>
                        <div class="menu-wrap__menu__item__icon open-children" data-target="#child_{$Pos}"><i class="fa fa-caret-down"></i></div><!-- /.menu-wrap__menu__item__icon -->
                        <ul id="child_{$Pos}" class="menu-wrap__menu__item__list">
                            <% loop $Children %>
                                <li class="menu-wrap__menu__item__list__item"><a href="{$Link}" class="menu-wrap__menu__item__list__item__link" title="{$Title.XML}">{$MenuTitle.XML}</a></li><!-- /.menu-wrap__menu__item__list__item -->
                            <% end_loop %>
                        </ul><!-- /.menu-wrap__menu__item__list -->
                    <% end_if %>
                </li><!-- /.menu-wrap__menu__item -->
            <% end_loop %>
        </ul><!-- /.menu-wrap__menu -->
        <% if $SearchForm %>
            <div class="menu-wrap__search">
                {$SearchForm}
            </div><!-- /.menu-wrap__search -->
        <% end_if %>
    </div><!-- /.container -->
</nav><!-- /.menu-wrap -->