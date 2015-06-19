<% include Page_Header %>

<div class="container">
    <div class="row">
        <div class="page__content">
            <div class="error">
                <% if $ErrorCode %><h1 class="error__heading">{$ErrorCode}</h1><% end_if %>
                <% include Content %>
            </div><!-- /.error -->
        </div><!-- /.page_content has-sidebar -->
    </div><!-- /.row -->
</div><!-- /.container -->