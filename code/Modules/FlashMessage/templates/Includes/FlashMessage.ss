<% if $FlashMessage %>
    <div class="container">
        <div class="alert alert-{$FlashMessageType}">
            <% if $FlashMessageType == success %>
                <i class="fa fa-check-circle"></i> 
            <% end_if %>
            <% if $FlashMessageType == warning %>
                <i class="fa fa-exclamation-triangle"></i>
            <% end_if %>
            <% if $FlashMessageType == danger %>
                <i class="fa fa-exclamation-circle"></i>
            <% end_if %>
            <% if $FlashMessageType == info %>
                <i class="fa fa-question-circle"></i>
            <% end_if %>
            $FlashMessage
        </div><!-- /.alert -->
    </div><!-- /.container -->
<% end_if %>