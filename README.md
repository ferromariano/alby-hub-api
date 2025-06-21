AlbyHubClient
=============

Client AlbyHub 

Example
-------

```php
<?php

use AlbyHubApiClient\albyHubClient;

$client = new albyHubClient(
    'http://url/',
    'XXXXXXXXXXXXXXXX_TOKEN_XXXXXXXXXXXXXXXXXXXXXX'
);


var_dump($client->getSpendables());

```



Resources
---------

 * [Alby/hub](https://github.com/getAlby/hub)
 * Documentation: Unfortunately Alby Hub does not present any documentation about its API, this client was made by reading the code
