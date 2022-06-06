# 'Duckspot' module
[Aside, **ignore**] View site in gitpod (local @ gitpod only): gp preview $(gp url 8080)


## Assertions

Having read the Spotify docs about authorisation, and due to limitations in the environment (and not having an available source of information to query re the spec), I decided to use client credentials method, see:
https://developer.spotify.com/documentation/general/guides/authorization/
https://developer.spotify.com/documentation/general/guides/authorization/client-credentials/

In duckspot.routing.yml, we use a Base 62 regex to check the validity of the Artist ID passed to the controller, if it doesn’t match this generates a 404. 
See https://www.drupal.org/node/2399239, https://en.wikipedia.org/wiki/Base62 after https://developer.spotify.com/documentation/web-api/#spotify-uris-and-ids

Also in this file we are using a default value of 1, this is not ideal and ideally needs addressing.
https://www.drupal.org/docs/8/api/routing-system/parameters-in-routes/using-parameters-in-routes

Also it would be nice to be setting the title somewhere other than in this file!!


## Omissions 

In order for this module to be fully functional as a portable unit, it must have a distinct admin form to collect and store the spotify client id & secret values. These values are currently hard coded in the utility class (DuckspotHelper). The initial spec did not identify this feature as necessary functionality but that is relatively simple to add.

The module cannot at this time use full features of the Spotify API (e.g. obtain user centric data)... because the module does not reside at a fixed address, it has not been possible to access personal levels of the API, such as playlists. If the module was available at a fixed address, it would have been possible to add a form to collect a playlist ID or similar. With this, I could have queried the API and gotten a list of artist IDs. As such, this was not possible with the OAuth client_credentials method, so unfortunately I have had to also hard code the artists IDs in the utility class. This is because of a limitation in the Spotify API that prevents obtaining such information with this OAuth method without using a callback URL, which cannot be submitted without using a domain or similar. If there is a problem or oversight here it's something I could not immediately see a way around, but I didn't have any avenue to enquire about this.

Warnings from verbose - there are one or more warnings coming from PHP when error reporting is set to verbose which I haven't figured out yet
Help text - the help text is not implemented
Testing - no unit tests are provided
Check status of declaration (public, protected etc) - class function and variable declarations are functional but privacy may need adjustment


## Pseudo-code

This is just a quick breakdown of the spec into some basic tasks, as I wrote them for "rubber ducking" purposes.

#### Allow the admin to choose how many Artists they want to display using the FORM API when placing the block into a region. The admin shouldn’t be able to select more than 20 artists.

Create a custom Drupal module in /web/modules/custom
Add a custom block (php) class
Add a number field (NUM) to the block using FAPI
Enforce a ceiling of 20 on the field using form validation

#### Connect to ‘Spotify API’ and bring back the selected number of artists.

Store client credentials
Get access token
Create http request with limit of NUM
Check for errors etc

#### Display the Artists in a custom block and be clickable

Render request into block output
Render artist name as link to artist page, with artist ID in the link

#### If the user clicks on the Artist URL it should open a new page and display information about that artist on a custom page using routes.

Create routing for the links such that a link of e.g. /artist/[ID] can be handled by the module
Manage content for the route such that a new page will be displayed when the link is clicked, showing a variety of information about the artist as pulled from the API

#### The custom page should have its own permission and should only be accessible by logged in users.

This seems a little ambiguous; “its own permission” implies a permission specific to the module, but “only accessible by logged in users” can be satisfied by checking if the user is authenticated… I have created a custom permission but this must be set by admin after installation.
