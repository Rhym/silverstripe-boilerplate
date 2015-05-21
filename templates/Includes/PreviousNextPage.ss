<% if $PreviousLink || $NextLink %>
<section class="previous-next-page ajax-control section">
    <div class="container">
        <div class="loop">
            <div class="row">
                <article class="col-xs-6 item previous">
                <% if $PreviousLink %>
                    <div class="inner">
                    <% with $PreviousLink %>
                        <a href="{$Link}" title="{$Title}"><i class="fa fa-angle-left"></i> {$MenuTitle}</a>
                    <% end_with %>
                    </div><!-- /.inner -->
                <% end_if %>
                </article><!--- /.col-xs-6 item-previous -->
                <article class="col-xs-6 item next">
                <% if $NextLink %>
                    <div class="inner">
                    <% with $NextLink %>
                        <a href="{$Link}" title="{$Title}">{$MenuTitle} <i class="fa fa-angle-right"></i></a>
                    <% end_with %>
                    </div><!-- /.inner -->
                <% end_if %>
                </article><!--- /.col-xs-6 item-next -->
            </div><!-- /.row -->
        </div><!-- /.loop -->
    </div><!-- /.container -->
</section><!-- /.previous-next-page section -->
<% end_if %>