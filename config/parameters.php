<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/_data/*');

    $parameters = $containerConfigurator->parameters();

    # imported also by statie.yml - needs to be standalone
    # how many days into the future the meetups should be imported
    $parameters->set('max_forecast_days', 30);

    $parameters->set('groups_storage', __DIR__ . '/../config/_data/groups.yaml');

    $parameters->set('meetups_storage', __DIR__ . '/../config/_data/meetups.yaml');

    # its still public in the footer, so no need to hide it
    # setup & manage here: https://console.cloud.google.com/apis/credentials
    $parameters->set('google_api_key', 'AIzaSyA6vhz7PGvf5rHjfnX6Ye6j6Gz2WVvIRvY');
};
