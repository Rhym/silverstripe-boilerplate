<div class="container">
    <div class="row">
        <div class="page__content">
            <section class="search">
                <aside class="search__form">
                    <form $FormAttributes role="form" class="form">
                        <fieldset>
                            <div class="field text">
                                <div class="middleColumn">
                                    <input type="text" name="Search" placeholder="Enter your search keywords..." class="text" value="{$Query.XML}" id="SearchForm_SearchForm_Search">
                                </div><!-- /.middleColumn -->
                            </div><!-- /.field text -->
                            <div class="Actions">
                                <input type="submit" name="action_results" value="Search" class="btn--primary" id="SearchForm_SearchForm_action_results">
                            </div><!-- /.Actions -->
                        </fieldset>
                    </form><!-- /[role="form"] -->
                </aside><!-- /.search__form -->
                <div class="search__results">
                    <% if $Results %>
                        <div class="loop loop--search-results">
                            <% loop $Results %>
                                <article class="loop__item article">
                                    <h4 class="article_heading"><a href="$Link"><% if $MenuTitle %>{$MenuTitle.XML}<% else %>{$Title.XML}<% end_if %></a></h4><!-- /.article_heading -->
                                    <% if $Content %>
                                        <div class="article__summary">{$Content.LimitWordCountXML}</div><!-- /.article__summary -->
                                    <% end_if %>
                                    <div class="article__actions"><a href="{$Link}">Read more about "{$Title}"</a></div><!-- /.article__actions -->
                                </article><!-- /.loop__item article -->
                            <% end_loop %>
                        </div><!-- /.loop loop--search-results -->
                    <% else %>
                        <div class="alert--warning">Sorry, your search query did not return any results.</div><!-- /.alert--warning -->
                    <% end_if %>
                    <% include Pagination PaginatedPages=$Results %>
                </div><!-- /.search__results -->
            </section><!-- /.search -->
        </div><!-- /.page_content has-sidebar -->
    </div><!-- /.row -->
</div><!-- /.container -->