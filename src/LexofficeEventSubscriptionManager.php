<?php

namespace Codersgarden\PhpLexofficeApi;

use GuzzleHttp\Exception\RequestException;

class LexofficeEventSubscriptionManager extends LexofficeBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create an event subscription.
     *
     * This method sends a POST request to the `event-subscriptions` endpoint to create a new event subscription
     * in the system. The input data must conform to the expected format as defined by the API.
     *
     * Expected Input:
     * - `json` (array, required): The associative array containing subscription details.
     *   Example structure:
     *   ```php
     *   $data = [
     *       'eventType' => 'INVOICE.CREATED',
     *       'callbackUrl' => 'https://example.com/webhook',
     *       
     *   ];
     *   ```
     *
     * Return Values:
     * - On success:
     *   - `success` (bool): Returns `true`.
     *   - `data` (array): Contains the parsed response from the API, including details of the created subscription.
     *     Example:
     *     ```php
     *     [
     *         'id' => '12345',
     *         'eventType' => 'INVOICE.CREATED',
     *         'callbackUrl' => 'https://example.com/webhook',
     *         
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
     *         'error' => 'Invalid callback URL.',
     *     ];
     *     ```
     *
     * @param array $data The subscription data to be sent to the API. Example structure provided above.
     *
     * @return array An array with the following keys:
     *               - `success` (bool): Indicates whether the request was successful.
     *               - `data` (array|null): Contains the API response data on success.
     *               - `status` (int|null): The HTTP status code returned by the API on failure.
     *               - `error` (string|null): The error message if the request fails.
     *
     * @throws \GuzzleHttp\Exception\RequestException Thrown if an HTTP request error occurs.
     */
    public function create(array $data)
    {

        try {

            $response = $this->client->post('event-subscriptions', [
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
     * Retrieve an event subscription by ID.
     *
     * This method sends a GET request to the `event-subscriptions` endpoint to fetch details of a specific event subscription
     * using its unique identifier.
     *
     * Expected Input:
     * - `subscriptionId` (string, required): The unique identifier of the event subscription to be retrieved.
     *
     * Return Values:
     * - On success:
     *   - `success` (bool): Returns `true`.
     *   - `data` (array): Contains the details of the retrieved subscription.
     *     Example:
     *     ```php
     *     [
     *         'subscriptionId' => 'cd7f735c-c5d2-4826-93f6-a0df7d8860b0',
     *         'organizationId' => 'cd7f735c-c5d2-4826-93f6-a0df7d8860b0',
     *         'eventType' => 'contact.changed',
     *         'callbackUrl' => 'https://example.com/webhook',
     *         'createdDate' => '2024-11-27T11:06:47.772+01:00',
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
     *         'status' => 404,
     *         'error' => 'Subscription not found.',
     *     ];
     *     ```
     *
     * @param string $subscriptionId The unique identifier of the event subscription to retrieve.
     *
     * @return array An array with the following keys:
     *               - `success` (bool): Indicates whether the request was successful.
     *               - `data` (array|null): Contains the API response data on success.
     *               - `status` (int|null): The HTTP status code returned by the API on failure.
     *               - `error` (string|null): The error message if the request fails.
     *
     * @throws \GuzzleHttp\Exception\RequestException Thrown if an HTTP request error occurs.
     */

    public function find(string $subscriptionId)
    {
        try {
            // Make the GET request to fetch the dunnings
            $response = $this->client->get("event-subscriptions/{$subscriptionId}");

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
     * Retrieve all event subscriptions.
     *
     * This method sends a GET request to the `event-subscriptions` endpoint to fetch a list of all event subscriptions.
     * The response includes details about each subscription, such as its ID, event type, callback URL, and status.
     *
     * Return Values:
     * - On success:
     *   - `success` (bool): Returns `true`.
     *   - `data` (array): Contains an array of event subscriptions.
     *     Example:
     *     ```php
     *     [
     *         [
     *             'subscriptionId' => 'cd7f735c-c5d2-4826-93f6-a0df7d8860A0',
     *             'organizationId': 'cd7f735c-c5d2-4826-93f6-a0df7d8860A0',
     *             'eventType' => 'Icontact.changed',
     *             'callbackUrl' => 'https://example.com/webhook',
     *             'createdDate' => '2024-11-27T11:06:47.772+01:00',
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
     *         'status' => 500,
     *         'error' => 'Internal Server Error',
     *     ];
     *     ```
     *
     * @return array An array with the following keys:
     *               - `success` (bool): Indicates whether the request was successful.
     *               - `data` (array|null): Contains the API response data on success, an array of subscriptions.
     *               - `status` (int|null): The HTTP status code returned by the API on failure.
     *               - `error` (string|null): The error message if the request fails.
     *
     * @throws \GuzzleHttp\Exception\RequestException Thrown if an HTTP request error occurs.
     */


    public function all()
    {
        try {

            $response = $this->client->get("event-subscriptions");
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
     * Delete an event subscription by ID.
     *
     * This method sends a DELETE request to the `event-subscriptions` endpoint to remove a specific event subscription
     * using its unique identifier. If successful, the subscription is permanently deleted.
     *
     * Expected Input:
     * - `subscriptionId` (string, required): The unique identifier of the event subscription to be deleted.
     *
     * Return Values:
     * - On success:
     *   - `success` (bool): Returns `true`.
     *   - `message` (string): A confirmation message indicating the subscription was deleted successfully.
     *     Example:
     *     ```php
     *     [
     *         'success' => true,
     *         'message' => 'Event Subscription deleted successfully.',
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
     *         'status' => 404,
     *         'error' => 'Subscription not found.',
     *     ];
     *     ```
     *
     * @param string $subscriptionId The unique identifier of the event subscription to delete.
     *
     * @return array An array with the following keys:
     *               - `success` (bool): Indicates whether the request was successful.
     *               - `message` (string|null): A success message on deletion.
     *               - `status` (int|null): The HTTP status code returned by the API on failure.
     *               - `error` (string|null): The error message if the request fails.
     *
     * @throws \GuzzleHttp\Exception\RequestException Thrown if an HTTP request error occurs.
     */

    public function delete(string $subscriptionId)
    {
        try {
            $response = $this->client->delete("event-subscriptions/{$subscriptionId}");

            return [
                'success' => true,
                'message' => 'Event Subscription deleted successfully.',
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
