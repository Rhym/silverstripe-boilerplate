<aside class="sharer">
    <a data-toggle="collapse" href="#sharer" class="sharer__trigger">Share this post</a>
    <div id="sharer" class="collapse">
        <input type="text" onclick="this.setSelectionRange(0, this.value.length)" class="sharer__form" value="{$AbsoluteLink}" />
        <ul class="sharer__list">
            <li class="sharer__list__item sharer__list__item--first">
                <a href="mailto:?subject={$MenuTitle.XML}&body={$AbsoluteLink}" class="sharer__list__item__link sharer__list__item__link--email" title="<%t Sharer.Email "Send to a friend" %>">
                    {$SVG('mail').extraClass('sharer__list__item__link__icon')}
                </a><!-- /.sharer__list__item__link -->
            </li><!-- /.sharer__list__item -->
            <li class="sharer__list__item">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={$AbsoluteLink}&amp;title={$MenuTitle.XML}" class="sharer__list__item__link sharer__list__item__link--facebook" onclick="window.open(this.href, 'facebook', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" title="<%t Sharer.Facebook "Share to Facebook" %>">
                    {$SVG('social-facebook').extraClass('sharer__list__item__link__icon')}
                </a><!-- /.sharer__list__item__link -->
            </li><!-- /.sharer__list__item -->
            <li class="sharer__list__item">
                <a target="_blank" href="http://twitter.com/home?status={$MenuTitle.XML} - +{$AbsoluteLink}" onclick="window.open(this.href, 'twitter', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" class="sharer__list__item__link sharer__list__item__link--twitter" title="<%t Sharer.Twitter "Share to Twitter" %>">
                    {$SVG('social-twitter').extraClass('sharer__list__item__link__icon')}
                </a><!-- /.sharer__list__item__link -->
            </li><!-- /.sharer__list__item -->
            <li class="sharer__list__item sharer__list__item">
                <a target="_blank" href="https://plus.google.com/share?url={$AbsoluteLink}" onclick="window.open(this.href, 'google', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" class="sharer__list__item__link sharer__list__item__link--google" title="<%t Sharer.Google "Share to Google Plus" %>">
                    {$SVG('social-google-plus').extraClass('sharer__list__item__link__icon')}
                </a><!-- /.sharer__list__item__link -->
            </li><!-- /.sharer__list__item -->
            <li class="sharer__list__item sharer__list__item--last">
                <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={$AbsoluteLink}" onclick="window.open(this.href, 'linkedin', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" class="sharer__list__item__link sharer__list__item__link--linkedin" title="<%t Sharer.LinkedIn "Share to LinkedIn" %>">
                    {$SVG('social-linkedin').extraClass('sharer__list__item__link__icon')}
                </a><!-- /.sharer__list__item__link -->
            </li><!-- /.sharer__list__item -->
        </ul><!-- /.sharer__list -->
    </div><!-- /#sharer -->
</aside><!-- /.sharer -->
