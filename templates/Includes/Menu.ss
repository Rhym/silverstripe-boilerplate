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
            <li class="menu__item menu__item--{$LinkingMode} menu__item--{$EvenOdd}<% if $FirstLast %> menu__item--{$FirstLast}<% end_if %>">
                <a href="{$Link}" class="menu__item__link" title="{$Title.XML}">{$MenuTitle.XML}</a>
            </li><!-- /.menu__item -->
        <% end_if %>
    <% end_loop %>
    <% if $SiteConfig.FormattedPhone %>
        <li class="menu__item menu__item--icon">
            <a href="tel:{$SiteConfig.FormattedPhone}" class="menu__item__icon menu__item__icon--phone">
                {$SVG('phone-handset').extraClass('menu__item__icon__icon')}
                <span class="menu__item__icon__text">Phone</span>
            </a>
        </li><!-- /.menu__item -->
    <% end_if %>
    <li class="menu__item menu__item--icon">
        <button class="menu__item__icon menu__item__icon--menu toggle-menu">
            {$SVG('menu').extraClass('menu__item__icon__icon')}
            <span class="menu__item__icon__text">Menu</span>
        </button>
    </li><!-- /.menu__item -->
</ul><!-- /.menu -->