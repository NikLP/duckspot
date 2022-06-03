<?php

namespace Drupal\duckspot\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\duckspot\Utility\DuckspotHelper;

/**
 * Class DuckspotController.
 */
class DuckspotController extends ControllerBase
{
  private $helper;
  private $client;

  /**
   * DuckspotController constructor.
   */
  public function __construct() {
    $this->helper = new DuckspotHelper();
    $this->client = \Drupal::httpClient();
  }

//   $response = $client->request('POST', 'http://httpbin.org/post', [
//     'form_params' => [
//         'field_name' => 'abc',
//         'other_field' => '123',
//         'nested_field' => [
//             'nested' => 'hello'
//         ]
//     ]
// ]);

  /**
   * Artist page.
   *
   * @return string
   *   Return Hello string.
   */
  public function ArtistPage($id)
  {


    
    return [
      '#theme' => 'duckspot_page_artist',
      '#artist' => $this->t('Artist page controller output'),
      '#id' => $id,
    ];
  }
}
