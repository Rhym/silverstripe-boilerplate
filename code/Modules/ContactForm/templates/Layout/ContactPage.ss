<% include PageHeader %>

<div class="container">
    <div class="row">
        <section class="sidebar col-sm-3">
            <aside class="sidebar-nav widget">
                <ul class="contact-info">
                    <% if $SiteConfig.Phone %><li>{$SiteConfig.Phone}</li><% end_if %>
                    <% if $SiteConfig.Email %><li><a href="mailto:{$SiteConfig.Email}">{$SiteConfig.Email}</a></li><% end_if %>
                    <% if $SiteConfig.Address %><li>{$SiteConfig.Address}</li><% end_if %>
                </ul><!-- /.contact-info -->
            </aside><!-- /.sidebar-nav -->
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

<% include PageItems %>