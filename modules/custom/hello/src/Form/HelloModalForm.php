<?php
/**
 * Created by PhpStorm.
 * User: Amber
 * Date: 2019-07-21
 * Time: 17:08
 */

namespace Drupal\hello\Form;


use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class HelloModalForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'hello_modal_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
        $form['node_title'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Node\'s title'),
            '#description' => $this->t('Enter a portion of the title to search for'),
        ];
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Search'),
            '#ajax' => [ // here we add Ajax callback where we will process the data that came from the form
                'callback' => '::open_modal',  // and that we will receive as a result in the modal window
            ],
        ];
        $form['#title'] = 'Search for Node by Title';

        return $form;
    }

    public function open_modal(array &$form, FormStateInterface $form_state)
    {
        $node_title = $form_state->getValue('node_title');
        $query = \Drupal::entityQuery('node')->condition('title', $node_title, 'CONTAINS');
        $entity = $query->execute();
        $key = array_keys($entity);
        $id = !empty($key[0]) ? $key[0] : NULL;
        $response = new AjaxResponse();
        $title = 'Node ID';
        if ($id !== NULL) {
            $content = '<div class="test-popup-content"> Node ID is: ' . $id . '</div>';
            $options = array(
                'dialogClass' => 'popup-dialog-class',
                'width' => '300',
                'height' => '300',
            );

            $response->addCommand(new OpenModalDialogCommand($title, $content, $options));
        } else {
            $content = 'Not found record with this title <strong>' . $node_title . '</strong>';
            $options = array(
                'dialogClass' => 'popup-dialog-class',
                'width' => '300',
                'height' => '300',
            );
            $response->addCommand(new OpenModalDialogCommand($title, $content, $options));
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public
    function submitForm(array &$form, FormStateInterface $form_state)
    {
        // TODO: Implement submitForm() method.
    }
}