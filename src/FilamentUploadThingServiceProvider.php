<?php

namespace CliffTheCoder\FilamentUploadThing;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentUploadThingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-uploadthing')
            ->hasConfigFile()
            ->hasViews();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Js::make('filament-uploadthing', __DIR__ . '/../resources/dist/filament-uploadthing.js'),
        ], 'cliffthecoder/filament-uploadthing');
    }
}