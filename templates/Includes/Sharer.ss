<aside class="sharer">
    <a data-toggle="collapse" href="#sharer" class="btn--secondary">Share this post <i class="fa fa-share-square-o"></i></a>
    <div id="sharer" class="collapse">
        <input type="text" onclick="this.setSelectionRange(0, this.value.length)" class="sharer__form" value="{$AbsoluteLink}" />
        <ul class="sharer__list">
            <li class="sharer__list__item sharer__list__item--first">
                <a href="mailto:?subject={$MenuTitle.XML}&body={$AbsoluteLink}" class="sharer__list__item__link sharer__list__item__link--email" title="<%t Sharer.Email "Send to a friend" %>">
                    <i class="fa fa-envelope"></i>
                </a><!-- /.sharer__list__item__link sharer__list__item__link--email -->
            </li><!-- /.sharer__list__item sharer__list__item--first -->
            <li class="sharer__list__item">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={$AbsoluteLink}&amp;title={$MenuTitle.XML}" class="sharer__list__item__link sharer__list__item__link--facebook" onclick="window.open(this.href, 'facebook', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" title="<%t Sharer.Facebook "Share to Facebook" %>">
                    <i class="fa fa-facebook"></i>
                </a><!-- /.sharer__list__item__link sharer__list__item__link--facebook -->
            </li><!-- /.sharer__list__item -->
            <li class="sharer__list__item">
                <a target="_blank" href="http://twitter.com/home?status={$MenuTitle.XML} - +{$AbsoluteLink}" onclick="window.open(this.href, 'twitter', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" class="sharer__list__item__link sharer__list__item__link--twitter" title="<%t Sharer.Twitter "Share to Twitter" %>">
                    <i class="fa fa-twitter"></i>
                </a><!-- /.sharer__list__item__link sharer__list__item__link--twitter -->
            </li><!-- /.sharer__list__item -->
            <li class="sharer__list__item sharer__list__item--last">
                <a target="_blank" href="https://plus.google.com/share?url={$AbsoluteLink}" onclick="window.open(this.href, 'google', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" class="sharer__list__item__link sharer__list__item__link--google" title="<%t Sharer.Google "Share to Google Plus" %>">
                    <i class="fa fa-google-plus"></i>
                </a><!-- /.sharer__list__item__link sharer__list__item__link--google -->
            </li><!-- /.sharer__list__item sharer__list__item--last -->
        </ul><!-- /.sharer__list -->
    </div><!-- /#sharer -->
</aside><!-- /.sharer -->