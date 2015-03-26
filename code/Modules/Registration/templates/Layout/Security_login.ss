<% include PageHeader %>

<div class="container">
    <% include Content %>
    <div class="member-links">
        <% if $CurrentMember %>
        <% with $CurrentMember %>
        <a id="editProfile" class="btn btn-default" href="{$Link}">Edit Profile</a>
        <% end_with %>
        <% end_if %>
    </div><!-- /.member-links -->
</div><!-- /.container -->