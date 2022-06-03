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
    private $artists;

    /* Constructor */
    public function __construct()
    {
        $this->client = \Drupal::httpClient();
        $this->client_id = 'ea1ebf722c464c3fb8a85f612d42871d';
        $this->client_secret = 'f84be1b9668743c9a7d015df3170c3b7';
        $this->artists = array(
            '7xGGqA85UIWX1GoTVM4itC', // staple singers (1 of 21)
            '2wzMOQwNT6ZvVB4amvhFAH', // pogues
            '6TKOZZDd5uV5KnyC5G4MUt', // smokey robinson
            '7FAkzV0YOw0EIXFhmY4RE3', // jermaine stewart
            '44NX2ffIYHr6D4n7RaZF7A', // van morrison :(
            '6f8l45N3qZB1xSCH1qFCFB', // tracey ullman
            '3qUMmh5biaB5hqpF4LqS3m', // julie london
            '3dBVyJ7JuOMt4GE9607Qin', // t-rex
            '7guDJrEfX3qb6FEbdPA5qi', // stevie wonder
            '2CkhxuagMCG9uvlbKm5G3m', // imagination
            '0oSGxfWSnnOXhD2fKuz2Gy', // david bowie
            '5t06MTkDD3yr5LVs3YFLQC', // divinyls
            '0nyc9SZGLITSOJASmTZsnZ', // LEN
            '0O0lrN34wrcuBenkqlEDZe', // psychedelic furs
            '3RGLhK1IP9jnYFH4BRFJBS', // clash
            '776Uo845nYHJpNaStv1Ds4', // jimi hendrix
            '5z1VAFwT35EVvCp1XlZZuL', // diana krall
            '2cnMpRsOVqtPMfq7YiFE6K', // van halen
            '3xs0LEzcPXtgNfMNcHzLIP', // rockwell
            '60df5JBRRPcnSpsIMxxwQm', // otis redding
            '2AV6XDIs32ofIJhkkDevjm', // curtis mayfield
        );
    }

    /* Let's get a token for querying the API */
    private function get_auth()
    {
        try {
            $auth = $this->client->request('POST', 'https://accounts.spotify.com/api/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                ]
            ]);

            return json_decode($auth->getBody());
        } catch (GuzzleException $e) {
            return \Drupal::logger('duckspot')->error($e);
        }
    }

    /* function to get a list of artists from err NOT spotify */
    public function get_artists(int $limit)
    {
        // there's no "get a lot of artists out of nothing" api call so we've had to do this sadly.

        $random = $this->artists;
        shuffle($random);
        $ids = array_slice($random, 0, $limit);
        dpm($ids);

        $auth = $this->get_auth();

        // try {
        //     $request = $this->client->request('GET', 'https://api.spotify.com/v1/artists/' . $id, [
        //         'headers' => [
        //             'Authorization' => $auth->token_type . ' ' . $auth->access_token,
        //         ]
        //     ]);
        //     $artist = json_decode($request->getBody()); //true?
        // } 

        // catch (GuzzleException $e) {
        //     return \Drupal::logger('duckspot')->error($e);
        // }

        return $artists;

    }

    public function get_artist_details($id)
    {
        $auth = $this->get_auth();

        try {
            $request = $this->client->request('GET', 'https://api.spotify.com/v1/artists/' . $id, [
                'headers' => [
                    'Authorization' => $auth->token_type . ' ' . $auth->access_token,
                ]
            ]);
            $artist = json_decode($request->getBody(), true);
        } catch (GuzzleException $e) {
            return \Drupal::logger('duckspot')->error($e);
        }

        return $artist;
    }
}
