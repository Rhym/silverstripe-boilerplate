<% include PageHeader %>
<div class="container">
    <div class="row">
        <div class="hidden-xs"><% include BlogSidebar %></div><!-- /.hidden-xs -->
        <div class="col-sm-8 col-lg-9">
            <section class="blog page">
                <% cached $LastEdited %>
                <% if $Image %>
                    <p>{$Image.setWidth(850)}</p>
                <% end_if %>
                <% if $Date && $Author %>
                    <p class="meta"><%t BlogPage.PostedOn "Posted on {Date} by {Author}" Date=$Date.Nice Author=$Author %></p><!-- /.meta -->
                <% end_if %>
                <% include Content %>
                <% end_cached %>
                <% include Disqus %>
            </section><!-- /.blog page -->
        </div><!-- /.col-sm-8 col-lg-9 -->
    </div><!-- /.row -->
</div><!-- /.container -->
<% include ImageNavigation %>