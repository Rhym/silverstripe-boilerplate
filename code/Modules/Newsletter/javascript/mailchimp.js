/* -----------------------------------------
 * Globals
 ------------------------------------------*/

var leftContent = jQuery('#leftContent'),
    rightContent = jQuery('#rightContent'),
    loader = jQuery('.newsletter-loader');

/* -----------------------------------------
 * Ready Function
 ------------------------------------------*/

(function($) {
    $.entwine('boilerplate', function($){
        // Campaigns
        //-------------------------
        $('#campaignsButton').entwine({
            onclick: function(e){
                e.preventDefault();
                loadCampaigns();
                this._super();
            }
        });
        $('.view-campaign').entwine({
            onclick: function(e){
                e.preventDefault();
                viewCampaign(this);
                this._super();
            }
        });
        $('#newCampaignButton').entwine({
            onclick: function(e){
                e.preventDefault();
                createNewCampaign();
                this._super();
            }
        });
        // Lists
        //-------------------------
        $('#listsButton').entwine({
            onclick: function(e){
                e.preventDefault();
                loadLists();
                this._super();
            }
        });
        $('.view-list').entwine({
            onclick: function(e){
                e.preventDefault();
                viewList(this);
                this._super();
            }
        });
    });
})(jQuery);

/* -----------------------------------------
 * Campaign
 ------------------------------------------*/

function loadCampaigns(){
    var button = jQuery('#campaignsButton');
        button.addClass('loading');
    jQuery.ajax({
        url: 'admin/newsletter/campaigns',
        dataType: 'json',
        success: function(data){
            $list = jQuery("#MailchimpCampaignsUL");
            $list.html('');
            if (data.data.length > 0) {
                jQuery.each(data.data, function(){
                    $list.append("<li><a class=\"view-campaign\" href='admin/campaign/#"+ this.id +"' id='" + this.id + "' name='" + this.title + "'>" + this.title + "</a></li>");
                });
            } else {
                $list.append('No lists found');
            }
            button.removeClass('loading');
        }
    });
}

function viewCampaign(e){
    var height = rightContent.height();
    rightContent.html('');
    loader.show();
    rightContent.append('<iframe src="admin/newsletter/viewcampaign/' + jQuery(e).attr('id') + '?height=' + height + '&title=' + encodeURI(jQuery(e).attr('name')) + '" width="100%" height="' + height + 'px" scrolling="yes" style="overflow-x:hidden;"></iframe>');
}

function createNewCampaign(){
    var height = rightContent.height();
    rightContent.html('');
    loader.show();
    rightContent.append("<iframe src='admin/newsletter/viewcampaign/0?height=" + height + "' width='100%' height='" + height + "px' scrolling='yes' style='overflow-x: hidden;' ></iframe>");
}

/* -----------------------------------------
 * Lists
 ------------------------------------------*/

function loadLists(){
    var button = jQuery('#listsButton');
    button.addClass('loading');
    jQuery.ajax({
        url: 'admin/newsletter/lists',
        dataType: 'json',
        success: function(data){
            $list = jQuery('#MailchimpListsUL');
            $list.html('');
            if (data.data.length > 0) {
                jQuery.each(data.data, function(){
                    $list.append("<li><a class=\"view-list\" href='admin/newsletter/viewList/#"+ this.id +"' id='" + this.id + "' name='" + this.name + "'>" + this.name + "</a></li>");
                });
                var firstItem = $list.find('a');
                jQuery(firstItem).click(viewList(jQuery(firstItem)));
            } else {
                $list.append('No lists found');
            }
            button.removeClass('loading');
        }
    });
}

function viewList(e){
    var height = rightContent.height();
    rightContent.html('');
    loader.show();
    rightContent.append('<iframe src="admin/newsletter/viewlist/'+ jQuery(e).attr('id') + '?height=' + height + '&title=' + encodeURI(jQuery(e).attr('name')) + '" width="100%" height="' + height + 'px" scrolling="yes" style="overflow-x: hidden;"></iframe>');
}