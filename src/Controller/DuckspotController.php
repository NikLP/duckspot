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
   *   Return render array of artist.
   */
  public function ArtistPage($id)
  {
    $artist_details = $this->helper->get_artist_details($id);
    // dpm($artist_details);

    return [
      '#theme' => 'duckspot_page_artist',
      '#artist' => $artist_details,
    ];
  }
}
