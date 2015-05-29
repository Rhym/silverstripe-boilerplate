<div class="container">
    <article class="article article--portfolio">
        <% if $Content %>
            <div class="article__content typography">
                {$Content}
            </div><!-- /.article__content typography -->
        <% end_if %>
        <% if $PortfolioImages %>
            <section class="loop loop--portfolio-images">
                <% loop $PortfolioImages %>
                    <div class="loop__item loop__item--{$EvenOdd} loop__item--{$FirstLast}<% if $Content %> has-content<% end_if %><% if $ContentPosition = 'Left' %> is-left<% else_if $ContentPosition = 'Right' %> is-right<% else %> is-full<% end_if %>">
                        <div class="row">
                            <aside class="loop__item__content typography">
                                {$Content}
                            </aside><!-- /.loop__item__content typography -->
                            <figure class="loop__item__image">
                                {$Image.setWidth(1140)}
                            </figure><!-- /.loop__item__image -->
                        </div><!-- /.row -->
                    </div><!-- /.loop__item loop__item--{$EvenOdd} loop__item--{$FirstLast} -->
                <% end_loop %>
            </section><!-- /.portfolio section -->
        <% end_if %>
    </article><!-- /.article article--blog -->
</div><!-- /.container -->
<% include PreviousNextPage %>