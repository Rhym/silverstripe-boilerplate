<% if $PaginatedPages %>
<section class="loop loop--blog">
    <% loop $PaginatedPages %>
        <article class="loop__item loop__item--{$FirstLast} loop__item--{$EvenOdd} article">
            <% cached $LastEdited %>
                <% if $Image %>
                    <figure class="article__image">
                        <a href="{$Link}" title="{$Title}">
                            {$Image.CroppedImage(848, 340)}
                        </a>
                        <% if $Date && $Author %>
                            <figcaption class="article__image__caption">Posted on {$Date} by {$Author}</figcaption><!-- /.article__image__caption -->
                        <% end_if %>
                    </figure><!-- /.article__image -->
                <% end_if %>
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
            <% end_cached %>
        </article><!-- /.loop__item article article--{$FirstLast} article--{$EvenOdd} -->
    <% end_loop %>
    <% include Pagination %>
</section><!-- /.loop loop--blog -->
<% end_if %>