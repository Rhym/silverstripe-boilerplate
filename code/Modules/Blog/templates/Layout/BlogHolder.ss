<% include PageHeader %>

<div class="container">
    <div class="row">
        <div class="hidden-xs"><% include BlogSideBar %></div><!-- /.hidden-xs -->
        <div class="col-sm-8 col-lg-9">
            <% include Content %>
            <% if $PaginatedPages %>
                <section class="blog loop">
                    <div class="row">
                        <% loop $PaginatedPages %>
                            <article class="item {$Top.ColumnClass} {$FirstLast} {$EvenOdd}">
                                <div class="typography">
                                    <% if $BlogImage %>
                                        <a href="{$Link}" class="image" title="<%t BlogHolder.ReadMore "Read more on &quot;{Title}&quot;" Title=$MenuTitle.XML %>">
                                            {$BlogImage.CroppedImage(848, 340)}
                                        </a><!-- /.image -->
                                    <% end_if %>
                                    <h4 class="heading">
                                        <a href="{$Link}" title="<%t BlogHolder.ReadMore "Read more on &quot;{Title}&quot;" Title=$Title %>">{$MenuTitle.XML}</a>
                                    </h4><!-- /.heading -->
                                    <% if $Date && $Author %>
                                        <p class="meta"><%t BlogHolder.PostedOn "Posted on {Date} by {Author}" Date=$Date.Nice Author=$Author %></p><!-- /.meta -->
                                    <% end_if %>
                                    <p class="summary">$Content.LimitWordCountXML(40)</p><!-- /.summary -->
                                    <a href="$Link" class="btn btn-primary btn-sm" title="<%t BlogHolder.ReadMore "Read more on &quot;{MenuTitle}&quot;" Title=$Title %>">Read more</a>
                                </div><!-- /.typography -->
                            </article><!-- /.item -->
                            <% if $MultipleOf($Top.ColumnMultiple) %>
                                <div class="clearfix"></div><!-- /.clearfix -->
                            <% end_if %>
                        <% end_loop %>
                    </div><!-- /.row -->
                </section><!-- /.blog loop -->
            <% end_if %>
            <% include Pagination %>
        </div><!-- /.col-sm-8 col-lg-9 -->
    </div><!-- /.row -->
</div><!-- /.container -->