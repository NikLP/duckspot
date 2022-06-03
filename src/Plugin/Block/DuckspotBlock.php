<?php

namespace Drupal\duckspot\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\duckspot\Utility\DuckspotHelper;

/**
 * Provides a 'DuckspotBlock' block.
 *
 * @Block(
 *  id = "duckspot_block",
 *  admin_label = @Translation("Duckspot block"),
 * )
 */
class DuckspotBlock extends BlockBase
{
  private $helper;

  /**
   * DuckspotBlock constructor.
   */
  public function __construct()
  {
    $this->helper = new DuckspotHelper();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $form['duckspot_block_num_artists'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of Artists'),
      '#description' => $this->t('Select the number of artists to display (up to 20, in steps of 5).'),
      // '#default_value' => $config['duckspot_block_num_artists'] ?? '5',
      '#min' => 5,
      '#max' => 20,
      '#step' => 5,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['duckspot_block_num_artists'] = $values['duckspot_block_num_artists'];
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state)
  {
    if ($form_state->getValue('duckspot_block_num_artists') > 20) {
      $form_state->setErrorByName('duckspot_block_num_artists', $this->t('You are not permitted more than 20 artists.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $config = $this->getConfiguration();

    // if for some reason the block is not configured properly, add a sane default value

    if (!empty($config['duckspot_block_num_artists'])) {
      $limit = $config['duckspot_block_num_artists'];
    } else {
      $limit = 5;
    }

    // artist list will be key/val array of name/id
    $artist_list = $this->helper->get_artists($limit);

    return [
      '#theme' => 'duckspot_block_artists',
      '#body_text' => [
        '#markup' => $this->t('Showing @num artists', ['@num' => $limit,]),
      ],
      '#artists' => $artist_list,
    ];
  }

}
