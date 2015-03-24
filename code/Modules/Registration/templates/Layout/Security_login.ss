<% include PageHeader %>

<div class="container">
    <% include Content %>
    <div class="member-links">
        <% if $CurrentMember %>
            <% with $CurrentMember %>
                <a id="editProfile" class="btn btn-default" href="{$Link}"><%t SecurityLogin.EditLink 'Edit Profile' %></a>
            <% end_with %>
        <% else %>
            <a href="{$Page(register).Link}"><%t SecurityLogin.RegisterLink 'Register' %></a>
        <% end_if %>
    </div><!-- /.member-links -->
</div><!-- /.container -->