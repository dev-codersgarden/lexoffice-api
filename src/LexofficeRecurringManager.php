<?php

namespace Codersgarden\PhpLexofficeApi;

use GuzzleHttp\Exception\RequestException;

class LexofficeRecurringManager extends LexofficeBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retrieve a specific recurring template by its ID.
     *
     * This method sends a GET request to the `recurring-templates/{id}` endpoint to fetch a recurring template
     * based on the provided ID. It returns the data from the API response or an error message if the request fails.
     *
     * ### Return Values:
     * - On success:
     *   - `success` (bool): Returns `true` indicating the request was successful.
     *   - `data` (array): Contains the response data, which includes the details of the recurring template.
     *     Example:
     *     ```php
     *     [
     *         'success' => true,
     *         'data' => [
     *            "id" => "ac1d66a8-6d59-408b-9413-d56b1db7946f",
     *            "organizationId" => "a3d94eb4-98bc-429e-b7ad-17f1a8463af9",
     *            "createdDate" => "2023-02-10T14:29:03.114+01:00",
     *            "updatedDate" => "2023-02-10T14:29:03.143+01:00",
     *            "version" => 1,
     *            "language" => "de",
     *            "archived" => false,
     *            "address" => [
     *                "contactId" => "df315523-1e92-473a-9d00-052212da84f8",
     *                "name" => "Haufe-Lexware GmbH & Co. KG",
     *                "street" => "Munzingerstraße 8",
     *                "city" => "Freiburg",
     *                "zip" => "79111",
     *                "countryCode" => "DE"
     *            ],
     *            "lineItems" => [
     *                [
     *                    "type" => "custom",
     *                    "name" => "Schulung",
     *                    "quantity" => 6,
     *                    "unitName" => "Stunde",
     *                    "unitPrice" => [
     *                        "currency" => "EUR",
     *                        "netAmount" => 100.84,
     *                        "grossAmount" => 120,
     *                        "taxRatePercentage" => 19
     *                    ],
     *                    "discountPercentage" => 0,
     *                    "lineItemAmount" => 720.00
     *                ]
     *            ],
     *            "totalPrice" => [
     *                "currency" => "EUR",
     *                "totalNetAmount" => 605.04,
     *                "totalGrossAmount" => 720,
     *                "totalTaxAmount" => 114.96
     *            ],
     *            "taxAmounts" => [
     *                [
     *                    "taxRatePercentage" => 19,
     *                    "taxAmount" => 114.96,
     *                    "netAmount" => 605.04
     *                ]
     *            ],
     *            "taxConditions" => [
     *                "taxType" => "gross"
     *            ],
     *            "paymentConditions" => [
     *                "paymentTermLabel" => "Zahlbar sofort, rein netto",
     *                "paymentTermLabelTemplate" => "Zahlbar sofort, rein netto",
     *                "paymentTermDuration" => 0
     *            ],
     *            "introduction" => "Unsere Lieferungen/Leistungen stellen wir Ihnen wie folgt in Rechnung.",
     *            "remark" => "Vielen Dank für die gute Zusammenarbeit.",
     *            "title" => "Rechnung",
     *            "recurringTemplateSettings" => [
     *                // Additional settings data...
     *            ]
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
     *         'status' => 404,
     *         'error' => 'Template not found',
     *     ]
     *     ```
     *
     * @param string $id The ID of the recurring template to retrieve.
     * @return array An array containing the result of the request, either the recurring template data or an error message.
     */


    public function find(string $id)
    {
        try {
            // Make the GET request to fetch the dunnings
            $response = $this->client->get("recurring-templates/{$id}");

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

    /**
     * Retrieve a list of recurring templates with optional pagination and sorting.
     *
     * This method sends a GET request to the `recurring-templates` endpoint, and it accepts optional parameters for paging and sorting.
     * - `paging` controls how many results are returned per page and which page to retrieve.
     * - `sorting` defines how the results should be ordered (e.g., ascending or descending).
     *
     * If no parameters are provided, the method will fetch all recurring templates without paging or sorting.
     *
     * ### Return Values:
     * - On success:
     *   - `success` (bool): Returns `true` indicating the request was successful.
     *   - `data` (array): Contains the list of recurring templates.
     *     Example:
     *     ```php
     *     [
     *         'success' => true,
     *         "content": [
     *             {
     *                 "id": "cab021e5-91d3-4e93-a696-56b7f2417547",
     *                 "organizationId": "a3d94eb4-98bc-429e-b7ad-17f1a8463af9",
     *                 "title": "Rechnung",
     *                 "createdDate": "2023-02-10T14:35:40.642+01:00",
     *                 "updatedDate": "2023-02-10T14:36:49.741+01:00",
     *                 "address": {
     *                     "contactId": "464f4881-7a8c-4dc4-87de-7c6fd9a506b8",
     *                     "name": "Bike & Ride GmbH & Co. KG"
     *                 },
     *                 "totalPrice": {
     *                     "currency": "EUR",
     *                     "totalNetAmount": 251.26,
     *                     "totalGrossAmount": 299
     *                 },
     *                 "paymentConditions": {
     *                     "paymentTermLabel": "10 Tage abzüglich 2 % Skonto",
     *                     "paymentTermLabelTemplate": "{paymentRange} Tage abzüglich {discount} Skonto",
     *                     "paymentTermDuration": 10,
     *                     "paymentDiscountConditions": {
     *                         "discountPercentage": 2,
     *                         "discountRange": 10
     *                     }
     *                 },
     *                 "recurringTemplateSettings": {
     *                     "id": "615a8db3-bce1-4e11-8302-328fcbacd613",
     *                     "startDate": "2023-04-01",
     *                     "endDate": "2024-04-01",
     *                     "finalize": false,
     *                     "shippingType": "serviceperiod",
     *                     "executionInterval": "QUARTERLY",
     *                     "lastExecutionFailed": false,
     *                     "executionStatus": "PAUSED"
     *                 }
     *             },
     *             {
     *                 "id": "ac1d66a8-6d59-408b-9413-d56b1db7946f",
     *                 "organizationId": "a3d94eb4-98bc-429e-b7ad-17f1a8463af9",
     *                 "title": "Rechnung",
     *                 "createdDate": "2023-02-10T14:29:03.114+01:00",
     *                 "updatedDate": "2023-02-10T14:29:03.143+01:00",
     *                 "address": {
     *                     "contactId": "df315523-1e92-473a-9d00-052212da84f8",
     *                     "name": "Haufe-Lexware GmbH & Co. KG"
     *                 },
     *                 "totalPrice": {
     *                     "currency": "EUR",
     *                     "totalNetAmount": 605.04,
     *                     "totalGrossAmount": 720
     *                 },
     *                 "paymentConditions": {
     *                     "paymentTermLabel": "Zahlbar sofort, rein netto",
     *                     "paymentTermLabelTemplate": "Zahlbar sofort, rein netto",
     *                     "paymentTermDuration": 0
     *                 },
     *                 "recurringTemplateSettings": {
     *                     "id": "9c5b8bde-7d36-49e8-af5c-4fbe7dc9fa01",
     *                     "startDate": "2023-03-01",
     *                     "endDate": "2023-06-30",
     *                     "finalize": true,
     *                     "shippingType": "service",
     *                     "executionInterval": "MONTHLY",
     *                     "nextExecutionDate": "2023-03-01",
     *                     "lastExecutionFailed": false,
     *                     "executionStatus": "ACTIVE"
     *                 }
     *             }
     *         ],
     *         "first": true,
     *         "last": true,
     *         "totalPages": 1,
     *         "totalElements": 2,
     *         "numberOfElements": 2,
     *         "size": 25,
     *         "number": 0,
     *         "sort": [
     *             {
     *                 "property": "createdDate",
     *                 "direction": "DESC",
     *                 "ignoreCase": false,
     *                 "nullHandling": "NATIVE",
     *                 "ascending": false
     *             }
     *         ]
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
     *         'status' => 400,
     *         'error' => 'Invalid query parameters',
     *     ]
     *     ```
     *
     * @param string|null $paging The paging parameters (e.g., page number, items per page).
     * @param string|null $sorting The sorting parameters (e.g., `asc`, `desc` or field name to sort by).
     * @return array An array containing the result of the request, either the list of recurring templates or an error message.
     */


    public function all($paging = null, $sorting = null)
    {
        $queryParams = [];
        if ($paging) {
            $queryParams['paging'] = $paging;
        }
        if ($sorting) {
            $queryParams['sorting'] = $sorting;
        }

        try {

            $response = $this->client->get("recurring-templates", [
                'query' => $queryParams,
            ]);

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

    /**
     * Generate a deeplink URL to edit a recurring template.
     *
     * This method constructs a URL that directs the user to the "edit" page for a specific recurring template.
     * The URL is based on the provided `id` and the application's base URI stored in the configuration file.
     * 
     * Example:
     * If the `id` is `123`, the resulting URL might look like:
     * `https://api.example.com/permalink/recurring-templates/edit/123`.
     *
     * ### Return Value:
     * - The method returns a string representing the full deeplink URL to the edit page of the recurring template.
     *
     * @param string $id The unique identifier of the recurring template.
     * @return string The generated deeplink URL to edit the recurring template.
     */

    public function getEditDeeplink(string $id): string
    {
        return config('lexoffice.base_uri') . "permalink/recurring-templates/edit/{$id}";
    }
}
