<% cache 'PortfolioHolder_ItemCache' %>
    <% if $PaginatedPages %>
        <section class="portfolio">
            <div class="container">
                <div class="row">
                    <% loop $PaginatedPages %>
                        <article class="portfolio__item portfolio__item--{$EvenOdd}<% if $FirstLast %> portfolio__item--{$FirstLast}<% end_if %>">
                            <figure class="portfolio__item__image">
                                <a href="{$Link}" title="{$Title}">
                                    <% with $PortfolioImages.First %>{$Image.CroppedImage(555, 312).SrcSet(50, 100)}<% end_with %>
                                </a>
                            </figure><!-- /.portfolio__item__image -->
                            <h4 class="portfolio__item__heading">
                                <a href="{$Link}" title="{$Title}">{$MenuTitle}</a>
                            </h4><!-- /.portfolio__item__heading -->
                            <% if $Content %>
                                <div class="portfolio__item__summary typography">
                                    {$Content.LimitWordCountXML(40)}
                                </div><!-- /.portfolio__item__summary typography -->
                            <% end_if %>
                            <div class="portfolio__item__actions">
                                <a href="$Link" class="btn--primary" title="{$Title}">Read more</a>
                            </div><!-- /.portfolio__item__actions -->
                        </article><!-- /.portfolio__item -->
                        <% if $MultipleOf(2) %><div class="clearfix"></div><!-- /.clearfix --><% end_if %>
                    <% end_loop %>
                </div><!-- /.row -->
                <% include Pagination %>
            </div><!-- /.container -->
        </section><!-- /.loop portfolio -->
    <% end_if %>
<% end_cache %>