<?php

namespace WebUiComponent\Components;

class Grid extends \WebUiComponent\Models\Component
{
    public function render()
    {
        if (!count($this->_items)) {
            return '';
        }

		$card = new \WebUiComponent\Models\Template('card');

        $content = '';

        foreach ($this->_items as $i => $item) {
            $content .= '<div class="col-md-4">'.$card->parse($item).'</div>';
        }


        return "<div class=\"row\">{$content}</div>";
    }
}
