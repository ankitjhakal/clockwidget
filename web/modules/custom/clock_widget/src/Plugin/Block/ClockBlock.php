<?php

namespace Drupal\clock_widget\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Clock Block' block.
 *
 * @Block(
 *   id = "clock_block",
 *   admin_label = @Translation("Clock Block"),
 *   category = @Translation("Clock Widget"),
 * )
 */
class ClockBlock extends BlockBase {

  /**
  * {@inheritdoc}
  */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    // Retrieve the block's configuration.
    $config = $this->getConfiguration();
    $options = [
      'est' => 'EST',
      'utc' => 'UTC',
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

    return [
      '#theme' => 'clock_block',
      '#unique_id' => $timezone,
      '#attached' => [
        'library' => [
          'clock_widget/clock-widget',
          'clock_widget/clock-widget-' . $timezone,
        ],
      ],
    ];
  }
}
