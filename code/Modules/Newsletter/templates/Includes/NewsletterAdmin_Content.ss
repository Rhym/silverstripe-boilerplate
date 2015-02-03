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
        <div class="cms-content-tools west cms-panel cms-panel-layout ui-widget" data-expandonclick="true" data-layout-type="border">
            <div class="cms-panel-content center">
                <div id="leftContent">
                    $APIForm
                    $MainContent
                </div><!-- /#leftContent -->
            </div><!-- /.cms-panel-content center -->
        </div><!-- /.cms-content-tools west cms-panel cms-panel-layout ui-widget -->
        <div class="newsletter-loader"><img src="{$BaseHref}boilerplate/code/Modules/Newsletter/images/loader.gif"></div><!-- /.newsletter-loader -->
        <div id="rightContent" class="cms-content-fields center ui-widget-content cms-panel-padded">
            <div class="dynamic-content"></div><!-- /.dynamic-content -->
        </div><!-- /#leftContent .cms-content-fields center ui-widget-content cms-panel-padded -->
    </div><!-- /.cms-content-fields center ui-widget-content cms-panel-padded -->
</div><!-- /#newsletter-controller-cms-content -->