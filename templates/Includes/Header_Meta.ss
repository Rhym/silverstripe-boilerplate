<% cache 'HeaderMetaCache' %>
    <meta charset="utf-8">
    <title><% if $MetaTitle %>$MetaTitle<% else %>{$Title}<% end_if %> | {$SiteConfig.Title}<% if $SiteConfig.Tagline %> - {$SiteConfig.Tagline}<% end_if %></title>
    {$MetaTags(false)}
    <% base_tag %>
    <% if $SiteConfig.GoogleSiteVerification %><meta name="google-site-verification" content="{$SiteConfig.GoogleSiteVerification}" /><% end_if %>
    <meta property="og:site_name" content="$SiteConfig.Title<% if $SiteConfig.Tagline %> - {$SiteConfig.Tagline}<% end_if %>"/>
    <% if $MetaDescription %><meta property="og:description" content="{$MetaDescription}"/><% end_if %>
    <meta property="og:title" content="<% if $MetaTitle %>{$MetaTitle}<% else %>{$Title}<% end_if %>"/>
    <meta property="og:url" content="{$AbsoluteLink}" />
    <% if $SiteConfig.LogoImage %><meta property="og:image" content="{$SiteConfig.LogoImage.Link}" /><% end_if %>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <% if $ThemeColor %>{$ThemeColor}<% end_if %>
    <% if $SiteConfig.Favicon %><link rel="shortcut icon" href="{$SiteConfig.Favicon.Link}" /><% end_if %>
<% end_cache %>
