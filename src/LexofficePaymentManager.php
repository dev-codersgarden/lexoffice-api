<?php

namespace Codersgarden\PhpLexofficeApi;

use GuzzleHttp\Exception\RequestException;

class LexofficePaymentManager extends LexofficeBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retrieve payment details by voucher ID from the LexOffice API using Guzzle.
     *
     * This method sends a GET request to the "payments/{voucherId}" endpoint of the LexOffice API,
     * where `{voucherId}` is a dynamic parameter representing the unique identifier of the payment voucher.
     * It retrieves the payment details associated with the provided voucher ID and returns the data in a structured format.
     *
     * ### Expected Response:
     * On success, this method returns the payment details, which may include:
     * - `openAmount`: The remaining amount to be paid.
     * - `paymentStatus`: The status of the payment (e.g., openRevenue, completed).
     * - `currency`: The currency in which the payment is made (e.g., EUR).
     * - `voucherType`: The type of voucher (e.g., invoice).
     * - `voucherStatus`: The status of the voucher (e.g., open, paid).
     * - `paymentItems`: An array of items related to the payment, if available.
     *
     * ### Example of a Successful Response:
     * ```php
     * [
     *   "success" => true,
     *   "data" => [
     *       "openAmount" => 27.82,
     *       "paymentStatus" => "openRevenue",
     *       "currency" => "EUR",
     *       "voucherType" => "invoice",
     *       "voucherStatus" => "open",
     *       "paymentItems" => []
     *   ]
     * ]
     * ```
     *
     * ### Example Usage:
     * ```php
     * $voucherId = '1f1dc13c-fd68-11ea-a8b9-ff40c7cabfe0'; // Example voucher ID
     * $response = $lexofficePaymentManager->find($voucherId);
     * if ($response['success']) {
     *     // Handle successful response
     *     print_r($response['data']);
     * } else {
     *     // Handle error
     *     echo 'Error: ' . $response['error'];
     * }
     * ```
     *
     * ### Parameters:
     * - `voucherId` (string): The unique identifier of the payment voucher to be retrieved.
     *
     * ### Return Value:
     * This method returns an array containing:
     * - `'success'` (bool): Indicates whether the request was successful.
     * - `'data'` (array|null): Contains the payment details from the API on success, structured as:
     *   - `openAmount` (float): The remaining amount to be paid.
     *   - `paymentStatus` (string): The status of the payment.
     *   - `currency` (string): The currency of the payment.
     *   - `voucherType` (string): The type of the voucher.
     *   - `voucherStatus` (string): The status of the voucher.
     *   - `paymentItems` (array): A list of payment-related items.
     * - `'status'` (int|null): HTTP status code returned by the API on failure.
     * - `'error'` (string|null): Error message if the request fails.
     *
     * ### Error Handling:
     * If the request fails, this method captures the HTTP response status and error message
     * and returns them in the structured response array.
     *
     * ### Dependencies:
     * This method requires the `GuzzleHttp\Client` instance to send the request to the LexOffice API.
     *
     * @param string $voucherId The unique identifier of the payment voucher to be retrieved.
     * @return array An array containing:
     *               - 'success' (bool): Indicates whether the request was successful.
     *               - 'data' (array|null): Contains the payment details from the API on success.
     *               - 'status' (int|null): HTTP status code returned by the API on failure.
     *               - 'error' (string|null): Error message if the request fails.
     */


    public function find(string $voucherId)
    {
        try {
            $response = $this->client->get("payments/{$voucherId}");

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
