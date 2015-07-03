<% include Page_Content %>

<% if $PortfolioImages %>
    <section class="portfolio-images">
        <div class="container">
            <% loop $PortfolioImages %>
                <div class="portfolio-images__item portfolio-images__item--{$EvenOdd} portfolio-images__item--{$FirstLast}<% if $Content %> has-content<% end_if %><% if $ContentPosition = 'Left' %> is-left<% else_if $ContentPosition = 'Right' %> is-right<% else %> is-full<% end_if %>">
                    <div class="row">
                        <aside class="portfolio-images__item__content typography">
                            {$Content}
                        </aside><!-- /.portfolio-images__item__content typography -->
                        <figure class="portfolio-images__item__image">
                            {$Image.setWidth(1140).SrcSet}
                        </figure><!-- /.portfolio-images__item__image -->
                    </div><!-- /.row -->
                </div><!-- /.portfolio-images__item -->
            <% end_loop %>
        </div><!-- /.container -->
    </section><!-- /.portfolio-images -->
<% end_if %>

<% include PreviousNextPage %>