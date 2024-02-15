<?php

namespace App\Services;

use GuzzleHttp\Client;

class ClipDropService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://clipdrop-api.co/',
            'headers' => [
                'x-api-key' => config('services.clipdrop_api_key'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }


    public function cleanupImage($imageUrl, $maskUrl)
    {
        $response = $this->client->post('cleanup/v1', [
            'multipart' => [
                [
                    'name' => 'image_file',
                    'contents' => fopen(storage_path('app/public/' . $imageUrl), 'r'),
                ],
                [
                    'name' => 'mask_file',
                    'contents' => fopen(storage_path('app/public/' . $maskUrl), 'r'),
                ],
            ],
        ]);

        return $this->saveImageResponse($response->getBody(), 'cleaned_images', $imageUrl);
    }

    public function removeBackground($imageUrl)
    {
        // Read image contents
        $imageContents = file_get_contents(storage_path('app/public/' . $imageUrl));

        $response = $this->client->post('remove-background/v1', [
            'multipart' => [
                    [
                        'name'     => 'image_file',
                        'contents' => $imageContents,
                        'filename' => basename($imageUrl),
                    ],
                ],
        ]);

        return $this->saveImageResponse($response->getBody(), 'remove_background', $imageUrl);
    }

    protected function saveImageResponse($imageData, $subDirectory, $originalImageUrl)
    {
        $directory = storage_path('app/public/' . $subDirectory);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($originalImageUrl);
        $filePath = $directory . '/' . $fileName;
        file_put_contents($filePath, $imageData);

        return asset('storage/' . $subDirectory . '/' . $fileName);
    }
}
