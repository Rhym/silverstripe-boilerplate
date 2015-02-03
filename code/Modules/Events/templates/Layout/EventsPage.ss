<% include PageHeader %>

<% if $Content || $Form %>
<div class="container">
    <% include Content %>
</div><!-- /.container -->
<% end_if %>

<section class="section calendar">
    <div class="container">
        <div class="actions">
            <div class="row">
                <div class="col-xs-4 prev">{$PrevMonthForm}</div><!-- /.col-xs-4 prev -->
                <div class="col-xs-4 date"><span class="heading">{$ThisMonthNice} {$ThisYear}</span></div><!-- /.col-xs-4 date -->
                <div class="col-xs-4 next">{$NextMonthForm}</div><!-- /.col-xs-4 next -->
            </div><!-- /.row -->
        </div><!-- /.actions -->
        {$Calendar}
    </div><!-- /.container -->
</section><!-- /.section calendar -->

<% include PageItems %>