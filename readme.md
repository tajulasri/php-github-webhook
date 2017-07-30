## Github webhook php

```php
composer install
```
Sample of usages
```php	
use Illuminate\Http\Request;

$webhook = (new \WebhookHanlder\GithubWebhook(new Request))
  ->setCredentials(['secret_key' => 'my-secret-key'])
  ->handle()
  ->getResponse();

```

What is happen behind request during webhook? Lets simulate using fake payload transport via curl on localhost:8080.

```php
php -S localhost:8080 
```

## Generate mock secret key and payload
```php
php -r "echo hash_hmac('sha1','{"data": "sample_response"}','testing');"
```

## set credentials by using __testing__ in this case.
```php  
use Illuminate\Http\Request;

$webhook = (new \WebhookHanlder\GithubWebhook(new Request))
  ->setCredentials(['secret_key' => 'my-secret-key'])
  ->handle()
  ->getResponse();
```

## Get signature validation 
```php

$webhook = (new GithubWebhook(new Request))
    ->setCredentials(['secret_key' => 'testing'])
    ->handle()
    ->passes();

```
## Request via curl by sending fake header and payload.

```php
 curl -X POST localhost:8080 \ 
 -H 'HTTP_X_HUB_SIGNATURE: sha1=40cf35581833746c71a4c3c53886fe2a2e207577' \
 -H 'Content-type: application/json' -d '{"data": "sample_response"}'
```

```javascript

//header content dump
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