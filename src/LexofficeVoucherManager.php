<?php

namespace Codersgarden\PhpLexofficeApi;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Container\Attributes\Log;

class LexofficeVoucherManager extends LexofficeBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a voucher in the LexOffice API.
     *
     * This method creates a new voucher in the LexOffice API. The voucher data must contain
     * certain required fields, and other optional properties can be provided for more detailed
     * specifications of the voucher.
     *
     * **Required Fields**:
     *  -type (string): The type of the voucher. Must be salesinvoice for sales invoices.
     *  -voucherNumber (string): A unique identifier for the voucher. You should provide this unless voucherStatus is unchecked.
     *  -voucherDate (string): The date of the voucher in ISO 8601 format (YYYY-MM-DD).
     *  -totalGrossAmount (float): The total gross amount of the voucher.
     *  -totalTaxAmount (float): The total tax amount associated with the voucher.
     *  -taxType (string): The tax calculation type. Must be either gross or net.
     *  -voucherItems (array): A list of items included in the voucher. Each item must contain:
     *  -amount (float): The amount for the voucher item.
     *  -taxAmount (float): The tax amount for the voucher item.
     *  -taxRatePercent (int): The tax rate percentage for the voucher item.
     *  -categoryId (string): The unique category ID associated with the item.
     *  -contactId (string): The ID of the contact associated with this voucher.
     *
     * **Optional Fields**:
     * - `shippingDate` (string, optional): The shipping date in ISO 8601 format (`YYYY-MM-DD`).
     * - `dueDate` (string, optional): The due date for payment in ISO 8601 format (`YYYY-MM-DD`).
     * - `useCollectiveContact` (bool, optional): Indicates whether to use a collective contact.
     * - `remark` (string, optional): Additional remarks or comments for the voucher.
    
     * - `files` (array, optional): A list of files to be attached to the voucher.
     *
     * **Read-Only Fields** (Managed by the API):
     * - `createdDate` (datetime, read-only): Timestamp when the voucher was created.
     * - `updatedDate` (datetime, read-only): Timestamp when the voucher was last updated.
     * - `version` (int, read-only): The version of the voucher for optimistic locking.
     *
     * **Example of a $voucherData array**:
     * ```php
     * $voucherData = [
     *     'type' => 'salesinvoice',
     *     'voucherNumber' => 'INV-2024-001',
     *     'voucherDate' => '2024-11-26',
     *     'shippingDate' => '2024-11-30',
     *     'dueDate' => '2024-12-15',
     *     'totalGrossAmount' => 119.00,
     *     'totalTaxAmount' => 19.00,
     *     'taxType' => 'gross',
     *     'voucherItems' => [
     *         [
     *             'amount' => 119.00,
     *             'taxAmount' => 19.00,
     *             'taxRatePercent' => 19,
     *             'categoryId' => '8f8664a8-fd86-11e1-a21f-0800200c9a66',
     *         ],
     *     ],
     *     'remark' => 'Monthly subscription invoice.',
     *     'contactId' => '0d7d169c-21c9-4144-a52a-682e757f8b55',
     * ];
     * ```
     *
     * @param array $voucherData An associative array containing voucher details.
     *                           Example structure provided above.
     * @return array An array containing:
     *               - `success` (bool): Indicates whether the request was successful.
     *               - `data` (array|null): Contains the response data from the API on success.
     *               - `status` (int|null): HTTP status code returned on failure.
     *               - `error` (string|null): Error message in case of failure.
     */


    public function create(array $voucherData)
    {


        try {
            $url = 'vouchers';
            $response = $this->client->post($url, [
                'json' => $voucherData,
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
     * Retrieve a specific voucher from the LexOffice API.
     *
     * This method fetches the details of a voucher using its unique identifier.
     * The voucher information is returned as an associative array if the request is successful.
     * In case of an error, details about the failure are provided, including the HTTP status code
     * and error message.
     *
     * **Parameters**:
     * - `voucherId` (string, required): The unique identifier of the voucher to retrieve.
     *
     * **Returns**:
     * - `array`: An associative array with the following keys:
     *   - `success` (bool): Indicates whether the request was successful.
     *   - `data` (array|null): Contains the voucher details if the request succeeds, or `null` otherwise.
     *   - `status` (int|null): The HTTP status code returned by the API on failure, or `null` if unavailable.
     *   - `error` (string|null): A descriptive error message in case of a failure.
     *
     * **Example Usage**:
     * ```php
     * $voucherId = '123e4567-e89b-12d3-a456-426614174000';
     * $voucherDetails = $this->find($voucherId);
     *
     * if ($voucherDetails['success']) {
     *     echo "Voucher Details: " . print_r($voucherDetails['data']);
     * } else {
     *     echo "Error ({$voucherDetails['status']}): {$voucherDetails['error']}";
     * }
     * ```
     *
     * **Error Handling**:
     * - In the event of a `RequestException`, the HTTP response is parsed to extract error details.
     * - If the response is unavailable, the exception message is returned as the error.
     *
     * @param string $voucherId The unique identifier of the voucher to retrieve.
     * @return array An array containing the success status, retrieved data, HTTP status code, and error message (if any).
     */

    public function find(string $voucherId)
    {

        try {
            $response = $this->client->get("vouchers/{$voucherId}");

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
     * Update a specific voucher in the LexOffice API.
     *
     * This method updates an existing voucher by sending the new data to the LexOffice API.
     * The updated voucher details are returned as an associative array if the request is successful.
     * In case of an error, the method provides details about the failure, including the HTTP status code
     * and error message.
     *
     * **Sample Request**:
     * 
     * Example of a GET request to retrieve a voucher:
     * ```bash
     * curl https://api.lexoffice.io/v1/vouchers/{voucherId}
     * -X GET
     * -H "Authorization: Bearer {accessToken}"
     * -H "Accept: application/json"
     * ```
     * 
     * **Sample Response**:
     * ```json
     * {
     *   "id": "66196c43-baf3-4335-bfee-d610367059db",
     *   "organizationId": "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
     *   "type": "salesinvoice",
     *   "voucherStatus": "open",
     *   "voucherNumber": "123-456",
     *   "voucherDate": "2023-06-28T00:00:00.000+02:00",
     *   "shippingDate": "2023-07-02T00:00:00.000+02:00",
     *   "dueDate": "2023-07-05T00:00:00.000+02:00",
     *   "totalGrossAmount": 119,
     *   "totalTaxAmount": 19.00,
     *   "taxType": "gross",
     *   "useCollectiveContact": true,
     *   "remark": "Bestellung von Max Mustermann.",
     *   "voucherItems": [
     *     {
     *       "amount": 119,
     *       "taxAmount": 19.00,
     *       "taxRatePercent": 19,
     *       "categoryId": "8f8664a8-fd86-11e1-a21f-0800200c9a66"
     *     }
     *   ],
     *   "files": [],
     *   "createdDate": "2023-06-29T15:15:09.447+02:00",
     *   "updatedDate": "2023-06-29T15:15:09.447+02:00",
     *   "version": 1
     * }
     * ```
     * 
     * **Parameters**:
     * - `voucherId` (string, required): The unique identifier of the voucher to update.
     * - `voucherData` (array, required): An associative array containing the new data to update the voucher with. 
     *   This data should match the expected structure of the LexOffice API's voucher update endpoint.
     *
     * **Returns**:
     * - `array`: An associative array with the following keys:
     *   - `success` (bool): Indicates whether the request was successful.
     *   - `data` (array|null): Contains the updated voucher details if the request succeeds, or `null` otherwise.
     *   - `status` (int|null): The HTTP status code returned by the API on failure, or `null` if unavailable.
     *   - `error` (string|null): A descriptive error message in case of a failure.
     *
     * **Example Usage**:
     * ```php
     * $voucherId = '123e4567-e89b-12d3-a456-426614174000';
     * $voucherData = [
     *     'voucherNumber' => '456-789',
     *     'voucherDate' => '2023-07-01',
     *     'totalGrossAmount' => 150.00,
     *     'totalTaxAmount' => 25.00,
     *     // other updated fields
     * ];
     * $updatedVoucher = $this->update($voucherId, $voucherData);
     *
     * if ($updatedVoucher['success']) {
     *     echo "Voucher updated successfully: " . print_r($updatedVoucher['data'], true);
     * } else {
     *     echo "Error ({$updatedVoucher['status']}): {$updatedVoucher['error']}";
     * }
     * ```
     *
     * **Error Handling**:
     * - If a `RequestException` occurs, the HTTP response is examined to extract error details.
     * - If the response is not available, the exception message is used as the error message.
     *
     * @param string $voucherId The unique identifier of the voucher to update.
     * @param array $voucherData The new data to update the voucher with.
     * @return array An array containing the success status, updated data, HTTP status code, and error message (if any).
     */

    public function update(string $voucherId, array $voucherData)
    {


        try {
            $response = $this->client->post("vouchers/{$voucherId}", [
                'json' => $voucherData,
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
     * Fetch a list of vouchers with optional filters.
     *
     * This method retrieves a list of vouchers from the LexOffice API, supporting optional query filters.
     * The filters can be passed as an associative array, and will be appended to the URL as query parameters.
     *
     * **Sample Request**:
     * 
     * Example of a GET request to retrieve a list of vouchers with filters:
     * ```bash
     * curl https://api.lexoffice.io/v1/vouchers?voucherNumber=123-456
     * -X GET
     * -H "Authorization: Bearer {accessToken}"
     * -H "Accept: application/json"
     * ```
     * 
     * **Sample Response**:
     * ```json
     * {
     *   "vouchers": [
     *     {
     *       "id": "66196c43-baf3-4335-bfee-d610367059db",
     *       "organizationId": "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
     *       "type": "salesinvoice",
     *       "voucherStatus": "open",
     *       "voucherNumber": "123-456",
     *       "voucherDate": "2023-06-28T00:00:00.000+02:00",
     *       "shippingDate": "2023-07-02T00:00:00.000+02:00",
     *       "dueDate": "2023-07-05T00:00:00.000+02:00",
     *       "totalGrossAmount": 119,
     *       "totalTaxAmount": 19.00,
     *       "taxType": "gross",
     *       "useCollectiveContact": true,
     *       "remark": "Bestellung von Max Mustermann.",
     *       "voucherItems": [
     *         {
     *           "amount": 119,
     *           "taxAmount": 19.00,
     *           "taxRatePercent": 19,
     *           "categoryId": "8f8664a8-fd86-11e1-a21f-0800200c9a66"
     *         }
     *       ],
     *       "files": [],
     *       "createdDate": "2023-06-29T15:15:09.447+02:00",
     *       "updatedDate": "2023-06-29T15:15:09.447+02:00",
     *       "version": 1
     *     }
     *   ]
     * }
     * ```
     *
     * **Parameters**:
     * - `filters` (array): An associative array containing the filters to apply to the voucher list request. These filters will be appended to the URL as query parameters. 
     *   Example:
     *   ```php
     *   $filters = ['voucherNumber' => '123-456'];
     *   ```
     * 
     * **Returns**:
     * - `array`: An associative array with the following keys:
     *   - `success` (bool): Indicates whether the request was successful.
     *   - `data` (array|null): Contains the list of vouchers if the request succeeds, or `null` otherwise.
     *   - `status` (int|null): The HTTP status code returned by the API on failure, or `null` if unavailable.
     *   - `error` (string|null): A descriptive error message in case of a failure.
     *
     * **Example Usage**:
     * ```php
     * $filters = [
     *     'voucherNumber' => '123-456'
     * ];
     * $voucherList = $this->all($filters);
     *
     * if ($voucherList['success']) {
     *     echo "Vouchers fetched successfully: " . print_r($voucherList['data'], true);
     * } else {
     *     echo "Error ({$voucherList['status']}): {$voucherList['error']}";
     * }
     * ```
     *
     * **Error Handling**:
     * - If a `RequestException` occurs, the HTTP response is examined to extract error details.
     * - If the response is not available, the exception message is used as the error message.
     *
     * @param array $filters Optional filters to apply to the voucher list request (e.g., `status`, `voucherNumber`).
     * @return array An array containing the success status, voucher data, HTTP status code, and error message (if any).
     */
    public function all(array $filters = [])
    {
        try {
            $queryParams = http_build_query($filters);
            $response = $this->client->get("vouchers?" . $queryParams);

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
     * Generate a deeplink URL for viewing a voucher.
     *
     * This method generates a permalink URL that points to a specific voucher's view page in LexOffice.
     * The URL is constructed by appending the `voucherId` to a base URI defined in the configuration.
     *
     * **Sample Request**:
     * If you call the method with a voucher ID, it will return the URL:
     * ```php
     * $voucherId = '66196c43-baf3-4335-bfee-d610367059db';
     * $deeplink = $this->getViewDeeplink($voucherId);
     * echo $deeplink;
     * // Returns: https://api.lexoffice.io/v1/permalink/vouchers/view/66196c43-baf3-4335-bfee-d610367059db
     * ```
     *
     * @param string $voucherId The ID of the voucher for which the deeplink URL is to be generated.
     * @return string The URL to view the voucher.
     */
    public function getViewDeeplink(string $voucherId): string
    {
        return config('lexoffice.base_uri') . "permalink/vouchers/view/{$voucherId}";
    }

    /**
     * Generate a deeplink URL for viewing a voucher.
     *
     * This method generates a permalink URL that points to a specific voucher's view page in LexOffice.
     * The URL is constructed by appending the `voucherId` to a base URI defined in the configuration.
     *
     * **Sample Request**:
     * If you call the method with a voucher ID, it will return the URL:
     * ```php
     * $voucherId = '66196c43-baf3-4335-bfee-d610367059db';
     * $deeplink = $this->getViewDeeplink($voucherId);
     * echo $deeplink;
     * // Returns: https://api.lexoffice.io/v1/permalink/vouchers/view/66196c43-baf3-4335-bfee-d610367059db
     * ```
     *
     * @param string $voucherId The ID of the voucher for which the deeplink URL is to be generated.
     * @return string The URL to view the voucher.
     */

    public function getEditDeeplink(string $voucherId): string
    {
        return config('lexoffice.base_uri') . "permalink/vouchers/edit/{$voucherId}";
    }

    /**
     * Upload a file to a specific voucher.
     *
     * This method uploads a file to a voucher in the LexOffice platform.
     * The file is sent using a multipart request with the file content and its type.
     *
     * **Sample Request**:
     * If you call the method with a voucher ID, file type, and file path:
     * ```php
     * $voucherId = '66196c43-baf3-4335-bfee-d610367059db';
     * $fileType = 'invoice';
     * $filePath = '/path/to/file.pdf';
     * $result = $this->uploadFile($voucherId, $fileType, $filePath);
     * ```
     *
     * **Sample Response**:
     * On success:
     * ```json
     * {
     *   "success": true,
     *   "data": { ...response data... }
     * }
     * ```
     * On failure:
     * ```json
     * {
     *   "success": false,
     *   "error": "File does not exist at the provided path."
     * }
     * ```
     *
     * @param string $voucherId The ID of the voucher to which the file will be uploaded.
     * @param string $fileType The type of the file being uploaded (e.g., 'invoice', 'receipt').
     * @param string $filePath The path to the file to be uploaded.
     * @return array The result of the file upload attempt, including success status and data or error message.
     */


    public function uploadFile(string $voucherId, string $fileType, string $filePath)
    {

        if (!file_exists($filePath)) {
            return [
                'success' => false,
                'error' => 'File does not exist at the provided path.',
            ];
        }
        try {
            $response = $this->client->post("vouchers/{$voucherId}/files", [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($filePath, 'r'),
                        'filename' => basename($filePath),
                    ],
                    [
                        'name' => 'type',
                        'contents' => $fileType,
                    ],
                ],
            ]);

            // Decode the response and return success
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
