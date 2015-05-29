<% if $FlashMessage %>
    <div class="container">
        <div class="alert--{$FlashMessageType}">
            {$FlashMessage}
        </div><!-- /.alert--{$FlashMessageType} -->
    </div><!-- /.container -->
<% end_if %>