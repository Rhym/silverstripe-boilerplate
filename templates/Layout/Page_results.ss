<div class="container">
    <form $FormAttributes role="form">
        <fieldset>
            <div class="well">
                <h4 class="heading"><% sprintf(_t('SearchForm.SearchHeading',"Search %s"), $SiteConfig.Title) %></h4><!-- /.heading -->
                <div class="form-group">
                    <input type="text" name="Search" placeholder="<% _t('SearchForm.SearchPlaceholder', 'Enter your search keywords...') %>" class="form-control" value="{$Query.XML}" id="SearchForm_SearchForm_Search">
                </div><!-- /.form-group -->
                <div class="form-group">
                    <input type="submit" name="action_results" value="Search" class="action btn btn-primary" id="SearchForm_SearchForm_action_results">
                </div><!-- /.form-group -->
            </div><!-- /.well -->
        </fieldset>
    </form><!-- /[role="form"] -->
    <section class="search-results">
        <% if $Query %>
            <article class="content typography">
                <h1><i class="fa fa-search"></i> "{$Query.XML}"</h1>
            </article><!-- /.content typography -->
        <% end_if %>
        <% if $Results %>
            <div class="results-loop">
                <% loop $Results %>
                    <div class="well">
                        <h4>
                            <a href="$Link">
                                <% if $MenuTitle %>
                                    {$MenuTitle.XML}
                                <% else %>
                                    {$Title.XML}
                                <% end_if %>
                            </a>
                        </h4>
                        <% if $Content %>
                        <p>{$Content.LimitWordCountXML}</p>
                        <% end_if %>
                        <a class="readMoreLink" href="{$Link}"><%t PageResults.ReadMoreText 'Read more about "{Title}"' Title=$Title %></a>
                    </div><!-- /.well -->
                <% end_loop %>
            </div><!-- /.results-loop -->
        <% else %>
            <p class="alert alert-warning"><%t PageResults.NoResultsText 'Sorry, your search query did not return any results.' %></p>
        <% end_if %>
        <% if $Results.MoreThanOnePage %>
            <ul class="pagination">
                <% if $Results.NotFirstPage %>
                    <li><a class="prev" href="{$Results.PrevLink}"><%t Pagination.PrevText 'Prev' %></a></li>
                <% end_if %>
                <% loop $Results.Pages %>
                    <% if $CurrentBool %>
                        <li class="active"><span>{$PageNum}</span></li><!-- /.active -->
                    <% else %>
                        <% if $Link %>
                            <li><a href="{$Link}">{$PageNum}</a></li>
                        <% else %>
                            <li><%t Pagination.Ellipsis '...' %></li>
                        <% end_if %>
                    <% end_if %>
                <% end_loop %>
                <% if $Results.NotLastPage %>
                    <li><a class="next" href="{$Results.NextLink}"><%t Pagination.NextText 'Next' %></a></li>
                <% end_if %>
                <%--<li class="disabled"><span>$PaginatedPages.CurrentPosition</span></li>--%>
            </ul><!-- /.pagination -->
        <% end_if %>
    </section><!-- /.search-results -->
</div><!-- /.container -->