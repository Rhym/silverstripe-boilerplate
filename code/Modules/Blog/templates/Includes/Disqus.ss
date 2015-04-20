<% if $SiteConfig.DisqusForumShortName %>
<section id="disqusComments">
    <h3 class="heading"><%t Disqus.Title "Join the conversation" %></h3><!-- /.heading -->
    <div id="disqus_thread"></div><!-- #disqus_thread -->
    <script type="text/javascript">
        var disqus_shortname = '{$SiteConfig.DisqusForumShortName}'; // required: replace example with your forum shortname
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
</section><!-- /#disqusComments -->
<% end_if %>