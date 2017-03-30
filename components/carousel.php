<?php

namespace WebUiComponent\Components;

class Carousel extends \WebUiComponent\Models\Component
{
    public function register()
    {
        add_filter('post_gallery', array($this, 'filter_gallery_slideshow'), 10, 4);
    }

    public function render()
    {
        if (!count($this->_items)) {
            return '';
        }

        $nav = $content = '';

        $carousel_id = 'carousel-'.rand();

        foreach ($this->_items as $i => $item) {
            $item->image_size = 'full';
            
            $class = ($i === 0) ? 'active' : '';

            $nav .= "<li data-target=\"#{$carousel_id}\" data-slide-to=\"{$i}\" class=\"{$class}\"></li>";

            $content .= '<div class="carousel-item '.$class.'"><a href="'.$item->link.'">'. $item->image .'</a>';

            if ($item->title) {
                $content .= "<div class=\"carousel-caption\">{$item->title}{$item->text}</div>";
            }

            $content .= '</div>';
        }

        return $this->parse_template([
            'carousel_id' => $carousel_id,
            'nav' => $nav,
            'content' => $content,
            'interval'=>4000
            ], 'carousel');
    }

    public function filter_gallery_slideshow($output, $atts)
    {
        /* 		if (isset($atts['type']) && ($atts['type'] == 'default'))
          return $output; */

        $this->set_items(new \WP_Query(
                array(
            'post__in' => explode(',', $atts['ids']),
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'post_status' => 'all',
            'orderby' => 'post__in',
            'posts_per_page' => -1,
                )
        ));

        return $this->render();
    }
}
