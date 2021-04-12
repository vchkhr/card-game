<?php

ob_start();

class NavigationManager
{
    private $htmlFileContent;
    public $arrFragment = array();

    public function __construct($htmlFilePath)
    {
//        $this->changeScreen($htmlFilePath);
    }

    public function renderBy($key)
    {
        $this->changeScreen($key);
        $this->render();
    }

    public function render()
    {
        flush();
        ob_clean();
        if (isset($this->htmlFileContent)) {
            echo $this->htmlFileContent;
            return true;
        } else {
            return false;
        }
    }

    public function bind($id, $value)
    {
        if (isset($this->htmlFileContent))
            $this->htmlFileContent = str_replace($id, $value, $this->htmlFileContent);
    }

    public function putScreen($key, $value)
    {
        $this->arrFragment[$key] = $value;
    }

    public function changeScreen($key)
    {
        $path = $this->arrFragment[$key];
        $this->htmlFileContent = file_get_contents($path);
    }
}
