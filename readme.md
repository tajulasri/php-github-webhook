## Github webhook php


```php
composer install
```

sample of usages
```php	
use Illuminate\Http\Request;

$webhook = (new \WebhookHanlder\GithubWebhook(new Request))->setCredentials(['secret_token' => ''])->start();
```

too see what happen?Workaround with http request.

```php

php -S localhost:8080 

```

```javascript

//payload dump
array(34) {
  ["USER"]=>
  string(8) "www-data"
  ["HOME"]=>
  string(8) "/var/www"
  ["HTTP_CONTENT_LENGTH"]=>
  string(4) "7303"
  ["HTTP_X_HUB_SIGNATURE"]=>
  string(45) "sha1=59baee686dc288a3e7b4fe5a501663f2de47117d"
  ["HTTP_CONTENT_TYPE"]=>
  string(16) "application/json"
  ["HTTP_X_GITHUB_DELIVERY"]=>
  string(36) "3c5cd3e0-720c-11e7-8f6b-1761961552df"
  ["HTTP_X_GITHUB_EVENT"]=>
  string(4) "push"
  ["HTTP_USER_AGENT"]=>
  string(23) "GitHub-Hookshot/62709df"
  ["HTTP_ACCEPT"]=>

```