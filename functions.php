<?php


/**
 * Get the Post Thumbnail with Srcset and SEO attr
 * 
 * @param int $post_id
 * @param string $class
 * @return void
 */

function bwk_get_post_thumbnail($post_id, $class)
{
    $result = '';
    if (!empty($post_id)) {
        $thumb_id = get_post_thumbnail_id($post_id);
        $thumb_dim = wp_get_attachment_image_src($thumb_id, 'medium');
        $result .= '<img src="' . esc_url(wp_get_attachment_image_src($thumb_id, 'medium')[0]) . '" ';
        $result .= 'srcset="' . esc_attr(wp_get_attachment_image_srcset($thumb_id, 'medium')) . '" ';
        $result .= 'alt="' . esc_attr(get_post_meta($thumb_id, '_wp_attachment_image_alt', true)) . '" ';
        $result .= 'title="' . esc_attr(get_the_title($thumb_id)) . '" ';
        $result .= 'width="' . esc_attr($thumb_dim[1]) . '" ';
        $result .= 'height="' . esc_attr($thumb_dim[2]) . '" ';
        $result .= 'loading="lazy" ';
        $result .= 'class="' . $class . '"/>';
    }
    echo $result;
}

/**
 * Get ACF Image with Srcset and SEO attr
 * 
 * @param array $image
 * @param string $class
 * @return void
 */

function bwk_get_acf_image($image, $class)
{
    $result = '';
    if (!empty($image)) {
        $result .= '<img src="' . esc_url($image['url']) . '" ';
        $result .= 'srcset="' . generate_srcset($image['sizes']) . '" ';
        $result .= 'alt="' . esc_attr($image['alt']) . '" ';
        $result .= 'title="' . esc_attr($image['title']) . '" ';
        $result .= 'width="' . esc_attr($image['width']) . '" ';
        $result .= 'height="' . esc_attr($image['height']) . '" ';
        $result .= 'loading="lazy" ';
        $result .= 'class="' . $class . '"/>';
    }
    echo $result;
}

/**
 * Generate srcset for Image from ACF
 * 
 * @param array $image_sizes
 * @return string $srcset
 */

function generate_srcset($image_sizes)
{
    $srcset = '';
    foreach ($image_sizes as $size => $url) {
        if (strpos($size, '-width') === false && strpos($size, '-height') === false) {
            $width = $image_sizes[$size . '-width'];
            $srcset .= $url . ' ' . $width . 'w, ';
        }
    }
    $srcset = rtrim($srcset, ', ');
    return $srcset;
}
