<?php

namespace Codersgarden\PhpLexofficeApi;

use GuzzleHttp\Exception\RequestException;

class LexofficePaymentConditionManager extends LexofficeBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retrieve all payment conditions from the LexOffice API using Guzzle.
     *
     * This method fetches the list of payment conditions from the LexOffice API.
     * It sends a GET request to the `payment-conditions` endpoint and retrieves
     * the available payment conditions, such as payment terms or configurations.
     *
     * ### Expected Response:
     * On success, this method returns a list of payment conditions, including:
     * - `id`: Unique identifier for the payment condition.
     * - `organizationDefault`: Indicates if this is the default condition for the organization.
     * - `paymentTermLabelTemplate`: The label template for the payment terms.
     * - `paymentTermDuration`: The duration of the payment term (in days).
     *
     * ### Example of a Successful Response:
     * ```php
     * [
     *   "success" => true,
     *   "data" => [
     *     [
     *       "id" => "644df601-b965-43af-80de-594c2bd45b21",
     *       "organizationDefault" => true,
     *       "paymentTermLabelTemplate" => "Zahlbar sofort, rein netto",
     *       "paymentTermDuration" => 0
     *     ]
     *   ]
     * ]
     * ```
     *
     * ### Example Usage:
     * ```php
     * $response = $lexofficePaymentManager->all();
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
     * This method returns an array containing:
     * - `'success'` (bool): Indicates whether the request was successful.
     * - `'data'` (array|null): Contains the payment condition data from the API on success.
     *   Each entry includes:
     *   - `id` (string): The unique identifier of the payment condition.
     *   - `organizationDefault` (bool): Indicates if this is the organization's default payment condition.
     *   - `paymentTermLabelTemplate` (string): Template describing the payment term label.
     *   - `paymentTermDuration` (int): Duration of the payment term in days.
     * - `'status'` (int|null): HTTP status code returned by the API on failure.
     * - `'error'` (string|null): Error message if the request fails.
     *
     * ### Error Handling:
     * If the request fails, this method captures the HTTP response status and error message
     * and returns them in the structured response array.
     *
     * @return array An array containing:
     *               - 'success' (bool): Indicates whether the request was successful.
     *               - 'data' (array|null): Contains the payment condition data from the API on success.
     *               - 'status' (int|null): HTTP status code returned by the API on failure.
     *               - 'error' (string|null): Error message if the request fails.
     */


    public function all()
    {
        try {
            $response = $this->client->get("payment-conditions");
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
