<% if $PaginatedPages %>
<section class="loop loop--portfolio">
    <div class="row">
        <% loop $PaginatedPages %>
            <article class="loop__item loop__item--{$FirstLast} loop__item--{$EvenOdd} article">
                <figure class="article__image">
                    <a href="{$Link}" title="{$Title}">
                        <% with $PortfolioImages.First %>{$Image.CroppedImage(1140, 641)}<% end_with %>
                    </a>
                </figure><!-- /.article__image -->
                <h4 class="article__heading">
                    <a href="{$Link}" title="{$Title}">{$MenuTitle}</a>
                </h4><!-- /.article__heading -->
                <% if $Content %>
                    <div class="article__summary typography">
                        {$Content.LimitWordCountXML(40)}
                    </div><!-- /.article__summary typography -->
                <% end_if %>
                <div class="article__actions">
                    <a href="$Link" class="btn--primary" title="{$Title}">Read more</a>
                </div><!-- /.article__actions -->
            </article><!-- /.loop__item loop__item--{$FirstLast} loop__item--{$EvenOdd} article -->
            <% if $MultipleOf(2) %><div class="clearfix"></div><!-- /.clearfix --><% end_if %>
        <% end_loop %>
    </div><!-- /.row -->
    <% include Pagination %>
</section><!-- /.loop loop--portfolio -->
<% end_if %>