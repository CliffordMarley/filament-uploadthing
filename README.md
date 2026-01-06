# FilamentPHP UploadThing Plugin

A FilamentPHP 4 plugin that integrates UploadThing for seamless file uploads.

## Installation

1. Install via Composer:
```bash
composer require cliffthecoder/filament-uploadthing
```

2. Publish the config:
```bash
php artisan vendor:publish --tag="filament-uploadthing-config"
```

3. Add your UploadThing API key to `.env`:
```
UPLOADTHING_API_KEY=your_api_key_here
```

## Usage

In your Filament resource form:

```php
use CliffTheCoder\FilamentUploadThing\Forms\Components\UploadThingFileUpload;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            UploadThingFileUpload::make('attachment')
                ->label('Upload File')
                ->acceptedFileTypes(['image/*', 'application/pdf'])
                ->maxFileSize(5 * 1024 * 1024) // 5MB
                ->multiple()
                ->maxFiles(5),
        ]);
}
```

## Features

- Drag & drop file upload
- Multiple file support
- File type restrictions
- File size validation
- Upload progress indicator
- Direct integration with UploadThing API
- Seamless Filament UI integration

## Configuration

The plugin can be configured in `config/filament-uploadthing.php`.

## Building Assets

If you modify the JavaScript:

```bash
npm install
npm run build
```

## License

MIT