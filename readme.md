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
 -H 'X-Hub-Signature: sha1=40cf35581833746c71a4c3c53886fe2a2e207577' \
 -H 'Content-type: application/json' -d '{"data": "sample_response"}'
```

