<ul class="social-icons">
    <% if $SiteConfig.Facebook %><li class="facebook"><a href="{$SiteConfig.Facebook}" target="_blank" title="{$SiteConfig.Title} on Facebook"><i class="fa fa-facebook"></i></a></li><% end_if %>
    <% if $SiteConfig.Twitter %><li class="twitter"><a href="{$SiteConfig.Twitter}" target="_blank" title="{$SiteConfig.Title} on Twitter"><i class="fa fa-twitter"></i></a></li><% end_if %>
    <% if $SiteConfig.Youtube %><li class="youtube"><a href="{$SiteConfig.Youtube}" target="_blank" title="{$SiteConfig.Title} on Youtube"><i class="fa fa-youtube"></i></a></li><% end_if %>
    <% if $SiteConfig.GooglePlus %><li class="google-plus"><a href="{$SiteConfig.GooglePlus}" target="_blank" title="{$SiteConfig.Title} on Google+"><i class="fa fa-google-plus"></i></a></li><% end_if %>
</ul><!-- /.social-icons -->