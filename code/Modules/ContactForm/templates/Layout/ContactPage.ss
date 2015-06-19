<% include Page_Header %>

<div class="container">
    <div class="row">
        <section class="page__sidebar">
            <aside class="page__sidebar__content">
                <ul class="navigation">
                    <% with $SiteConfig %>
                        <% if $Phone %><li class="navigation__item navigation__item--phone">{$Phone}</li><% end_if %>
                        <% if $Email %><li class="navigation__item navigation__item--email"><a href="mailto:{$Email}">{$Email}</a></li><% end_if %>
                        <% if $Address %><li class="navigation__item navigation__item--address">{$Address}</li><% end_if %>
                    <% end_with %>
                </ul><!-- /.navigation -->
            </aside><!-- /.page__sidebar__content -->
        </section><!-- /.sidebar -->
        <div class="page__content has-sidebar">
            <h1 class="page__content__heading">{$Title}</h1><!-- /.page__content__heading -->
            <% include Content %>
            <% if $MailTo %>
                {$ContactForm}
            <% else %>
                <div class="alert--warning">
                    Please choose an email address for the contact page to send to.
                </div><!-- /.alert--warning -->
            <% end_if %>
            <% if $Latitude && $Longitude %>
                <div id="map-canvas" class="page__content__map"></div><!-- /#map-canvas .page__content__map -->
            <% end_if %>
        </div><!-- /.page__content has-sidebar -->
    </div><!-- /.row -->
</div><!-- /.container -->