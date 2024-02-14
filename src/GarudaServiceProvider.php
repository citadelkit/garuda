<?php

namespace CitadelKit\Garuda;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use CitadelKit\Garuda\Commands\GarudaCommand;

class GarudaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('garuda')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_garuda_table')
            ->hasCommand(GarudaCommand::class);
    }
}
