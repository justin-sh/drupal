<?php
/**
 * Created by PhpStorm.
 * User: Amber
 * Date: 2019-07-21
 * Time: 15:24
 */

namespace Drupal\hello\Controller;


use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase
{
    public function sayHello()
    {
        \Drupal::logger("hello")->info("in hello.sayhello");
        return [
            '#theme' => 'sayhello',
            '#markup' => hello_hello_world(),
            '#test1' => 'test111'
        ];
    }

    public function welcome()
    {
        return [
            '#markup' => hello_welcome()
        ];
    }

    public function create_node()
    {
        return array(
            '#markup' => hello_create_node(),
        );
    }

    public function create_file()
    {
        return array(
            '#markup' => hello_create_file(),
        );
    }

    public function add_taxonomy_term()
    {
        return array(
            '#markup' => hello_add_taxonomy_term(),
        );
    }

    public function create_menu_link()
    {
        return array(
            '#markup' => hello_create_menu_link(),
        );
    }

}