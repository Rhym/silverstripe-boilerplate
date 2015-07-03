<?php

/**
 * Class ImageExtension
 *
 * @mixin Image
 */
class ImageExtension extends DataExtension {

    private static $min_mobile_width = 320;

    private static $mobile_break_point = 768;

    /**
     * Add the "srcset" and "sizes" HTML attributes to the img tag.
     * Sets a 2x DPI image in mobile, and the full size image in tablet/desktop
     *
     * @param int $desktop_vw
     * @param int $mobile_vw
     * @return HTMLText
     */
    public function SrcSet($desktop_vw = 100, $mobile_vw = 100) {
        /** =========================================
         * @var Image $owner
         * @var float $vhScale
         * @var int $width
         * @var int $height
         * @var int $mobileWidth
         * @var int $mobileBreakPoint
         * @var float $scale
         * @var int $scaledWidth
         * @var int $scaledHeight
         * @var string $srcSet
         * @var string $sizes
         * @var array $data
        ===========================================*/

        $owner = $this->owner;

        /** If the Image exists */
        if (!$owner->ID) {
            return false;
        }
        /** If the args aren't set, return the default Image  */
        else if (!(int)$desktop_vw || !(int)$mobile_vw && $desktop_vw <= 0 || $mobile_vw <= 0) {
            return $owner;
        }

        $width = (int)$owner->getWidth();
        $height = (int)$owner->getHeight();
        $vhScale = (float)$mobile_vw / 100;
        $mobileWidth = (int)$owner->stat('min_mobile_width');
        $mobileBreakPoint = (int)$owner->stat('mobile_break_point');
        $scale = (float)$mobileWidth / $width;
        /**
         * Resize the image to be the width of $min_mobile_width
         * and calculate the height based on the ratio of the
         * non-cropped image.
         */
        $scaledWidth = (int)(ceil($mobileWidth * $vhScale) * 2);
        $scaledHeight = (int)ceil((($height * $scale) * 2) * $vhScale);

        /**
         * Set the data that will be sent to the img tag
         */
        $srcSet = (string)sprintf('%s %sw, %s %sw',
            (string)$owner->URL,
            $width,
            (string)$owner->CroppedImage($scaledWidth, $scaledHeight)->URL,
            $scaledWidth
        );
        $sizes = (string)sprintf('(min-width: %spx) %svw, %svw',
            $mobileBreakPoint,
            $desktop_vw,
            $mobile_vw
        );
        $data = array(
            'SrcSet'    => $srcSet,
            'Sizes'     => $sizes
        );

        return $owner->renderWith('Image_Srcset', (array)$data);
    }

}