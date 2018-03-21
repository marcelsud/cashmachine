## CashMachine

### How to run and test the solution

#### Endpoint

```
GET /withdraw?amount={value}
```

#### Using docker (which makes life easier):

Unit tests:

```
docker run -w /app -it marcelsud/cashmachine-api php vendor/bin/phpspec run
```

Application:

```
docker run -it -p 8080:80 marcelsud/cashmachine-api

open localhost:8080/withdraw?amount={value}
```

#### To run it the old way:

Setup:

```
composer install
```

Unit tests:

```
php vendor/bin/phpspec run
```

Application:

```
php -S 0.0.0.0:8080 public/index.php

open localhost:8080/withdraw?amount={value}
```
