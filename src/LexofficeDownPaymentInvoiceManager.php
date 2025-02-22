<?php

namespace CodersGarden\PhpLexofficeApi;

use Codersgarden\PhpLexofficeApi\LexofficeBase;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;

class LexofficeDownPaymentInvoiceManager extends LexofficeBase
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * LexofficeDownPaymentInvoiceManager handles the retrieval of down payment invoices from the LexOffice API.
     *
     * This method allows you to fetch a specific down payment invoice by its unique identifier.
     * It sends a GET request to the LexOffice API to retrieve the invoice details.
     * The response includes key properties of the invoice, such as the invoice number, 
     * customer details, payment status, and amount information.
     *
     * Expected Response:
     * On success, this method returns the full details of the down payment invoice with the specified ID.
     * On failure, it returns an error message and the HTTP status code.
     *
     * Example usage:
     * ```php
     * $id = '592ecd3b-1e34-481e-89e7-a53d4e5465f0';
     * $response = $lexofficeDownPaymentInvoiceManager->find($id);
     * if ($response['success']) {
     *     // Handle successful response
     *     print_r($response['data']);
     * } else {
     *     // Handle error
     *     echo 'Error: ' . $response['error'];
     * }
     * ```
     *
     * @param string $id The unique identifier of the down payment invoice to retrieve.
     * @return array An array containing:
     *               - 'success' (bool): Indicates whether the request was successful.
     *               - 'data' (array|null): Contains the invoice data from the API on success.
     *               - 'status' (int|null): HTTP status code returned by the API on failure.
     *               - 'error' (string|null): Error message if the request fails.
     */


    public function find(string $id)
    {
        try {

            $response = $this->client->get("down-payment-invoices/{$id}");

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
     * Generate a view deeplink URL for a down payment invoice using its unique identifier.
     *
     * This method constructs a URL that allows you to view the down payment invoice in the LexOffice system.
     * The URL is generated by concatenating the base URI from the configuration with the specific invoice ID.
     * This is useful for redirecting users directly to the view page of a specific invoice.
     *
     * Example usage:
     * ```php
     * $id = '592ecd3b-1e34-481e-89e7-a53d4e5465f0';
     * $response = $manager->getViewDeeplink($id);
     * echo $response; // Outputs the deeplink URL to view the invoice
     * ```
     *
     * @param string $id The unique identifier of the down payment invoice.
     * @return string The generated deeplink URL to view the invoice in LexOffice.
     */
    public function getViewDeeplink(string $id): string
    {
        return config('lexoffice.base_uri') . "permalink/invoices/view/{$id}";
    }

    /**
     * Generate an edit deeplink URL for a down payment invoice using its unique identifier.
     *
     * This method constructs a URL that allows you to directly edit a down payment invoice in the LexOffice system.
     * The URL is generated by concatenating the base URI from the configuration with the specific invoice ID.
     * This is useful for redirecting users to the edit page of a specific invoice where they can modify its details.
     *
     * Example usage:
     * ```php
     * $id = '592ecd3b-1e34-481e-89e7-a53d4e5465f0';
     * $response = $manager->getEditDeeplink($id);
     * echo $response; // Outputs the deeplink URL to edit the invoice
     * ```
     *
     * @param string $id The unique identifier of the down payment invoice.
     * @return string The generated deeplink URL to edit the invoice in LexOffice.
     */


    public function getEditDeeplink(string $id): string
    {
        return config('lexoffice.base_uri') . "permalink/invoices/edit/{$id}";
    }
}
