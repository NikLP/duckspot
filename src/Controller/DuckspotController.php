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

  /**
   * DuckspotController constructor.
   */
  public function __construct()
  {
    $this->helper = new DuckspotHelper();
  }


  /**
   * Artist page.
   *
   * @return string
   *   Return Hello string.
   */
  public function ArtistPage($id)
  {
    $artist_details = $this->helper->get_artists($id);
    
    return [
      '#theme' => 'duckspot_page_artist',
      '#artist' => $this->t('Artist page controller output is'),
      '#id' => $id,
      //'#id' => $this->helper->get_secret(),
    ];
  }
}
