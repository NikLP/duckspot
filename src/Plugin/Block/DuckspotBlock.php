<?php

namespace Drupal\duckspot\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

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
      '#default_value' => $config['duckspot_block_num_artists'] ?? '5',
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

    $artist_list = $this->_fetch_artists($limit);

    return [
      '#theme' => 'duckspot_block_artists',
      '#body_text' => [
        '#markup' => $this->t('Showing @num artists', ['@num' => $limit,]),
      ],
      '#artists' => $artist_list,
    ];
  }

  protected function _fetch_artists(int $limit)
  {

    // fetch $limit artists from api

    // $response = $this->httpClient->request('GET', 'https://api.spotify.com/v1/artists', [
    //   'limit' => $limit,
    //   'sort' => $sort,
    // ]);

    // build array
    // return array

    $artist_list = [
      0 => [
        'name' => 'Jed',
        'genre' => 'Country',
        'url' => '/artist/1',
      ],
      1 => [
        'name' => 'Jon',
        'genre' => 'Rock',
        'url' => '/artist/2',
      ],
      2 => [
        'name' => 'Ted',
        'genre' => 'Bluegrass',
        'url' => '/artist/3',
      ],
    ];

    return $artist_list;
  }
}
