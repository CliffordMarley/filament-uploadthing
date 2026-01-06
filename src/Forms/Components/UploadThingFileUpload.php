<?php

namespace CliffTheCoder\FilamentUploadThing\Forms\Components;

use Filament\Forms\Components\Field;

class UploadThingFileUpload extends Field
{
    protected string $view = 'filament-uploadthing::forms.components.uploadthing-file-upload';

    protected string | \Closure | null $endpoint = null;
    protected array | \Closure $acceptedFileTypes = [];
    protected int | \Closure | null $maxFileSize = null;
    protected int | \Closure | null $maxFiles = 1;

    public function endpoint(string | \Closure | null $endpoint): static
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function getEndpoint(): ?string
    {
        return $this->evaluate($this->endpoint) ?? config('filament-uploadthing.default_endpoint');
    }

    public function acceptedFileTypes(array | \Closure $types): static
    {
        $this->acceptedFileTypes = $types;
        return $this;
    }

    public function getAcceptedFileTypes(): array
    {
        return $this->evaluate($this->acceptedFileTypes);
    }

    public function maxFileSize(int | \Closure | null $size): static
    {
        $this->maxFileSize = $size;
        return $this;
    }

    public function getMaxFileSize(): ?int
    {
        return $this->evaluate($this->maxFileSize) ?? config('filament-uploadthing.max_file_size');
    }

    public function maxFiles(int | \Closure $max): static
    {
        $this->maxFiles = $max;
        return $this;
    }

    public function getMaxFiles(): int
    {
        return $this->evaluate($this->maxFiles);
    }

    public function multiple(bool | \Closure $condition = true): static
    {
        $this->maxFiles = fn () => $this->evaluate($condition) ? 10 : 1;
        return $this;
    }
}