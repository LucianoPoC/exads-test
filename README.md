# exads-test
Candidate test for Senior PHP Developer position at Exads

## Running docker containers
```docker
docker-compose up -d
```
This command will setup instances of MySQL, Nginx and PHP-FPM.

Before that you may be able to access: ``localhost:8080``

## Unit tests

Inside the php container we can run the unit test suite:

```docker
docker-compose exec php bin/phpunit --testdox
```

## Challenges

### FizzBuzz
```docker
docker-compose exec php bin/console exads:challenge:fizzbuzz 100
```

### 500 Element Array

[Searching](./app/src/Searching/Searching.php)

### Database Connectivity

To setup the schema and populate the table with fixture data:
```docker
docker-compose exec php bin/console exads:challenge:database:create
```

Query the table:
```docker
docker-compose exec php bin/console exads:challenge:database:query
```

### Date Calculation

[IrishLottery](./app/src/Lottery/IrishLottery.php)

### A/B Testing

[Controller](./app/src/DistributedTraffic/DistributedTrafficController.php)
