<!DOCTYPE html>
<html class="no-js" lang="{$ContentLocale}">
<head>
    <% include Header_Meta %>
    <link rel="stylesheet" type="text/css" href="{$BaseHref}/{$Project}/css/main.css" />
</head>
<body class="{$ClassName} {$SliderClass}" id="{$URLSegment}">
    {$TrackingCodeTop.RAW}
    <div id="wrapper">
        <div class="content-wrap">
            <div class="page">
                <div class="container">
                    <div class="row">
                        <div class="security">
                            <div class="security__content">
                                <div class="security__content__logo">
                                    <% if $SiteConfig.LogoImage %>
                                        <a href="{$BaseHref}" rel="home">{$SiteConfig.LogoImage}</a>
                                    <% else %>
                                        <% if $SiteConfig.Title %><h2 class="security__content__logo__heading"><a href="{$BaseHref}" rel="home">{$SiteConfig.Title}</a></h2><!-- /.security__content__logo__heading --><% end_if %>
                                    <% end_if %>
                                </div><!-- /.security__content__logo -->
                                <% include Content %>
                            </div><!-- /.security__content -->
                        </div><!-- /.security -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.page -->
        </div><!-- /.content-wrap -->
    </div><!-- /#wrapper -->
    {$TrackingCodeBottom.RAW}
</body>
</html>
