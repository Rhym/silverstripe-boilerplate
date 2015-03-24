<% if $FlashMessage %>
    <div class="container">
        <div class="alert alert-{$FlashMessageType}">
            {$FlashMessage}
        </div><!-- /.alert -->
    </div><!-- /.container -->
<% end_if %>