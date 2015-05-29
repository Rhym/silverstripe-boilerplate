<div class="container">
    <div class="row">
        <% include BlogSidebar %>
        <div class="page__content has-sidebar">
            <article class="article article--blog">
                <% cached $LastEdited %>
                    <% if $Image %>
                        <figure class="article__image">
                            {$Image.setWidth(850)}
                            <% if $Date && $Author %>
                                <figcaption class="article__image__caption">Posted on {$Date} by {$Author}</figcaption><!-- /.article__image__caption -->
                            <% end_if %>
                        </figure><!-- /.page__image -->
                    <% end_if %>
                    <% if $Content %>
                        <div class="article__content typography">
                            {$Content}
                        </div><!-- /.article__content typography -->
                    <% end_if %>
                <% end_cached %>
                <% include Comments %>
            </article><!-- /.article article--blog -->
        </div><!-- /.page__content has-sidebar -->
    </div><!-- /.row -->
</div><!-- /.container -->
<% include PreviousNextPage %>