<% include PageHeader %>

<div class="container">
    <% include Content %>
    <% if $PaginatedPages %>
        <section class="portfolio loop">
            <div class="row">
                <% loop $PaginatedPages %>
                <% cached LastEdited %>
                    <article class="item {$Top.ColumnClass} {$FirstLast} {$EvenOdd}">
                        <a href="$Link">
                            <figure class="image">
                                <% loop $PortfolioImages.First %>
                                    {$Image.CroppedImage($Top.PortfolioThumbnailWidth, $Top.PortfolioThumbnailHeight)}
                                <% end_loop %>
                                <figcaption class="meta">
                                    <h4 class="heading">{$MenuTitle.XML}</h4><!-- /.heading -->
                                    <span class="subtitle">
                                        {$SubTitle}
                                    </span><!-- /.subtitle -->
                                </figcaption><!-- /.meta -->
                            </figure><!-- /.image -->
                        </a>
                    </article><!-- /.blog-item -->
                    <% if $MultipleOf($Top.ColumnMultiple) %>
                        <div class="clearfix"></div><!-- /.clearfix -->
                    <% end_if %>
                <% end_cached %>
                <% end_loop %>
            </div><!-- /.row -->
        </section><!-- /.portfolio loop -->
    <% end_if %>
    <% include Pagination %>
</div><!-- /.container -->

<% include PageItems %>