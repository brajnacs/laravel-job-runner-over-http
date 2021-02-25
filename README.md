# Exposes all Laravel jobs over an HTTP endpoint

This package provides an POST endpoint. To which a job in the following format can be posted and this will run that Job.

```json
{
    "connection": "queue-connection-name",
    "queue": "queue-name",
    "payload": "job-payload"
}
```
Parameter `connection` and `queue` is ignored if laravel's native job is provided in the payload.

Wonder why this package? Laravel artisan job runner is quite shaky specially in push mode (ActiveMQ/RabbitMQ). 
It loses connection, crashes without any trace. So if you want to transfer the responsibility of running jobs to a
different language without rewriting your entire worker codebase. You can just expose these Jobs over an HTTP endpoint
and then you are free to use any method of fetching the jobs from the store and firing them over this endpoint.

## Installation

You can install the package via composer:

```bash
composer require brajmohan/laravel-job-runner-over-http
```

You can publish the routes with:

```bash
php artisan vendor:publish --provider="BrajMohan\LaravelJobRunnerOverHttp\LaravelJobRunnerOverHttpServiceProvider" --tag="laravel-job-runner-over-http-migrations"
```

Important: Don't forget to add the published routes file in your RouteServiceProvider

## Usage

It works out of the box. There is nothing you need to do apart from installing this package.
You can customize the route it exposes by publishing the routes file as described above.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Braj Mohan](https://github.com/brajnacs)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
