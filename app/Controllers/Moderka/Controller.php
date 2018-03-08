<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App\Controllers\Moderka;


use Slim\Views\Twig;

class Controller
{
    /**
     * @var Twig
     */
    protected $twig;

    public function __construct($container)
    {
        $this->container = $container;
        $this->twig = $container['view'];
    }
}