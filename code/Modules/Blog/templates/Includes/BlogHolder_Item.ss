<% cache 'BlogHolder_ItemCache' %>
    <% if $PaginatedPages %>
        <section class="blog">
            <div class="row">
                <% loop $PaginatedPages %>
                    <article class="blog__item is-{$EvenOdd}<% if $FirstLast %> is-{$FirstLast}<% end_if %>">
                        <% if $Image %>
                            <figure class="blog__item__image">
                                <a href="{$Link}" title="{$Title}">
                                    {$Image.CroppedImage(848, 340).SrcSet(75, 100)}
                                </a>
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
                            <a href="$Link" class="btn--primary" title="{$Title}"><%t BlogHolderItem.ActionText "Read more"%></a>
                        </div><!-- /.blog__item__actions -->
                    </article><!-- /.blog__item -->
                <% end_loop %>
            </div><!-- /.row -->
            <% include Pagination %>
        </section><!-- /.blog -->
    <% end_if %>
<% end_cache %>
