<?php
/**
 * Created by PhpStorm.
 * User: Amber
 * Date: 2019-07-21
 * Time: 16:20
 */

namespace Drupal\hello\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class HelloPluginForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'hello_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        // Radios.
        $form['settings']['active'] = [
            '#type' => 'radios',
            '#title' => t('Poll status'),
            '#options' => [0 => $this->t('<div style="color: red;">Image</div>'), 1 => $this->t('Active')],
            '#description' => $this->t('Select either closed or active'),
            '#attributes' => ['data-save-cookie' => 'true',]
        ];

        $form['svg'] = [
            '#allowed_tags' => ['svg', 'metadata', 'path', 'g',
                'inkscape:grid', 'sodipodi:namedview', 'defs',
                'rdf:RDF','dc:format','dc:type','dc:title','cc:Work','sodipodi:namedview'
            ],
            '#markup' => '<svg
   xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:cc="http://creativecommons.org/ns#"
   xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
   xmlns:svg="http://www.w3.org/2000/svg"
   xmlns="http://www.w3.org/2000/svg"
   xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
   xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
   version="1.1"
   id="Capa_1" x="0px" y="0px" width="56" height="56" viewBox="0 0 56.000002 56.000002"
   xml:space="preserve"
   sodipodi:docname="single.svg"
   inkscape:version="0.92.3 (2405546, 2018-03-11)">
   <metadata id="metadata5130">
   <rdf:RDF>
   <cc:Work rdf:about="">
   <dc:format>image/svg+xml</dc:format>
   <dc:type
         rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
         <dc:title></dc:title>
        </cc:Work></rdf:RDF></metadata>
        <defs id="defs5128"></defs>
   <sodipodi:namedview   pagecolor="#ffffff" bordercolor="#666666" borderopacity="1" objecttolerance="10" gridtolerance="10" guidetolerance="10"
   inkscape:pageopacity="0" inkscape:pageshadow="2" inkscape:window-width="2560" inkscape:window-height="1377"
   id="namedview5126" showgrid="true"
   inkscape:zoom="11.780857" inkscape:cx="26.544501" inkscape:cy="47.883446" inkscape:window-x="-8" inkscape:window-y="-8"
   inkscape:window-maximized="1"
   inkscape:current-layer="Capa_1">
   <inkscape:grid type="xygrid" id="grid5132" /></sodipodi:namedview>
     <path
   inkscape:connector-curvature="0"
   id="path5091"
   d="m 27.490702,23.915117 c 6.491,0 11.752,-5.262 11.752,-11.752 0,-6.4900058 -5.262,-11.75100577 -11.752,-11.75100577 -6.49,0 -11.754,5.26199997 -11.754,11.75200577 0,6.49 5.264,11.751 11.754,11.751 z m 4.985,0.801 h -9.972 c -8.297,0 -15.047003,6.751 -15.047003,15.048 v 12.195 l 0.031,0.191 0.84,0.263 c 7.918003,2.474 14.797003,3.299 20.459003,3.299 11.059,0 17.469,-3.153 17.864,-3.354 l 0.785,-0.397 h 0.084 v -12.197 c 0.003,-8.297 -6.747,-15.048 -15.044,-15.048 z"
   sodipodi:nodetypes="sssssssscccsccccs" /><g id="g5095" transform="translate(0,-24.129995)"></g><g
   id="g5097"
   transform="translate(0,-24.129995)"></g><g
   id="g5099"
   transform="translate(0,-24.129995)"></g><g
   id="g5101"
   transform="translate(0,-24.129995)"></g><g
   id="g5103"
   transform="translate(0,-24.129995)"></g><g
   id="g5105"
   transform="translate(0,-24.129995)"></g><g
   id="g5107"
   transform="translate(0,-24.129995)"></g><g
   id="g5109"
   transform="translate(0,-24.129995)"></g><g
   id="g5111"
   transform="translate(0,-24.129995)"></g><g
   id="g5113"
   transform="translate(0,-24.129995)"></g><g
   id="g5115"
   transform="translate(0,-24.129995)"></g><g
   id="g5117"
   transform="translate(0,-24.129995)"></g><g
   id="g5119"
   transform="translate(0,-24.129995)"></g><g
   id="g5121"
   transform="translate(0,-24.129995)"></g><g
   id="g5123"
   transform="translate(0,-24.129995)"></g></svg>'
        ];


        // Group submit handlers in an actions element with a key of "actions" so
        // that it gets styled correctly, and so that other modules may add actions
        // to the form.
        $form['actions'] = [
            '#type' => 'actions',
        ];
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
        ];
        $form['actions']['cancel'] = [
            '#type' => 'submit',
            '#value' => $this->t('Cancel'),
        ];
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $job_title = $form_state->getValue('job_title');
        if (strlen($job_title) < 5) {
            // Set an error for the form element with a key of "title".
            $form_state->setErrorByName('job_title', $this->t('Your job title must be at least 5 characters long.'));
        }
    }


    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $messageService = \Drupal::messenger();

        // Find out what was submitted.
        $values = $form_state->getValues();
        foreach ($values as $key => $value) {
            $label = isset($form[$key]['#title']) ? $form[$key]['#title'] : $key;
            // Many arrays return 0 for unselected values so lets filter that out.
            if (is_array($value)) {
                $value = array_filter($value);
            }
            // Only display for controls that have titles and values.
            if ($value && $label) {
                $display_value = is_array($value) ? preg_replace('/[\n\r\s]+/', ' ', print_r($value, 1)) : $value;
                $message = $this->t('Value for %title: %value', array('%title' => $label, '%value' => $display_value));
                $messageService->addMessage($message);
            }
        }
    }
}