<?php

namespace Drupal\duckspot\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DuckspotController.
 */
class DuckspotController extends ControllerBase
{

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
      '#artist' => $this->t('Artist page controller output 2'),
      '#id' => $id
    ];
  }
}
