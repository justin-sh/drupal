<?php
/**
 * Created by PhpStorm.
 * User: Amber
 * Date: 2019-07-21
 * Time: 15:55
 */

namespace Drupal\hello\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\user\Entity\User;

/**
 * Provides a user details block.
 *
 * @Block(
 *   id = "hello_form_block",
 *   admin_label = @Translation("Hello Form Block")
 * )
 */
class HelloFormBlock extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        return \Drupal::formBuilder()->getForm('\Drupal\hello\Form\HelloPluginForm');
    }
}