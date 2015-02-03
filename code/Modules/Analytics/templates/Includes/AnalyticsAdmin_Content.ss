<div id="newsletter-controller-cms-content" class="cms-content center" data-layout-type="border" data-pjax-fragment="Content">
    <div class="cms-content-header north">
        <div class="cms-content-header-info">
            <% include CMSBreadcrumbs %>
        </div><!-- /.cms-content-header-info -->
        <div class="dashboard-top-buttons">
            <%--Buttons, yo--%>
        </div><!-- /.dashboard-top-buttons -->
    </div><!-- /.cms-content-header north -->
    <div class="cms-content-fields center ui-widget-content" data-layout-type="border">
        <div id="rightContent" class="cms-content-fields center ui-widget-content cms-panel-padded">

            $FlashMessage

            <h2>Graphs and shit</h2>
            <div id="placeholder" style="width:600px;height:300px"></div>

            <div class="analytics-container">
                <h2>This Month</h2>
                <% loop $PageResults %>
                    <div class="item">
                        <label class="label">Sessions:</label>
                        <div class="data">{$Sessions}</div><!-- /.data -->
                        <div class="tooltip">
                            <div class="icon">?</div><!-- /.icon -->
                            <div class="text">Total number of Sessions within the date range. A session is the period time a user is actively engaged with your website, app, etc. All usage data (Screen Views, Events, Ecommerce, etc.) is associated with a session.</div><!-- /.text -->
                        </div><!-- /.tooltip -->
                    </div><!-- /.item -->
                    <div class="item">
                        <label class="label">Users:</label>
                        <div class="data">{$Users}</div><!-- /.data -->
                        <div class="tooltip">
                            <div class="icon">?</div><!-- /.icon -->
                            <div class="text">Users that have had at least one session within the selected date range. Includes both new and returning users.</div><!-- /.text -->
                        </div><!-- /.tooltip -->
                    </div><!-- /.item -->
                    <div class="item">
                        <label class="label">Page Views:</label>
                        <div class="data">{$PageViews}</div><!-- /.data -->
                        <div class="tooltip">
                            <div class="icon">?</div><!-- /.icon -->
                            <div class="text">Pageviews is the total number of pages viewed. Repeated views of a single page are counted.</div><!-- /.text -->
                        </div><!-- /.tooltip -->
                    </div><!-- /.item -->
                    <div class="item">
                        <label class="label">Page Views Per Session:</label>
                        <div class="data">{$PageViewsPerSession}</div><!-- /.data -->
                        <div class="tooltip">
                            <div class="icon">?</div><!-- /.icon -->
                            <div class="text">Pages/Session (Average Page Depth) is the average number of pages viewed during a session. Repeated views of a single page are counted.</div><!-- /.text -->
                        </div><!-- /.tooltip -->
                    </div><!-- /.item -->
                    <div class="clearfix"></div><!--- /.clearfix -->
                    <div class="item">
                        <label class="label">Average Session Duration:</label>
                        <div class="data">{$AverageSessionDuration}</div><!-- /.data -->
                        <div class="tooltip">
                            <div class="icon">?</div><!-- /.icon -->
                            <div class="text">The average length of a Session.</div><!-- /.text -->
                        </div><!-- /.tooltip -->
                    </div><!-- /.item -->
                    <div class="item">
                        <label class="label">Bounce Rate:</label>
                        <div class="data">{$BounceRate}</div><!-- /.data -->
                        <div class="tooltip">
                            <div class="icon">?</div><!-- /.icon -->
                            <div class="text">Bounce Rate is the percentage of single-page visits (i.e. visits in which the person left your site from the entrance page without interacting with the page).</div><!-- /.text -->
                        </div><!-- /.tooltip -->
                    </div><!-- /.item -->
                    <div class="item">
                        <label class="label">New Sessions:</label>
                        <div class="data">{$PercentNewSessions}</div><!-- /.data -->
                        <div class="tooltip">
                            <div class="icon">?</div><!-- /.icon -->
                            <div class="text">An estimate of the percentage of first time visits.</div><!-- /.text -->
                        </div><!-- /.tooltip -->
                    </div><!-- /.item -->
                <% end_loop %>
            </div><!-- /.analytics-container -->

            <% if $SEOSnippet %>
                <section class="section seo-snippet">
                    <h3 class="heading">SEO Snippet</h3>
                    <% loop $SEOSnippet %>
                        <div id="google_search_snippet">
                            <h3>{$Title}</h3>
                            <div class="google_search_url">{$URL}</div>
                            <p>{$Description}</p>
                        </div>
                    <% end_loop %>
                </section><!-- /.section seo-snippet -->
            <% end_if %>

            <% if $Actions %>
                <section class="section actions-container">
                    <h2 class="heading">Actions</h2><!-- /.heading -->
                    <% loop $Actions %>
                        <div class="alert alert-{$Type}">
                            {$Pos}. {$Message}
                        </div><!-- /.alert -->
                    <% end_loop %>
                </section><!-- /.actions-container -->
            <% end_if %>

        </div><!-- /#leftContent .cms-content-fields center ui-widget-content cms-panel-padded -->
    </div><!-- /.cms-content-fields center ui-widget-content cms-panel-padded -->
</div><!-- /#newsletter-controller-cms-content -->