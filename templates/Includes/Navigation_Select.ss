<% if $SearchForm %>
    <a href="{$Link}SearchForm?Search" class="btn-secondary navbar-btn menu-icon search"><i class="fa fa-search"></i></a>
<% end_if %>
<select class="input-sm" onchange="document.location.href=this.options[this.selectedIndex].value;">
    <% loop $Menu(1) %>
        <% if $Children %>
            <option value="{$Link}">{$MenuTitle.XML}</option>
            <% loop $Children %>
                <% if $LinkOrCurrent = current %>
                    <option selected value="{$Link}">- {$MenuTitle.XML}</option>
                <% else %>
                    <option value="{$Link}">- {$MenuTitle.XML}</option>
                <% end_if %>
            <% end_loop %>
        <% else %>
            <% if $LinkOrCurrent = current %>
                <option selected value="{$Link}">{$MenuTitle.XML}</option>
            <% else %>
                <option value="{$Link}">{$MenuTitle.XML}</option>
            <% end_if %>
        <% end_if %>
    <% end_loop %>
</select><!-- /.input-sm -->