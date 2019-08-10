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
 *   id = "hello_block",
 *   admin_label = @Translation("Hello Block")
 * )
 */
class HelloBlock extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        return [
            '#markup' => $this->_populate_markup()
        ];
    }

    private function _populate_markup()
    {
        $user = User::load(\Drupal::currentUser()->id());

        if ($user->get('uid')->value < 1) {
            $user_information = 'Welcome Visitor!<br/>';
            return $user_information . 'The current time is: ' . date('m-d-Y h:i:s', time());
        }
        $user_information = 'User Name: ' . $user->getUsername() . '<br/>';
        $user_information .= 'Language: ' . $user->getPreferredLangcode() . '<br/>';
        $user_information .= 'Email: ' . $user->getEmail() . '<br/>';
        $user_information .= 'TimeZone: ' . $user->getTimeZone() . '<br/>';
        $user_information .= 'Created: ' . date('m-d-Y h:i:s', $user->getCreatedTime()) . '<br/>';
        $user_information .= 'Updated: ' . date('m-d-Y h:i:s', $user->getChangedTime()) . '<br/>';
        $user_information .= 'Last Login:' . date('m-d-Y h:i:s', $user->getLastLoginTime()) . '<br/>';

        $roles = null;
        foreach ($user->getRoles() as $role) {
            $roles .= $role . ',';
        }

        $roles = 'Roles: ' . rtrim($roles, ',');

        $user_information .= $roles;

        return $user_information;
    }
}