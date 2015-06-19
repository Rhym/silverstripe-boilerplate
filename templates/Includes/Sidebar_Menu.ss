<% if $Children %>
    <% loop $Children %>
        <li class="navigation__item navigation__item--{$LinkingMode}">
            <a href="$Link" class="navigation__item__link navigation__item__link--{$LinkingMode}" title="{$Title.XML}">
                {$MenuTitle.XML}
            </a><!-- /.navigation__item__link -->
            <% if $Children %>
            <ul class="navigation">
                <% include Sidebar_Menu %>
            </ul><!-- /.navigation -->
            <% end_if %>
        </li><!-- /.navigation__item -->
    <% end_loop %>
<% end_if %>