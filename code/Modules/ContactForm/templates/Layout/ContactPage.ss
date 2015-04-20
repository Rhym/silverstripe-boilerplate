<% include PageHeader %>

<div class="container">
    <div class="row">
        <section class="sidebar col-sm-3">
            <aside class="navigation">
                <ul class="contact-info">
                    <% with $SiteConfig %>
                    <% if $Phone %><li>{$Phone}</li><% end_if %>
                    <% if $Email %><li><a href="mailto:{$Email}">{$Email}</a></li><% end_if %>
                    <% if $Address %><li>{$Address}</li><% end_if %>
                    <% end_with %>
                </ul><!-- /.contact-info -->
            </aside><!-- /.navigation -->
        </section><!-- /.sidebar col-sm-3 -->
        <div class="col-sm-9">
            <% include Content %>
            <% if $MailTo %>
            {$ContactForm}
            <% else %>
            <div class="alert alert-warning">
                <%t ContactPage.NoEmailAlert "Please choose an email address for the contact page to send to." %>
            </div><!-- /.alert alert-warning -->
            <% end_if %>
            <% if $Latitude && $Longitude %>
            <div id="map-canvas"></div><!-- /#map-canvas -->
            <% end_if %>
        </div><!-- /.col-sm-9 -->
    </div><!-- /.row -->
</div><!-- /.container -->