<?php

namespace Drupal\site_location_time\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;  

/**
 * Class SiteSettingsForm.
 *
 * @package Drupal\site_location_time\Form
 */
class SiteSettingsForm extends ConfigFormBase {
   /**  
   * {@inheritdoc}  
   */  
  protected function getEditableConfigNames() {  
    return [  
      'site_location_time.settings',  
    ];  
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('site_location_time.settings');  
    $form['config_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => 'Settings',
    ];
    $form['config_fieldset']['country'] = [
      '#type' => 'textfield',
      '#title' => 'Country',
      '#default_value' => $config->get('country'),
    ];
    $form['config_fieldset']['city'] = [
      '#type' => 'textfield',
      '#title' => 'City',
      '#default_value' => $config->get('city'),
    ];
    $form['config_fieldset']['timezone'] = [
      '#type' => 'select',
      '#title' => 'Timezone',
      '#options' => [
        'none' => 'Select timezone',
        'America/Chicago' => 'America/Chicago',
        'America/New_York' => 'America/New_York',
        'Asia/Tokyo' => 'Asia/Tokyo',
        'Asia/Dubai' => 'Asia/Dubai',
        'Asia/Kolkata' => 'Asia/Kolkata',
        'Europe/Amsterdam' => 'Europe/Amsterdam',
        'Europe/Oslo' => 'Europe/Oslo',
        'Europe/London' => 'Europe/London',
      ],
      '#default_value' => $config->get('timezone'),
    ];
    $form['action'] = [
      "#type" => 'submit',
      '#value' => $this->t('Submit'),
    ];
        
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);  

    $this->config('site_location_time.settings')  
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
    
    \Drupal::messenger()->addMessage('Updated site settings', 'status');
  }
}
