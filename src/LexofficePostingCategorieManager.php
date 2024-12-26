<?php

namespace Codersgarden\PhpLexofficeApi;

use GuzzleHttp\Exception\RequestException;

class LexofficePostingCategorieManager extends LexofficeBase
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Retrieve all posting categories.
     *
     * This method sends a GET request to the `posting-categories` endpoint to fetch a list of all available posting categories.
     * It returns the data from the API response or an error message if the request fails.
     *
     * ### Return Values:
     * - On success:
     *   - `success` (bool): Returns `true` indicating the request was successful.
     *   - `data` (array): Contains the response data, which includes the list of posting categories.
     *     Example:
     *     ```php
     *     [
     *         'success' => true,
     *         'data' => [
     *             [
     *               'id' => 'efa82f42-fd85-11e1-a21f-0800200c9a66, 
     *               'name' => 'Material/Waren',
     *               'type' => 'outgo', 
     *               'contactRequired' => 'false',
     *               'splitAllowed' => 'true',
     *                'groupName': 'Material/Waren'
     *               ],
     *              [
     *                'id' => '97704fd4-0e83-4c5b-a09c-1b4289644d10, 
     *                'name' => 'Materialeinkauf',
     *                 'type' => 'outgo', 
     *                 'contactRequired' => 'false',
     *                 'splitAllowed' => 'true',
     *                 'groupName': 'Material/Waren'
     *  ],
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
     * @return array An array containing the result of the request, either the posting categories or an error message.
     */

    public function all()
    {
        try {

            $response = $this->client->get("posting-categories");
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
