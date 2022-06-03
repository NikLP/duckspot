<?php

namespace Drupal\duckspot\Utility;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Class DuckspotHelper.
 */
class DuckspotHelper
{
    private $client;
    private $client_id;
    private $client_secret;
    private static $artists = array();

    /* Constructor */
    public function __construct()
    {
        $this->client = \Drupal::httpClient();
        $this->client_id = 'ea1ebf722c464c3fb8a85f612d42871d';
        $this->client_secret = 'f84be1b9668743c9a7d015df3170c3b7';
        $this->artists = array(
            '7xGGqA85UIWX1GoTVM4itC', // staple singers
            '2wzMOQwNT6ZvVB4amvhFAH', // pogues
            '6TKOZZDd5uV5KnyC5G4MUt', // smokey robinson
        );
    }

    private function get_auth()
    {
        try {
            $authorization = $this->client->request('POST', 'https://accounts.spotify.com/api/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',

                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                ]
            ]);

            return $response = json_decode($authorization->getBody());
        } catch (GuzzleException $e) {
            return \Drupal::logger('sdfdsf')->error($e);
        }
    }

    public function get_artists(int $limit)
    {
        $random = $this->artists; // copy not reference
        shuffle($random);
        return array_slice($random, 0, 3);
        // return array_slice($random, 0, $limit);
    }
}
