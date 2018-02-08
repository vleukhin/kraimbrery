<?php

namespace App\Controllers;

final class Config
{
    public $config;
    private $file_config;

    private function __construct()
    {
        $this->file_config = realpath(dirname(__FILE__).'/../config.php');
        $this->config = require($this->file_config);
    }

    public static function setting()
    {
        return new self();
    }

    public function get()
    {
        return $this->config;
    }

    public function save($config)
    {
        if (!empty($config) && is_array($config)) {
            $this->config = array_merge($this->config, $config);
            file_put_contents(
                $this->file_config,
                '<? '.PHP_EOL.' return '.var_export($this->config, true).';'
            );
        }
    }

}