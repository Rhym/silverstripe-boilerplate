<% include PageHeader %>
<% cached LastEdited %>
<div class="container">
    <% include Content %>
    <% if $PaginatedPages %>
        <section class="gallery loop<% if $NoMargin %> no-margin<% end_if %>">
            <div class="row">
                <% loop $PaginatedPages %>
                    <figure class="item {$Top.ColumnClass} {$FirstLast}">
                        <a href="#" data-toggle="modal" data-target="#item-{$Pos}">
                            <img src="{$CroppedImage($Top.ThumbnailWidth, $Top.ThumbnailHeight).Link}" alt="{$Name}" title="{$Name}" />
                        </a>
                        <div class="gallery modal" id="item-{$Pos}" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="inner">
                                            <div class="actions">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                            </div><!-- /.actions -->
                                            <img src="{$URL}" alt="{$Name}" />
                                            <div class="nav">
                                                <div class="prev"><% if $First %><% else %><button data-toggle="modal" class="modal-navigation" data-target="#item-{$Pos(0)}"><i class="fa fa-angle-left"></i></button><% end_if %></div><!-- /.prev -->
                                                <div class="next"><% if $Last %><% else %><button data-toggle="modal" class="modal-navigation" data-target="#item-{$Pos(2)}"><i class="fa fa-angle-right"></i></button><% end_if %></div><!-- /.next -->
                                            </div><!-- /.nav -->
                                        </div><!-- /.inner -->
                                    </div><!-- /.modal-body -->
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.gallery modal -->
                    </figure><!-- /.item col-xs-6 col-sm-3 -->
                    <% if $MultipleOf($Top.ColumnMultiple) %>
                        <div class="clearfix"></div><!-- /.clearfix -->
                    <% end_if %>
                <% end_loop %>
            </div><!-- /.row -->
        </section><!-- /.gallery loop -->
    <% end_if %>
    <% include Pagination %>
</div><!-- /.container -->
<% end_cached %>
<% include PageItems %>