<nav class="navbar navbar-default" role="navigation">
    <ul class="nav navbar-nav pull-right visible-lg">
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
    </ul><!-- /.nav navbar-nav pull-right hidden-xs -->
    <div class="select-overlay hidden-lg">
        <button class="menu-icon toggle-menu btn-secondary"><i class="fa fa-bars"></i></button><!-- /.menu-icon -->
        <%--<% include Navigation_Select %>--%>
        <div class="clearfix"></div><!-- /.clearfix -->
    </div><!-- /.select-overlay hidden-lg -->
</nav><!-- /.navbar navbar-default -->