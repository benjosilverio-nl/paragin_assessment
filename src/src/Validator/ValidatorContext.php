<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use RuntimeException;

/**
 * Selects the correct validator strategy for an uploaded file based on its mime type.
 */
final class ValidatorContext
{
    /**
     * Creates the validator context with the mime configuration and available strategies.
     *
     * @param array<int, array<string, mixed>> $config The validation configuration keyed by mime type.
     * @param iterable $strategies The validator strategies available to the application.
     */
    public function __construct(private array $config, private iterable $strategies){}

    /**
     * Validates an uploaded file by matching its mime type to a configured strategy.
     *
     * @param UploadedFile $file The uploaded file to validate.
     * @throws RuntimeException When no validator matches the uploaded file type.
     * @return void
     */
    public function validate(UploadedFile $file): void
    {
        foreach($this->config as $settings) {
            if($file->getClientMimeType() === $settings['mime']) {
                foreach($this->strategies as $strategy) {
                    if($strategy::class === $settings['validator']) {
                        $strategy->validate($file, $settings['max_size']);
                        return;
                    }
                }
            }
        }        

        throw new RuntimeException('Invalid file type: ' . $file->getClientMimeType());
    }
}