<?php

namespace WebUiComponent\Models;

class Item
{
    public $id;
    public $title;
    public $text;
    public $link;

    public $image_size = 'post-thumbnail';

    public function __construct($item = [])
    {
        if (get_class($item)=== 'WP_Post') {
            $this->id = $item->ID;
            $this->title = $item->post_title;
            $this->text = get_the_excerpt($item);
            $this->link = get_permalink($item);
        }
    }

    public function __get($key)
    {
        $method_name = 'get_'.$key;

        if (method_exists($this, $method_name)) {
            return $this->$method_name();
        }
    }

    public function get_image($size  = '', $attr = '')
    {
        if (!$size) {
            $size = $this->image_size;
        }
        return get_the_post_thumbnail($this->id, $size, $attr);
    }
}
