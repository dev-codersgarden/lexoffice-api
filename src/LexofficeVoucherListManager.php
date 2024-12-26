<?php

namespace Codersgarden\PhpLexofficeApi;

use GuzzleHttp\Exception\RequestException;

class LexofficeVoucherListManager extends LexofficeBase
{



    public function __construct()
    {
        parent::__construct();
    }
/**
 * Retrieve a list of vouchers based on the provided filters.
 *
 * This method makes a GET request to fetch a list of vouchers from the LexOffice API. The request includes
 * query parameters, which can be specified in the `$filters` array. If no filters are provided, all vouchers 
 * will be returned by default. The method handles both successful responses (returning the voucher data) and 
 * errors (returning the error message with the appropriate status).
 *
 * ### Usage Example:
 * ```php
 * $filters = [
 *     'voucherStatus' => 'open',
 *     'voucherType' => 'purchaseinvoice',
 * ];
 * $response = $lexofficeVoucherManager->all($filters);
 * if ($response['success']) {
 *     // Process the list of vouchers
 *     $vouchers = $response['data'];
 * } else {
 *     // Handle the error
 *     echo $response['error'];
 * }
 * ```
 *
 * ### Parameters:
 * - `array $filters` (optional): An associative array of filters to be applied to the voucher list request.
 *   For example, it could contain filters like 'voucherStatus', 'voucherType', etc. If no filters are provided, 
 *   all vouchers are returned.
 *
 * ### Return Value:
 * - `array`: The response will contain:
 *   - `'success'`: A boolean indicating whether the request was successful.
 *   - `'data'`: If successful, contains the list of vouchers in an associative array.
 *   - `'status'`: If an error occurs, contains the HTTP status code of the response.
 *   - `'error'`: If an error occurs, contains the error message or description.
 *
 * ### Example Response:
 * ```php
 * [
 *     'success' => true,
 *     'data' => [
 *         [
 *             'voucherId' => '12345',
 *             'voucherCode' => 'VOUCHER2024',
 *             'status' => 'active',
 *             'type' => 'discount',
 *         ],
 *         // More vouchers...
 *     ]
 * ]
 * ```
 *
 * ### Notes:
 * - The query parameters are built using the `http_build_query` function, which encodes the `$filters` array 
 *   into a query string that can be appended to the URL.
 * - If an error occurs, the method will catch the exception and return the error message along with the 
 *   corresponding HTTP status code.
 *
 * @param array $filters Optional filters to apply to the voucher list.
 * @return array The response array containing the success status, voucher data, or error details.
 */

    public function all(array $filters = [])
    {
        try {
            $queryParams = http_build_query($filters);
            $response = $this->client->get("voucherlist?" . $queryParams);

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
