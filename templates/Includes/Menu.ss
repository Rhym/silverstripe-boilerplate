<ul class="menu">
    <% loop $Menu(1) %>
        <% if $Children %>
            <li class="menu__item menu__item--dropdown menu__item--{$LinkingMode} menu__item--{$EvenOdd}<% if $FirstLast %> menu__item--{$FirstLast}<% end_if %>">
                <a href="{$Link}" class="menu__item__link" title="{$Title.XML}">{$MenuTitle.XML}</a>
                <ul class="menu__item__dropdown-menu">
                    <% loop $Children %>
                        <li class="menu__item__dropdown-menu__item menu__item__dropdown-menu__item--{$LinkingMode} menu__item__dropdown-menu__item--{$EvenOdd}<% if $FirstLast %> menu__item__dropdown-menu__item--{$FirstLast}<% end_if %>"><a href="{$Link}" class="menu__item__dropdown-menu__item__link" title="{$Title.XML}">{$MenuTitle.XML}</a></li>
                    <% end_loop %>
                </ul><!-- /.navigation__item__dropdown-menu -->
            </li><!-- /.navigation__item -->
        <% else %>
            <li class="menu__item menu__item--{$LinkingMode} menu__item--{$EvenOdd}<% if $FirstLast %> menu__item--{$FirstLast}<% end_if %>"><a href="{$Link}" class="menu__item__link" title="{$Title.XML}">{$MenuTitle.XML}</a></li>
        <% end_if %>
    <% end_loop %>
    <% if $SiteConfig.Phone %><li class="menu__item menu__item--icon"><a href="tel:{$SiteConfig.Phone}" class="menu__item__icon menu__item__icon--phone"><i class="menu__item__icon__icon fa fa-phone"></i><span class="menu__item__icon__text">Phone</span></a></li><% end_if %>
    <li class="menu__item menu__item--icon"><button class="menu__item__icon menu__item__icon--menu toggle-menu"><i class="menu__item__icon__icon fa fa-bars"></i><span class="menu__item__icon__text">Menu</span></button></li>
</ul>