<?php

namespace Codersgarden\PhpLexofficeApi;

use GuzzleHttp\Exception\RequestException;

class LexofficePrintLayoutManager extends LexofficeBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retrieve all print layouts.
     *
     * This method sends a GET request to the `print-layouts` endpoint to fetch a list of all available print layouts.
     * It returns the data from the API response or an error message if the request fails.
     *
     * ### Return Values:
     * - On success:
     *   - `success` (bool): Returns `true` indicating the request was successful.
     *   - `data` (array): Contains the response data, which includes the list of print layouts.
     *     Example:
     *     ```php
     *     [
     *         'success' => true,
     *         'data' => [
     *             ['id' => '383111c2-5c4b-4775-adc8-9a1da548d253', 'name' => 'Standard', 'default' => true],
     *         ],
     *     ]
     *     ```
     * - On failure:
     *   - `success` (bool): Returns `false` indicating the request failed.
     *   - `status` (int|null): The HTTP status code returned by the API.
     *   - `error` (string): The error message provided by the API or the exception message.
     *     Example:
     *     ```php
     *     [
     *         'success' => false,
     *         'status' => 500,
     *         'error' => 'Internal server error',
     *     ]
     *     ```
     *
     * @return array An array containing the result of the request, either the print layouts or an error message.
     */


    public function all()
    {
        try {

            $response = $this->client->get("print-layouts");
            return [
                'success' => true,
                'data' => json_decode($response->getBody()->getContents(), true),
            ];
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $errorData = $response ? json_decode($response->getBody()->getContents(), true) : $e->getMessage();

            return [
                'success' => false,
                'status' => $response ? $response->getStatusCode() : $e->getCode(),
                'error' => $errorData['message'] ?? $e->getMessage(),
            ];
        }
    }
}
