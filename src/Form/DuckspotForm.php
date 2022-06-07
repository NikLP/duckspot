<?php

/**  
 * @file  
 * Contains Drupal\duckspot\Form\DuckspotForm.  
 */

namespace Drupal\duckspot\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class DuckspotForm extends ConfigFormBase
{
    /**  
     * {@inheritdoc}  
     */
    protected function getEditableConfigNames()
    {
        return [
            'duckspot.settings',
        ];
    }

    /**  
     * {@inheritdoc}  
     */
    public function getFormId()
    {
        return 'duckspot_settings_form';
    }

    /**  
     * {@inheritdoc}  
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('duckspot.settings');

        $form['client_id'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Spotify app client ID'),
            '#description' => $this->t('Enter your Spotify app client ID'),
            '#default_value' => $config->get('client_id') ?? '',
            '#maxlength' => 32,
            '#size' => 32,
        ];

        $form['client_secret'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Spotify app client secret'),
            '#description' => $this->t('Enter your Spotify app client secret'),
            '#default_value' => $config->get('client_secret') ?? '',
            '#maxlength' => 32,
            '#size' => 32,
        ];

        return parent::buildForm($form, $form_state);
    }

    /**  
     * {@inheritdoc}  
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        parent::submitForm($form, $form_state);

        $this->config('duckspot.settings')
            ->set('client_id', $form_state->getValue('client_id'))
            ->set('client_secret', $form_state->getValue('client_secret'))
            ->save();
    }
}
