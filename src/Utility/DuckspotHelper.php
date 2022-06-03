<?php

namespace Drupal\duckspot\Utility;

/**
 * Class DuckspotHelper.
 */
class DuckspotHelper
{
    private $client_id;
    private $client_secret;
    private static $artists = array();

    /* Constructor */
    public function __construct()
    {
        $this->client_id = 'ea1ebf722c464c3fb8a85f612d42871d';
        $this->client_secret = 'f84be1b9668743c9a7d015df3170c3b7';
        $this->artists = array(
            '7xGGqA85UIWX1GoTVM4itC', // staple singers
            '2wzMOQwNT6ZvVB4amvhFAH', // pogues
            '6TKOZZDd5uV5KnyC5G4MUt', // smokey robinson
        );
    }

    /* Getter function to read the client id */
    public function get_id()
    {
        return $this->client_id;
    }

    /* Getter function to read the client secret */
    public function get_secret()
    {
        return $this->client_secret;
    }
}
