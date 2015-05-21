<% if $PaginatedPages %>
<section class="portfolio loop">
    <div class="row">
        <% loop $PaginatedPages %>
            <article class="item col-sm-6 {$FirstLast} {$EvenOdd}">
                <a href="$Link">
                    <figure class="image">
                        <% loop $PortfolioImages.First %>
                            {$Image.CroppedImage(1140, 641)}
                        <% end_loop %>
                        <figcaption class="meta">
                            <h4 class="heading">{$MenuTitle.XML}</h4><!-- /.heading -->
                            <span class="subtitle">
                                {$SubTitle}
                            </span><!-- /.subtitle -->
                        </figcaption><!-- /.meta -->
                    </figure><!-- /.image -->
                </a>
            </article><!-- /.item col-sm-6 {$FirstLast} {$EvenOdd} -->
            <% if $MultipleOf(2) %><div class="clearfix"></div><!-- /.clearfix --><% end_if %>
        <% end_loop %>
    </div><!-- /.row -->
    <% include Pagination %>
</section><!-- /.portfolio loop -->
<% end_if %>