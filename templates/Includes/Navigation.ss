<ul>
    <% loop $Menu(1) %>
        <% if $Children %>
            <li class="{$LinkingMode} dropdown {$EvenOdd} {$FirstLast}">
                <a href="{$Link}" title="{$Title.XML}" class="visible-lg">{$MenuTitle.XML}</a>
                <ul class="dropdown-menu">
                    <% loop $Children %>
                        <li class="{$LinkingMode} {$EvenOdd} {$FirstLast}"><a href="{$Link}" title="{$Title.XML}">{$MenuTitle.XML}</a></li>
                    <% end_loop %>
                </ul><!-- /.dropdown-menu -->
            </li><!-- /.dropdown -->
        <% else %>
            <li class="{$LinkingMode} {$EvenOdd} {$FirstLast}"><a href="{$Link}" title="{$Title.XML}">{$MenuTitle.XML}</a></li>
        <% end_if %>
    <% end_loop %>
    <%--<% if $SiteConfig.Phone %><li class="phone"><a href="tel:{$SiteConfig.Phone}">{$SiteConfig.Phone}</a></li><% end_if %>--%>
    <% if $SearchForm %>
        <li><a href="{$Link}SearchForm?Search" class="btn btn-link"><i class="fa fa-search"></i></a></li>
    <% end_if %>
    <li class="phone"><a href="tel:{$SiteConfig.Phone}" class="menu-icon"><i class="icon fa fa-phone"></i><span class="text">Phone</span></a><!-- /.phone --></li>
    <li class="hamburger-menu"><button class="menu-icon toggle-menu"><i class="icon fa fa-bars"></i><span class="text">Menu</span></button><!-- /.menu-icon --></li>
</ul>