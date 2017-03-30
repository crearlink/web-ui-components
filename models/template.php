<?php
// wp-ui-component
namespace WebUiComponent\Models;

class Template
{
    public $folders = [
		'../../../templates',
		'../templates/bootstrap',
        '../templates'
    ];

    private $_template_name;
    private $_template;

    public function __construct($template_name='')
    {
        if ($template_name) {
            $this->set_template($template_name);
        }
    }

    public function set_template($template_name)
    {
        if ($template_name == $this->_template_name) {
            return;
        }

        $this->_template_name = $template_name;
        $this->_template = '';

        foreach ($this->folders as $folder) {
            $file = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR.$folder).DIRECTORY_SEPARATOR.$template_name.'.html';

            if (file_exists($file)) {
                $this->_template = file_get_contents($file);
                return;
            }
        }
    }

    public function parse($data)
    {
        if (is_array($data)) {
            $data = (object)$data;
        }
        $template = $this->_template;

        if (preg_match_all('/\{\$(.*?)\}/', $template, $m)) {
            foreach ($m[1] as $i => $varname) {
                if (property_exists($data, $varname) || method_exists($data, 'get_'.$varname)) {
                    $template = str_replace($m[0][$i], $data->$varname, $template);
                }
            }
        }

        return $template;
    }
}
