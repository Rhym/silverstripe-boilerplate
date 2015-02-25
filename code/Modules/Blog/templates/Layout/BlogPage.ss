<% include PageHeader %>
<% cached LastEdited %>
<div class="container">
    <div class="row">
        <div class="hidden-xs"><% include BlogSideBar %></div><!-- /.hidden-xs -->
        <div class="col-sm-8 col-lg-9">
            <section class="blog page">
                <% if $BlogImage %>
                    <p>{$BlogImage.setWidth(850)}</p>
                <% end_if %>
                <% if $Date && $Author %>
                    <p class="meta"><%t BlogPage.PostedOn "Posted on {Date} by {Author}" Date=$Date.Nice Author=$Author %></p><!-- /.meta -->
                <% end_if %>
                <% include Content %>
                <% include Disqus %>
            </section><!-- /.blog page -->
        </div><!-- /.col-sm-8 col-lg-9 -->
    </div><!-- /.row -->
</div><!-- /.container -->
<% end_cached %>
<% include ImageNavigation %>