<?php

namespace Codersgarden\PhpLexofficeApi;

use Codersgarden\PhpLexofficeApi\LexofficeBase;
use GuzzleHttp\Exception\RequestException;

class LexofficeQuotationManager extends LexofficeBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new quotation in the LexOffice API.
     *
     * 
     * This method allows you to create a new quotation by providing the necessary 
     * data, such as items, addresses, pricing, etc. If you want to immediately 
     * finalize the quotation upon creation, set the `finalize` parameter to true.
     * By default, the quotation is created in a draft state.
     *
     * ### Usage Example:
     * ```php
     * $quotationData = [
     *     'voucherDate' => '2023-02-22T00:00:00.000+01:00', // Required
     *     'expirationDate' => '2023-03-22T00:00:00.000+01:00',
     *     'address' => [ // Required
     *         'name' => 'Bike & Ride GmbH & Co. KG', // Required
     *         'countryCode' => 'DE', // Required
     *     ],
     *     'lineItems' => [ // Required
     *         [
     *             'type' => 'custom', // Required
     *             'name' => 'Abus Kabelschloss Primo 590', // Required
     *             'quantity' => 2, // Required
     *             'unitName' => 'Stück',
     *             'unitPrice' => [ // Required
     *                 'currency' => 'EUR', // Required
     *                 'netAmount' => 13.4, // Required
     *                 'taxRatePercentage' => 19,
     *             ],
     *         ],
     *     ],
     *     'totalPrice' => [ // Required
     *         'currency' => 'EUR', // Required
     *     ],
     *     'taxConditions' => [ // Required
     *         'taxType' => 'net', // Required
     *     ],
     *     'title' => 'Quotation Title', // Optional
     *     'introduction' => 'Introduction text for the quotation', // Optional
     *     'remark' => 'Closing remarks for the quotation', // Optional
     * ];
     * 
     * $response = $lexofficeQuotationManager->create($quotationData);
     * ```
     *
     * ### Parameters:
     * - `array $data`: An array containing the data to create the quotation.  
     *   **Required Fields**:  
     *   - `voucherDate`: The date of the quotation. (e.g., '2023-02-22T00:00:00.000+01:00')  
     * - `expirationDate`: The expiration date of the quotation. (e.g., '2023-02-22T00:00:00.000+01:00') 
     *   - `address`: The address object. Must include:  
     *     - `name`: The name of the customer or business.  
     *     - `countryCode`: The country code (e.g., 'DE').  
     *   - `lineItems`: An array of line item objects. Each item must include:  
     *     - `type`: The type of the item (e.g., 'custom').  
     *     - `name`: The name of the item.  
     *     - `quantity`: The quantity of the item.  
     *     - `unitPrice`: The unit price object, which must include:  
     *       - `currency`: The currency code (e.g., 'EUR').  
     *       - `netAmount`: The net amount of the item.  
     *   - `totalPrice`: The total price object, which must include:  
     *     - `currency`: The currency code.  
     *   - `taxConditions`: The tax conditions object, which must include:  
     *     - `taxType`: The tax type (e.g., 'net').  
     *
     *   **Optional Fields**:  
     *   - `title`: A custom title for the quotation.  
     *   - `introduction`: An introduction or description for the quotation.  
     *   - `remark`: Closing remarks for the quotation.  
     *
     * - `bool $finalize`: (Optional) Flag to indicate whether to finalize the quotation immediately upon creation. Defaults to `false`.
     *
     * ### Return Value:
     * The function will return an array containing:
     * - `'success'`: A boolean indicating the success or failure of the request.
     * - `'data'`: If successful, this will contain the response data with details about the created quotation.
     * - `'error'`: If there is an error, this will contain the error message or details.
     *
     * ### Example Response:
     * ```php
     * return [
     *     'success' => true,
     *     'data' => [
     *         'id' => 'a2d06e95-3228-4260-90a5-880f8309af63',
     *         'voucherDate' => '2023-02-22T00:00:00.000+01:00',
     *         "createdDate" => "2024-11-28T06:21:09.075+01:00"
     *         "updatedDate" => "2024-11-28T06:21:09.077+01:00"
     *          "version" => 1
     *         ],
     *     ],
     * ];
     * ```
     *
     * ### Error Handling:
     * If an error occurs, such as a network failure or invalid data, the function will return:
     * - `'success'`: `false`
     * - `'status'`: The HTTP status code (e.g., 400, 500).
     * - `'error'`: The error message or response body, which may provide additional details.
     *
     * ### Example Error Response:
     * ```php
     * return [
     *     'success' => false,
     *     'status' => 400,
     *     'error' => 'Invalid data provided.',
     * ];
     * ```
     *
     * @param array $data The data for creating the quotation.
     * @param bool $finalize Whether to finalize the quotation immediately (optional).
     * @return array Response array with success, data, or error details.
     */

    public function create(array $data, bool $finalize = false)
    {
        try {
            $url = 'quotations';
            if ($finalize) {
                $url .= '?finalize=true';
            }

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
     * Find a specific quotation by its ID in the LexOffice API.
     *
     * This method fetches the details of a specific quotation by using its unique identifier (ID).
     * It sends a GET request to the LexOffice API and retrieves the quotation data. If the quotation is 
     * found, the details are returned. If the request fails, an error message is returned with the 
     * corresponding status code.
     *
     * ### Usage Example:
     * ```php
     * $quotationId = '424f784e-1f4e-439e-8f71-19673e6d6583';
     * $response = $lexofficeQuotationManager->find($quotationId);
     * if ($response['success']) {
     *     // Handle successful response
     *     $quotationData = $response['data'];
     * } else {
     *     // Handle error
     *     $errorMessage = $response['error'];
     *     $errorStatus = $response['status'];
     * }
     * ```
     *
     * ### Parameters:
     * - `string $id`: The unique identifier of the quotation to retrieve.
     *
     * ### Return Value:
     * The function will return an array with the following keys:
     * - `'success'`: A boolean indicating whether the request was successful (`true`) or not (`false`).
     * - `'data'`: If successful, this contains the details of the quotation, decoded from the response body.
     * - `'status'`: If the request failed, this contains the HTTP status code (e.g., 400, 404, 500).
     * - `'error'`: If an error occurs, this contains the error message or details from the API response.
     *
     * ### Example Response:
     * On success:
     * ```php
     * return [
     *     'success' => true,
     *     'data' => [
     *         'id' => '424f784e-1f4e-439e-8f71-19673e6d6583',
     *         'voucherDate' => '2023-02-22T00:00:00.000+01:00',
     *         'title' => 'Quotation Title',
     *         'address' => [
     *             'name' => 'Bike & Ride GmbH & Co. KG',
     *             'countryCode' => 'DE',
     *         ],
     *         'totalPrice' => [
     *             'currency' => 'EUR',
     *             'totalNetAmount' => 26.8,
     *             'totalGrossAmount' => 31.89,
     *             'totalTaxAmount' => 5.09,
     *         ],
     *         // other quotation details
     *     ],
     * ];
     * ```
     * On error:
     * ```php
     * return [
     *     'success' => false,
     *     'status' => 404,
     *     'error' => 'Quotation not found.',
     * ];
     * ```
     *
     * ### Error Handling:
     * In case of an error, such as a network issue or invalid quotation ID, the method will catch the exception
     * and return the error message, HTTP status code, and any other relevant information from the response.
     *
     * @param string $id The ID of the quotation to retrieve.
     * @return array An array containing `'success'`, `'data'` or `'error'`, and `'status'`.
     */


    public function find(string $id)
    {
        try {
            // Make the GET request to fetch the quotations
            $response = $this->client->get("quotations/{$id}");

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
     * Trigger the rendering of a document (PDF) for a specific quotation in the LexOffice API.
     *
     * This method makes a GET request to the LexOffice API to trigger the rendering of a PDF document 
     * for a specific quotation identified by its unique ID. The document will be generated and returned 
     * as a response. The method returns a success or error response, with relevant details about the 
     * rendering process.
     *
     * ### Usage Example:
     * ```php
     * $quotationId = '424f784e-1f4e-439e-8f71-19673e6d6583';
     * $response = $lexofficeQuotationManager->renderDocument($quotationId);
     * if ($response['success']) {
     *     // Handle successful response (e.g., display or save the rendered document)
     *     $documentData = $response['data'];
     * } else {
     *     // Handle error (e.g., show error message)
     *     $errorMessage = $response['error'];
     *     $errorStatus = $response['status'];
     * }
     * ```
     *
     * ### Parameters:
     * - `string $id`: The unique identifier of the quotation for which the document (PDF) should be rendered.
     *
     * ### Return Value:
     * The function will return an array with the following keys:
     * - `'success'`: A boolean indicating whether the request was successful (`true`) or not (`false`).
     * - `'data'`: If the document rendering was successful, this will contain the rendered document details, 
     *   which might include information like a document URL or binary content, depending on the API response.
     * - `'status'`: If the request failed, this contains the HTTP status code (e.g., 400, 404, 500).
     * - `'error'`: If an error occurs, this contains the error message or details from the API response.
     *
     * ### Example Response:
     * On success:
     * ```php
     * return [
     *     'success' => true,
     *     'data' => [
     *         'documentUrl' => 'https://example.com/document/424f784e-1f4e-439e-8f71-19673e6d6583.pdf',
     *         // other document-related data
     *     ],
     * ];
     * ```
     * On error:
     * ```php
     * return [
     *     'success' => false,
     *     'status' => 400,
     *     'error' => 'Failed to generate document.',
     * ];
     * ```
     *
     * ### Error Handling:
     * In case of an error (e.g., invalid quotation ID, network issues, etc.), the method catches the exception 
     * and returns the relevant error message along with the HTTP status code.
     *
     * @param string $id The ID of the quotation to render the document for.
     * @return array An array containing `'success'`, `'data'` or `'error'`, and `'status'`.
     */


    public function renderDocument(string $id)
    {   
        try {
            // Make the GET request to trigger PDF rendering
            $response = $this->client->get("quotations/{$id}/document");
            
    
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
     * Generate a deep link URL to view a specific quotation in the LexOffice system.
     *
     * This method constructs and returns a deep link URL that can be used to view a quotation in the LexOffice 
     * platform. The deep link URL is based on the unique identifier of the quotation, and it points to the 
     * view page of the quotation in the LexOffice system. The URL is generated using the base URI from 
     * the LexOffice configuration settings and appending the relevant permalink path.
     *
     * ### Usage Example:
     * ```php
     * $quotationId = '424f784e-1f4e-439e-8f71-19673e6d6583';
     * $deeplink = $lexofficeQuotationManager->getViewDeeplink($quotationId);
     * echo $deeplink;
     * // Output: https://your-lexoffice-domain.com/permalink/quotations/view/424f784e-1f4e-439e-8f71-19673e6d6583
     * ```
     *
     * ### Parameters:
     * - `string $id`: The unique identifier of the quotation for which the deep link should be generated.
     *
     * ### Return Value:
     * - `string`: The generated URL that points to the view page of the specified quotation in the LexOffice system.
     *
     * ### Example Response:
     * The returned deep link might look like:
     * ```php
     * 'https://your-lexoffice-domain.com/permalink/quotations/view/424f784e-1f4e-439e-8f71-19673e6d6583'
     * ```
     *
     * ### Notes:
     * - The deep link URL uses the base URI set in the LexOffice configuration (`lexoffice.base_uri`), 
     *   which should be set to the LexOffice system domain.
     *
     * @param string $id The ID of the quotation to generate the view deep link for.
     * @return string The full URL to view the quotation in the LexOffice platform.
     */

    public function getViewDeeplink(string $id)
    {    
       
        return config('lexoffice.base_uri') . "permalink/quotations/view/{$id}";
    }


    /**
     * Generate a deep link URL to edit a specific quotation in the LexOffice system.
     *
     * This method constructs and returns a deep link URL that can be used to edit a quotation in the LexOffice 
     * platform. The deep link URL is based on the unique identifier of the quotation, and it points to the 
     * edit page of the quotation in the LexOffice system. The URL is generated using the base URI from 
     * the LexOffice configuration settings and appending the relevant permalink path.
     *
     * ### Usage Example:
     * ```php
     * $quotationId = '424f784e-1f4e-439e-8f71-19673e6d6583';
     * $deeplink = $lexofficeQuotationManager->getEditDeeplink($quotationId);
     * echo $deeplink;
     * // Output: https://your-lexoffice-domain.com/permalink/quotations/edit/424f784e-1f4e-439e-8f71-19673e6d6583
     * ```
     *
     * ### Parameters:
     * - `string $id`: The unique identifier of the quotation for which the deep link should be generated.
     *
     * ### Return Value:
     * - `string`: The generated URL that points to the edit page of the specified quotation in the LexOffice system.
     *
     * ### Example Response:
     * The returned deep link might look like:
     * ```php
     * 'https://your-lexoffice-domain.com/permalink/quotations/edit/424f784e-1f4e-439e-8f71-19673e6d6583'
     * ```
     *
     * ### Notes:
     * - The deep link URL uses the base URI set in the LexOffice configuration (`lexoffice.base_uri`), 
     *   which should be set to the LexOffice system domain.
     *
     * @param string $id The ID of the quotation to generate the edit deep link for.
     * @return string The full URL to edit the quotation in the LexOffice platform.
     */


    public function getEditDeeplink(string $id): string
    {
        return config('lexoffice.base_uri') . "permalink/quotations/edit/{$id}";
    }
}
