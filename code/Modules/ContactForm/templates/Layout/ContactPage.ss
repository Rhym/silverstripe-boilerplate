<% include Page_Header %>

<div class="contact">
    <div class="container">
        <% cache 'ContactPageCache' %>
            <div class="contact__details">
                <div class="contact__details__item contact__details__item--content">
                    <h3 class="contact__details__item__heading">{$Title}</h3>
                    <% with $SiteConfig %>
                        <dl class="details">
                            <% if $Phone %>
                                <%--<dt class="details__title"><% _t('ContactPage.PHONE','Phone') %></dt><!-- /.details__title -->--%>
                                <dd class="details__detail">{$Phone}</dd><!-- /.details__detail -->
                            <% end_if %>
                            <% if $Email %>
                                <%--<dt class="details__title"><% _t('ContactPage.EMAIL','Email') %></dt><!-- /.details__title -->--%>
                                <dd class="details__detail"><a href="mailto:{$Email}">{$Email}</a></dd><!-- /.details__detail -->
                            <% end_if %>
                            <% if $Address %>
                                <dt class="details__title"><% _t('ContactPage.PHYSICALADDRESS','Physical Address') %></dt><!-- /.details__title -->
                                <dd class="details__detail">{$Address}</dd><!-- /.details__detail -->
                            <% end_if %>
                            <% if $PostalAddress %>
                                <dt class="details__title"><% _t('ContactPage.POSTALADDRESS','Postal Address') %></dt><!-- /.details__title -->
                                <dd class="details__detail">{$PostalAddress}</dd><!-- /.details__detail -->
                            <% end_if %>
                        </dl><!-- /.details -->
                        <% if $Directions %>
                            <a href="{$Directions}" target="_blank" rel="nofollow"><% _t('ContactPage.DIRECTIONS','Get Directions') %></a>
                        <% end_if %>
                    <% end_with %>
                </div><!-- /.contact__details__item -->
                <div class="contact__details__item contact__details__item--map">
                    <% if $Latitude && $Longitude %>
                        <div id="map-canvas" class="contact__details__item__map"></div><!-- /#map-canvas .page__content__map -->
                    <% end_if %>
                </div><!-- /.contact__details__item -->
            </div><!-- /.contact__details -->
        <% end_cache %>
        <div class="contact__form">
            <div class="contact__form__item contact__form__item--content">
                <% include Content %>
            </div><!-- /.contact__form__item -->
            <div class="contact__form__item contact__form__item--form">
                <% if $MailTo %>
                    {$ContactForm}
                <% else %>
                    <div class="alert--warning">
                        <% _t('ContactPage.NOEMAIL','Please choose an email address for the contact page to send to.') %>
                    </div><!-- /.alert--warning -->
                <% end_if %>
            </div><!-- /.contact__form__item -->
        </div><!-- /.contact__form -->
    </div><!-- /.container -->
</div><!-- /.contact -->
