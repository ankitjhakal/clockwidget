<?php

namespace Drupal\clock_widget\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Clock Widget Block' block.
 *
 * @Block(
 *   id = "clock_widget_block",
 *   admin_label = @Translation("Clock Widget Block"),
 *   category = @Translation("Clock Widget"),
 * )
 */
class ClockWidgetBlock extends BlockBase {

  /**
  * {@inheritdoc}
  */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    // Retrieve the block's configuration.
    $config = $this->getConfiguration();
    $options = [
      'America/Los_Angeles' => 'America/Los_Angeles',
      'Europe/Amsterdam' => 'Europe/Amsterdam',
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#options' => $options,
      '#required' => TRUE,
      '#title' => $this->t('Timezone:'),
      '#default_value' => $config['timezone'] ?? '',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $this->configuration['timezone'] = $form_state->getValue('timezone');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $timezone = $this->configuration['timezone'] ?? '';
    $cont = explode('/', $timezone)[0];
    $city = explode('/', $timezone)[1];
    return [
      '#theme' => 'clock_widget_block',
      '#attached' => [
        'library' => [
          'clock_widget/clock-time',
          'clock_widget/clock-widget-' . $city,
        ],
      ],
      '#cont' => $cont,
      '#city' => $city,
      '#cache' => [
        'contexts' => ['timezone'],
      ],
    ];
  }
}
