# Instagram API

## Description

Instagram API is a Instagram API call library.

## Requirements

* PHP 5.6 or higher
* Guzzle 6.2
* Registered Instagram Application

## Get started

### Installation

`composer require aainc/instagram`

### Initialize the class

```
<?php
use \Munouni\Instagram\Instagram;
$instagram = new Instagram([
    'client_id'     => 'YOUR_CLIENT_KEY',
    'client_secret' => 'YOUR_CLIENT_CECRET',
    'redirect_uri'  => 'YOUR_APP_REDIRECT_URI'
]);

$loginUrl = $instagram->getOAuthUrl();

// $loginUrl = $instagram->getOAuthUrl(['basic', 'public_content', 'follower_list', 'comments', 'relationships', 'likes']);
```

### Get Access Token

```
<?php
$code = $_GET['code'];
$token = $instagram->getOAuthToken($code);
```

### Call API

```
<?php
use \Munouni\Instagram\Instagram;
$instagram = new Instagram(['access_token' => 'YOUR_ACCESS_TOKEN']);
$response = $instagram->sendRequest('GET','/users/self');
$response = $instagram->sendRequest('GET','/tags/{tag-name}/', ['{tag-name}' => 'ミンゴス']);
$response = $instagram->sendRequest('GET','/tags/search',['q' => 'ミンゴス']);
```


## License

MIT License

Copyright (c) 2017 Allied Architects Co.,Ltd.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
