<% if $PaginatedPages %>
    <section class="blog">
        <div class="row">
            <% loop $PaginatedPages %>
                <article class="blog__item blog__item--{$FirstLast} blog__item--{$EvenOdd}">
                    <% cached $LastEdited %>
                        <% if $Image %>
                            <figure class="blog__item__image">
                                <a href="{$Link}" title="{$Title}">
                                    {$Image.CroppedImage(848, 340)}
                                </a>
                                <% if $Date && $Author %>
                                    <figcaption class="blog__item__image__caption">Posted on {$Date} by {$Author}</figcaption><!-- /.blog__item__image__caption -->
                                <% end_if %>
                            </figure><!-- /.blog__item__image -->
                        <% end_if %>
                        <h4 class="blog__item__heading">
                            <a href="{$Link}" title="{$Title}">{$MenuTitle}</a>
                        </h4><!-- /.blog__item__heading -->
                        <% if $Content %>
                            <div class="blog__item__summary typography">
                                {$Content.LimitWordCountXML(40)}
                            </div><!-- /.blog__item__summary typography -->
                        <% end_if %>
                        <div class="blog__item__actions">
                            <a href="$Link" class="btn--primary" title="{$Title}">Read more</a>
                        </div><!-- /.blog__item__actions -->
                    <% end_cached %>
                </article><!-- /.blog__item -->
            <% end_loop %>
        </div><!-- /.row -->
        <% include Pagination %>
    </section><!-- /.blog -->
<% end_if %>