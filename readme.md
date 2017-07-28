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

