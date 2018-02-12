<?php

namespace App\Controllers;

use App\Models\News;
use \Fenom;

class Landing
{
    private $fenom;
    private $config;

    public function __construct()
    {
        $this->config = Config::setting()->get();
        $this->fenom = new Fenom(new Fenom\Provider($this->config['template_dir']));
        $this->fenom->setCompileDir($this->config['template_cache']);
        $options['disable_cache'] = true;
        $this->fenom->setOptions($options);
    }

    private function getImg($path)
    {
        $result = array();
        if (file_exists($path) AND is_dir($path)) {
            $dir = opendir($path);
            while (false !== ($element = readdir($dir))) {
                if ($element != '.' AND $element != '..') {
                    $result[] = $element;
                }
            }
        }
        return $result;
    }

    public function MainAction()
    {
        $path = dirname(__FILE__).'/../../uploads/';

        $afi = dirname(__FILE__).'/../afi.php';
        $afi_vars = require($afi);
        $vars = array(
            'last_news' => News::orderBy('created_at', 'desc')->first(),
            'slider' => $this->getImg($path.'slider/'),
            'slides' => require dirname(__FILE__).'/../slider.php',
            'photo' => $this->getImg($path.'photo/'),
            'afi' => $afi_vars['list'],
            'mari_soc' => array(
                'vk' => !empty($this->config['mari_vk']) ? $this->config['mari_vk'] : '',
                'instagram' => !empty($this->config['mari_instagram']) ? $this->config['mari_instagram'] : '',
                'facebook' => !empty($this->config['mari_facebook']) ? $this->config['mari_facebook'] : '',
            ),
            'who_is_she_img' => !empty($this->config['who_is_she_img']) ? $this->config['who_is_she_img'] : '',
            'who_is_she_head' => !empty($this->config['who_is_she_head']) ? $this->config['who_is_she_head'] : '',
            'who_is_she_intro' => !empty($this->config['who_is_she_intro']) ? $this->config['who_is_she_intro'] : '',
            'who_is_she_full' => !empty($this->config['who_is_she_full']) ? $this->config['who_is_she_full'] : '',

            'audio' => !empty($this->config['audio']) ? $this->config['audio'] : '',
            'audio_all' => !empty($this->config['audio_all']) ? $this->config['audio_all'] : '',

            'video' => !empty($this->config['video']) ? $this->config['video'] : '',
            'video_all' => !empty($this->config['video_all']) ? $this->config['video_all'] : '',

            'organization' => array(
                'name' => !empty($this->config['organization_name']) ? $this->config['organization_name'] : '',
                'phone' => !empty($this->config['organization_phone']) ? $this->config['organization_phone'] : '',
            ),
            'manager' => array(
                'name' => !empty($this->config['manager_name']) ? $this->config['manager_name'] : '',
                'phone' => !empty($this->config['manager_phone']) ? $this->config['manager_phone'] : '',
                'email' => !empty($this->config['manager_email']) ? $this->config['manager_email'] : '',
            ),
            'velvet_address' => !empty($this->config['velvet_address']) ? $this->config['velvet_address'] : '',
            'velvet_phone' => !empty($this->config['velvet_phone']) ? $this->config['velvet_phone'] : '',
            'velvet_email' => !empty($this->config['velvet_email']) ? $this->config['velvet_email'] : '',
            'velvet_site' => !empty($this->config['velvet_site']) ? $this->config['velvet_site'] : '',
            'velvet_soc' => array(
                'vk' => !empty($this->config['velvet_vk']) ? $this->config['velvet_vk'] : '',
                'instagram' => !empty($this->config['velvet_instagram']) ? $this->config['velvet_instagram'] : '',
                'youtube' => !empty($this->config['velvet_youtube']) ? $this->config['velvet_youtube'] : '',
            ),
        );
        $this->fenom->display('landing.tpl', $vars);
    }
}