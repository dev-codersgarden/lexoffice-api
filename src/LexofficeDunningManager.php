<?php

namespace CodersGarden\PhpLexofficeApi;

use Codersgarden\PhpLexofficeApi\LexofficeBase;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;

class LexofficeDunningManager extends LexofficeBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new dunning for a sales voucher.
     *
     * This method sends a POST request to the `dunnings` endpoint to create a new dunning record 
     * associated with a preceding sales voucher.
     *
     * Expected Input:
     * - `$data` (array, required): An associative array containing the dunning details. 
     *   Example:
     *   ```php
     *   $precedingSalesVoucherId="c4ea398d-4ca4-4b4e-a24c-9d9499b49b78"
     *   $data = [
     *       "archived" => false,
     *       "voucherDate" => "2023-07-22T00:00:00.000+02:00",
     *       "address" => [
     *           "name" => "Bike & Ride GmbH & Co. KG",
     *           "supplement" => "Gebäude 10",
     *           "street" => "Musterstraße 42",
     *           "city" => "Freiburg",
     *           "zip" => "79112",
     *           "countryCode" => "DE"
     *       ],
     *       "lineItems" => [
     *           [
     *               "type" => "custom",
     *               "name" => "Energieriegel Testpaket",
     *               "quantity" => 1,
     *               "unitName" => "Stück",
     *               "unitPrice" => [
     *                   "currency" => "EUR",
     *                   "netAmount" => 5,
     *                   "taxRatePercentage" => 0
     *               ],
     *               "discountPercentage" => 0
     *           ],
     *           [
     *               "type" => "text",
     *               "name" => "Strukturieren Sie Ihre Belege durch Text-Elemente.",
     *               "description" => "Das hilft beim Verständnis"
     *           ]
     *       ],
     *       "totalPrice" => [
     *           "currency" => "EUR",
     *           "totalNetAmount" => 15.0,
     *           "totalGrossAmount" => 17.85,
     *           "totalTaxAmount" => 2.85
     *       ],
     *       "taxConditions" => [
     *           "taxType" => "net"
     *       ],
     *       "shippingConditions" => [
     *           "shippingType" => "service",
     *           "shippingDate" => "2023-07-25T00:00:00.000+02:00",
     *           "shippingEndDate" => "2023-07-28T00:00:00.000+02:00"
     *       ],
     *       "title" => "Mahnung",
     *       "introduction" => "Wir bitten Sie, die nachfolgend aufgelisteten Lieferungen/Leistungen unverzüglich zu begleichen.",
     *       "remark" => "Sollten Sie den offenen Betrag bereits beglichen haben, betrachten Sie dieses Schreiben als gegenstandslos."
     *   ];
     *   ```
     * - `$precedingSalesVoucherId` (string, required): The unique identifier of the preceding sales voucher 
     *   for which the dunning is being created.
     *
     * Return Values:
     * - On success:
     *   - `success` (bool): Returns `true`.
     *   - `data` (array): Contains the response data from the API, including details of the newly created dunning.
     *     Example:
     *     ```php
     *     [
     *         'success' => true,
     *         'data' => [
     *             "id" => "662ef559-7d9d-4215-8234-8cd78b6b3b68",
     *             "resourceUri" => "https://api.lexoffice.io/v1/dunnings/662ef559-7d9d-4215-8234-8cd78b6b3b68",
     *             "createdDate" => "2024-11-27T09:03:53.495+01:00",
     *             "updatedDate" => "2024-11-27T09:03:53.572+01:00",
     *             "version" => 2
     *         ]
     *     ];
     *     ```
     * - On failure:
     *   - `success` (bool): Returns `false`.
     *   - `status` (int|null): The HTTP status code of the response, or the exception code if unavailable.
     *   - `error` (string): The error message provided by the API, or the exception's message if unavailable.
     *     Example:
     *     ```php
     *     [
     *         'success' => false,
     *         'status' => 400,
     *         'error' => 'Invalid sales voucher ID.',
     *     ];
     *     ```
     *
     * @param array $data An associative array representing the dunning data.
     * @param string $precedingSalesVoucherId The unique identifier of the preceding sales voucher.
     *
     * @return array An array with the following keys:
     *               - `success` (bool): Indicates whether the request was successful.
     *               - `data` (array|null): Contains the API response data on success.
     *               - `status` (int|null): The HTTP status code returned by the API on failure.
     *               - `error` (string|null): The error message if the request fails.
     *
     * @throws \GuzzleHttp\Exception\RequestException Thrown if an HTTP request error occurs.
     */



    public function create(array $data, string $precedingSalesVoucherId)
    {


        try {
            $url = 'dunnings' . '?precedingSalesVoucherId=' . $precedingSalesVoucherId;
            $response = $this->client->post($url, [
                'json' => $data,
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
     * Retrieve a specific dunning by its unique identifier.
     *
     * This method sends a GET request to fetch the details of a dunning record using its ID.
     *
     * ### Parameters:
     * - `$precedingSalesVoucherId` (string, required): The unique identifier of the dunning to retrieve.
     *
     * ### Return Values:
     * - **Success**:
     *     - `success` (bool): Returns `true` if the dunning is retrieved successfully.
     *     - `data` (array): Contains the response from the API with details of the dunning, including its ID, address, line items, etc.
     *       Example:
     *       ```php
     *       $precedingSalesVoucherId = "c4ea398d-4ca4-4b4e-a24c-9d9499b49b78";
     *       $data = [
     *           "archived" => false,
     *           "voucherDate" => "2023-07-22T00:00:00.000+02:00",
     *           "address" => [
     *               "name" => "Bike & Ride GmbH & Co. KG",
     *               "supplement" => "Gebäude 10",
     *               "street" => "Musterstraße 42",
     *               "city" => "Freiburg",
     *               "zip" => "79112",
     *               "countryCode" => "DE"
     *           ],
     *           "lineItems" => [
     *               [
     *                   "type" => "custom",
     *                   "name" => "Energieriegel Testpaket",
     *                   "quantity" => 1,
     *                   "unitName" => "Stück",
     *                   "unitPrice" => [
     *                       "currency" => "EUR",
     *                       "netAmount" => 5,
     *                       "taxRatePercentage" => 0
     *                   ],
     *                   "discountPercentage" => 0
     *               ],
     *               [
     *                   "type" => "text",
     *                   "name" => "Strukturieren Sie Ihre Belege durch Text-Elemente.",
     *                   "description" => "Das hilft beim Verständnis"
     *               ]
     *           ],
     *           "totalPrice" => [
     *               "currency" => "EUR",
     *               "totalNetAmount" => 15.0,
     *               "totalGrossAmount" => 17.85,
     *               "totalTaxAmount" => 2.85
     *           ],
     *           "taxConditions" => [
     *               "taxType" => "net"
     *           ],
     *           "shippingConditions" => [
     *               "shippingType" => "service",
     *               "shippingDate" => "2023-07-25T00:00:00.000+02:00",
     *               "shippingEndDate" => "2023-07-28T00:00:00.000+02:00"
     *           ],
     *           "title" => "Mahnung",
     *           "introduction" => "Wir bitten Sie, die nachfolgend aufgelisteten Lieferungen/Leistungen unverzüglich zu begleichen.",
     *           "remark" => "Sollten Sie den offenen Betrag bereits beglichen haben, betrachten Sie dieses Schreiben als gegenstandslos."
     *       ];
     *       ```
     * - **Failure**:
     *     - `success` (bool): Returns `false` if the request fails.
     *     - `status` (int|null): The HTTP status code of the response on failure, or the exception code if unavailable.
     *     - `error` (string): The error message from the API or exception, if available.
     *       Example:
     *       ```php
     *       [
     *           'success' => false,
     *           'status' => 404,
     *           'error' => 'Dunning not found.',
     *       ];
     *       ```
     *
     * ### Exceptions:
     * - Throws `\GuzzleHttp\Exception\RequestException` if the HTTP request fails. This could happen due to network issues, invalid dunning ID, or other server-side problems.
     *
     * @param string $precedingSalesVoucherId The unique identifier of the dunning to retrieve.
     *
     * @return array An array containing:
     *               - `success` (bool): Indicates if the request was successful.
     *               - `data` (array|null): The API response data on success, or `null` if the request fails.
     *               - `status` (int|null): The HTTP status code on failure, or `null` if unavailable.
     *               - `error` (string|null): The error message if the request fails.
     */


    public function pursueTodunning(string $precedingSalesVoucherId, array $data)
    {

        try {
            $url = "dunnings?precedingSalesVoucherId={$precedingSalesVoucherId}";

            $response = $this->client->post($url, [
                'json' => $data,
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
     * Retrieve a specific dunning by its unique identifier.
     *
     * This method sends a GET request to fetch the details of a dunning record using its ID.
     *
     * ### Parameters:
     * - `$dunningId` (string, required): The unique identifier of the dunning to retrieve.
     *
     * ### Return Values:
     * - **Success**:
     *     - `success` (bool): Returns `true` if the dunning is retrieved successfully.
     *     - `data` (array): Contains the response from the API with details of the dunning, including its ID, address, line items, etc.
     *       Example:
     *       ```php
     *       [
     *           'success' => true,
     *           'data' => [
     *               "id" => "8f9a1ba7-cb6a-4522-92f4-32d7c9612b6f",
     *               "organizationId" => "7c0e3c8d-8fd9-4693-9b88-9376b90d1368",
     *               "createdDate" => "2024-11-28T08:46:38.802+01:00",
     *               "updatedDate" => "2024-11-28T08:46:38.894+01:00",
     *               "version" => 2,
     *               "language" => "de",
     *               "archived" => false,
     *               "voucherStatus" => "draft",
     *               "voucherDate" => "2023-07-22T00:00:00.000+02:00",
     *               "address" => [ ... ],
     *               "lineItems" => [ ... ],
     *               "totalPrice" => [ ... ],
     *               "taxAmounts" => [ ... ],
     *               "taxConditions" => [ ... ],
     *               "shippingConditions" => [ ... ],
     *               "closingInvoice" => false,
     *               "relatedVouchers" => [ ... ],
     *               "introduction" => "Wir bitten Sie, die nachfolgend aufgelisteten Lieferungen/Leistungen unverzüglich zu begleichen.",
     *               "remark" => "Sollten Sie den offenen Betrag bereits beglichen haben, betrachten Sie dieses Schreiben als gegenstandslos.",
     *               "files" => [ "documentFileId" => "61a82ce6-fa46-471f-ace7-299e665181b8" ],
     *               "title" => "Mahnung",
     *           ],
     *       ];
     *       ```
     * - **Failure**:
     *     - `success` (bool): Returns `false` if the request fails.
     *     - `status` (int|null): The HTTP status code of the response on failure, or the exception code if unavailable.
     *     - `error` (string): The error message from the API or exception, if available.
     *       Example:
     *       ```php
     *       [
     *           'success' => false,
     *           'status' => 404,
     *           'error' => 'Dunning not found.',
     *       ];
     *       ```
     *
     * ### Exceptions:
     * - Throws `\GuzzleHttp\Exception\RequestException` if the HTTP request fails. This could happen due to network issues, invalid dunning ID, or other server-side problems.
     *
     * @param string $dunningId The unique identifier of the dunning to retrieve.
     *
     * @return array An array containing:
     *               - `success` (bool): Indicates if the request was successful.
     *               - `data` (array|null): The API response data on success, or `null` if the request fails.
     *               - `status` (int|null): The HTTP status code on failure, or `null` if unavailable.
     *               - `error` (string|null): The error message if the request fails.
     */

    public function find(string $dunningId)
    {
        try {
            // Make the GET request to fetch the dunnings
            $response = $this->client->get("dunnings/{$dunningId}");

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
     * Render a PDF document for a specific dunning.
     *
     * This method sends a GET request to trigger the PDF rendering of a dunning record 
     * identified by its `dunningId`. It returns the details of the rendered document
     * in the response.
     *
     * ### Parameters:
     * - `$dunningId` (string, required): The unique identifier of the dunning for which the document needs to be rendered.
     *
     * ### Return Values:
     * - **Success**:
     *     - `success` (bool): Returns `true` if the document rendering is successful.
     *     - `data` (array): Contains the response data, including details of the rendered document, such as the document's URI or a status message.
     *       Example:
     *       ```php
     *       [
     *           
     *              "documentFileId": "b26e1d73-19ff-46b1-8929-09d8d73d4167"
     *           
     *       ];
     *       ```
     * - **Failure**:
     *     - `success` (bool): Returns `false` if the request fails.
     *     - `status` (int|null): The HTTP status code of the response, or the exception code if unavailable.
     *     - `error` (string): The error message from the API or exception.
     *       Example:
     *       ```php
     *       [
     *           'success' => false,
     *           'status' => 404,
     *           'error' => 'Dunning document not found.',
     *       ];
     *       ```
     *
     * ### Exceptions:
     * - Throws `\GuzzleHttp\Exception\RequestException` if the HTTP request fails. This could occur due to network issues, invalid `dunningId`, or server-side problems.
     *
     * @param string $dunningId The unique identifier of the dunning to render a document for.
     *
     * @return array An array containing:
     *               - `success` (bool): Indicates if the document rendering was successful.
     *               - `data` (array|null): The API response data on success, or `null` if the request fails.
     *               - `status` (int|null): The HTTP status code on failure, or `null` if unavailable.
     *               - `error` (string|null): The error message if the request fails.
     */

    public function renderDocument(string $dunningId)
    {
        try {
            // Make the GET request to trigger PDF rendering
            $response = $this->client->get("dunnings/{$dunningId}/document");

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
     * Generate a deeplink URL to view a specific dunning record.
     *
     * This method constructs a URL using the base URI from the configuration and appends
     * the `dunningId` to create a permalink for viewing the corresponding dunning.
     *
     * ### Parameters:
     * - `$dunningId` (string, required): The unique identifier of the dunning to generate the view URL for.
     *
     * ### Return Values:
     * - `string`: A URL string that can be used as a deeplink to view the dunning record.
     *   Example:
     *   ```php
     *   'https://api.lexoffice.io/permalink/dunnings/view/12345-abcde'
     *   ```
     *
     * @param string $dunningId The unique identifier of the dunning.
     *
     * @return string The deeplink URL for viewing the dunning.
     */

    public function getViewDeeplink(string $dunningId): string
    {
        return config('lexoffice.base_uri') . "permalink/dunnings/view/{$dunningId}";
    }

    /**
     * Generate a deeplink URL to edit a specific dunning record.
     *
     * This method constructs a URL using the base URI from the configuration and appends
     * the `dunningId` to create a permalink for editing the corresponding dunning.
     *
     * ### Parameters:
     * - `$dunningId` (string, required): The unique identifier of the dunning to generate the edit URL for.
     *
     * ### Return Values:
     * - `string`: A URL string that can be used as a deeplink to edit the dunning record.
     *   Example:
     *   ```php
     *   'https://api.lexoffice.io/permalink/dunnings/edit/12345-abcde'
     *   ```
     *
     * @param string $dunningId The unique identifier of the dunning.
     *
     * @return string The deeplink URL for editing the dunning.
     */

    public function getEditDeeplink(string $dunningId): string
    {
        return config('lexoffice.base_uri') . "permalink/dunnings/edit/{$dunningId}";
    }
}
