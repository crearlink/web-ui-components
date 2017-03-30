<?php

namespace WebUiComponent\Models;

class Component
{
    protected $_items = [];

    public function __construct($source = [])
    {
        if ($source) {
            $this->set_items($source);
        }
    }

    public function set_items($source = [])
    {
        if (get_class($source) === 'WP_Query') {
            $source = $source->posts;
        }

        $this->_items = [];

        foreach ($source as $entry) {
            $this->_items[] = new Item($entry);
        }
    }

    public function render()
    {
        return '';
    }

    public function items_foreach($func)
    {
        array_map($func, $this->_items);
    }

    public function parse_template($data, $template_name='')
    {
        $template = new Template($template_name);
        return $template->parse($data);
    }
}
