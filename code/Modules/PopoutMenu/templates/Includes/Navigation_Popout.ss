<% cache 'PopoutMenuCache' %>
    <div class="modal" id="popout_menu" tabindex="-1" role="dialog">
        <div class="modal__dialog menu-wrap" role="document">
            <div class="modal__dialog__content">
                <header class="header">
                    <div class="container">
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
                            </div><!-- /.header__item -->
                            <div class="header__item header__item--navigation">
                                <ul class="menu">
                                    <li class="menu__item menu__item--icon menu__item--close"><button class="menu__item__icon menu__item__icon--menu" data-dismiss="modal" data-role="button">{$SVG('cross').extraClass('menu__item__icon__icon')}<span class="menu__item__icon__text">Close</span></button><!-- /.menu-icon --></li>
                                </ul><!-- /.menu -->
                            </div><!-- /.header__item -->
                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </header><!-- /.menu-wrap__header -->
                <div class="container">
                    <ul class="menu-wrap__menu">
                        <% loop $Menu(1) %>
                            <li class="menu-wrap__menu__item is-{$LinkingMode} is-{$EvenOdd}<% if $FirstLast %> is-{$FirstLast}<% end_if %>">
                                <a href="{$Link}" class="menu-wrap__menu__item__link" title="{$Title.XML}">{$MenuTitle.XML}</a>
                                <% if $Children %>
                                    <div class="menu-wrap__menu__item__icon open-children" data-target="#child_{$Pos}">{$SVG('chevron-down').extraClass('menu-wrap__menu__item__icon__icon')}</div><!-- /.menu-wrap__menu__item__icon -->
                                    <ul id="child_{$Pos}" class="menu-wrap__menu__item__list">
                                        <% loop $Children %>
                                            <li class="menu-wrap__menu__item__list__item is-{$EvenOdd}<% if $FirstLast %> is-{$FirstLast}<% end_if %>"><a href="{$Link}" class="menu-wrap__menu__item__list__item__link" title="{$Title.XML}">{$MenuTitle.XML}</a></li><!-- /.menu-wrap__menu__item__list__item -->
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
            </div><!-- /.modal__dialog__content -->
        </div><!-- /.modal__dialog menu-wrap -->
    </div><!-- /.modal -->
<% end_cache %>
