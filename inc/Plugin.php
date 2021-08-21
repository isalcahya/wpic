<?php
namespace App;

class Plugin
{
    private $fiturs;

    public function __construct()
    {
        $this->fiturs = [];
    }

    public function add($fitur)
    {
        array_push($this->fiturs, $fitur);
    }

    private function registerFiturs()
    {
        if (count($this->fiturs)) {
            foreach ($this->fiturs as $fitur) {
                $fitur->init();
            }
        }
    }

    public function inits()
    {
        // Register all shortcodes
        $this->registerFiturs();
    }
}