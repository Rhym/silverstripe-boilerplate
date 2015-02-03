<% if $PageItems %>
    <section class="page-item loop">
        <div class="container">
            <div class="row">
                <% loop $PageItems %>
                    {$Render}
                <% end_loop %>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.page-item loop -->
<% end_if %>