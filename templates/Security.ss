<!DOCTYPE html>
<html class="no-js" lang="{$ContentLocale}">
<head>
<% include HeaderMeta %>
<link rel="stylesheet" type="text/css" href="{$BaseHref}/{$Project}/css/main.min.css" />
</head>
<body class="{$ClassName} {$SliderClass}" id="{$URLSegment}">
    {$TrackingCodeTop.RAW}
    <div id="wrapper">
        <div class="content-wrap">
            <section id="mainContent">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <div class="form-container">
                                <div class="logo">
                                <% if $SiteConfig.LogoImage %>
                                    <a href="{$BaseHref}" rel="home">{$SiteConfig.LogoImage}</a>
                                <% else %>
                                    <% if $SiteConfig.Title %><h2 class="heading"><a href="{$BaseHref}" rel="home">{$SiteConfig.Title}</a></h2><!-- /.heading --><% end_if %>
                                <% end_if %>
                                </div><!-- /.logo -->
                                <% include Content %>
                            </div><!-- /.form-container -->
                        </div><!-- /.col-sm-6 col-sm-offset-3 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </section><!-- /#mainContent -->
        </div><!-- /.content-wrap -->
    </div><!-- /#wrapper -->
    {$TrackingCodeBottom.RAW}
</body>
</html>