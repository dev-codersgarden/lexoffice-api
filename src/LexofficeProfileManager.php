<?php

namespace Codersgarden\PhpLexofficeApi;

use GuzzleHttp\Exception\RequestException;



class LexofficeProfileManager extends LexofficeBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
 * Retrieve profile information from the LexOffice API using Guzzle.
 *
 * This method sends a GET request to the "profile" endpoint of the LexOffice API
 * to fetch detailed profile information. It provides a structured response
 * indicating whether the request was successful or if an error occurred.
 *
 * ### Expected Response:
 * On success, this method returns an array containing profile details, including:
 * - `organizationId`: Unique identifier of the organization.
 * - `companyName`: Name of the registered company.
 * - `created`: Information about the user and connection establishment date.
 * - `connectionId`: The current API connection ID.
 * - `businessFeatures`: A list of features available to the organization.
 * - `taxType`: Configured tax type (e.g., net, gross, vatfree).
 * - `smallBusiness`: Indicates if the organization qualifies as a small business.
 *
 * ### Example of a Successful Response:
 * ```json
 * {
 *   "profiles": [
 *     {
 *       "organizationId": "7c0e3c8d-8fd9-4693-9b88-9376b90d1368",
 *       "companyName": "xyz",
 *       "created": {
 *         "userName": "xyz@example.de",
 *         "userId": "3c045123-ffd0-4230-bc2f-ce3c7f2eb9f2",
 *         "userEmail": "xyz@example.de",
 *         "date": "2024-11-26T12:07:09.302757Z"
 *       },
 *       "connectionId": "5bca1093-e7cb-4117-9165-0632fd699570",
 *       "businessFeatures": ["INVOICING", "BOOKKEEPING", "INVOICING_PRO"],
 *       "taxType": "net",
 *       "smallBusiness": false
 *     }
 *   ]
 * }
 * ```
 *
 * ### Example Usage:
 * ```php
 * $response = $lexofficeProfileManager->get();
 * if ($response['success']) {
 *     // Handle successful response
 *     print_r($response['data']);
 * } else {
 *     // Handle error
 *     echo 'Error: ' . $response['error'];
 * }
 * ```
 *
 * ### Return Value:
 * This method returns an associative array containing:
 * - `'success'` (bool): Indicates if the request was successful.
 * - `'data'` (array|null): The profile data returned by the API on success.
 * - `'status'` (int|null): HTTP status code if the request fails.
 * - `'error'` (string|null): Error message if the request fails.
 *
 * ### Parameters:
 * - This method does not require any input parameters, as it directly retrieves profile data.
 *
 * ### Error Handling:
 * If the request fails, this method captures the HTTP response status and error message
 * (if available) and returns them in the structured array.
 *
 * ### Dependencies:
 * This method requires the `GuzzleHttp\Client` instance to send the request to the API.
 *
 * @return array An associative array containing:
 *               - 'success' (bool): Indicates whether the request was successful.
 *               - 'data' (array|null): Profile data if the request is successful.
 *               - 'status' (int|null): HTTP status code on failure.
 *               - 'error' (string|null): Error message if the request fails.
 */



    public function get()
    {
        try {

            $response = $this->client->get("profile");

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
