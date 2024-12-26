# LexofficeQuotationManage Class Documentation

The `LexofficeQuotationManage` class provides seamless integration with the LexOffice API for managing quotations. This class supports operations such as creating, retrieving, rendering PDF documents, and generating deeplinks for quotations.

---

## Features

-   **Create Quotations**: Supports draft quotation creation.
-   **Retrieve Quotations**: Fetch detailed information of a specific quotation.
-   **Render Quotations Document**: Trigger PDF rendering of a quotation.
-   **Generate Deeplinks**: Direct links to view or edit quotations.

---

## Table of Contents

1. [Import Class File](#import-class-file)
2. [Creating a Quotations](#creating-a-Quotations)
3. [Retrieving a Quotations](#retrieving-a-Quotations)
4. [Rendering a Quotations Document (PDF)](#rendering-a-Quotations-document-pdf)
5. [Generating Deeplinks for a Quotations](#generating-deeplinks-for-a-Quotations)
6. [Example Usage in a Laravel Controller](#example-usage-in-a-laravel-controller)

---

## Import Class File

To use this class, ensure that the LexOffice API package is installed and include the `LexofficeQuotationManage` class in your Laravel controller or service.

```php
use Codersgarden\PhpLexofficeApi\LexofficeQuotationManage;
```

---

## Creating a Quotation

### Method: `create(array $data, bool $finalize = false)`

This method creates a new quotation in draft or finalized mode.

**Example:**

```php
$quotationData = [

    "voucherDate": "2023-03-16T12:43:03.900+01:00",
    "expirationDate": "2023-04-15T12:43:03.900+02:00",
    "address": {
        "contactId": "97c5794f-8ab2-43ad-b459-c5980b055e4d",
        "name": "Berliner Kindl GmbH",
        "countryCode": "DE"
    },
    "lineItems": [
        {
            "id": "97c5794f-8ab2-43ad-b459-c5980b055e4d",
            "type": "custom",
            "name": "Axa Rahmenschloss Defender RL",
            "quantity": 1,
            "unitName": "Stück",
            "unitPrice": {
                "currency": "EUR",
                "netAmount": 20.08,
                "grossAmount": 23.9,
                "taxRatePercentage": 19
            },
        }
    ],
    "totalPrice": {
        "currency": "EUR",
    },

    "taxConditions": {
        "taxType": "gross"
    },
    "introduction": "Gerne bieten wir Ihnen an:",
    "remark": "Wir freuen uns auf Ihre Auftragserteilung und sichern eine einwandfreie Ausführung zu.",
    "title": "Angebot"
];

$response = $LexofficeQuotationManage->create($quotationData, true); // Pass true to finalize
```

**Return Value:**

-   `'success'`: Indicates success (`true`/`false`).
-   `'data'`: Created quotation details on success.
-   `'error'`: Error message if creation fails.

---

## Retrieving a Quotation

### Method: `find(string $id)`

Fetch detailed information of a Quotation by its ID.

**Example:**

```php
$id = '424f784e-1f4e-439e-8f71-19673e6d6583';
$response = $LexofficeQuotationManage->find($id);
```

**Return Value:**

-   `'success'`: Boolean indicating the success.
-   `'data'`: Contains quotation details.
-   `'error'`: Error message on failure.

---

## Rendering a Quotation Document (PDF)

### Method: `renderDocument(string $id)`

Triggers rendering of a quotation's PDF document.

**Example:**

```php
$id = '66bc42a2-cbab-4532-9f90-83bcda139002';
$response = $LexofficeQuotationManage->renderDocument($id);
```

**Return Value:**

-   `'success'`: Boolean indicating the success.
-   `'data'`: Contains `documentFileId`.
-   `'error'`: Error message on failure.

---

## Generating Deeplinks for a Quotation

### Methods:

1. **View Deeplink:** `getViewDeeplink(string $id): string`
2. **Edit Deeplink:** `getEditDeeplink(string $id): string`

**Example:**

```php
$id = 'e9066f04-8cc7-4616-93f8-ac9ecc8479c8';
$viewUrl = $LexofficeQuotationManage->getViewDeeplink($id);
$editUrl = $LexofficeQuotationManage->getEditDeeplink($id);

echo "View Quotation: " . $viewUrl;
echo "Edit Quotation: " . $editUrl;
```

---

## Example Usage in a Laravel Controller

Below is an example of how to use the `LexofficeQuotationManage` class in a Laravel controller:

```php
<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficeQuotationManage;

class HomeController extends Controller
{
    protected $LexofficeQuotationManage;

    public function __construct()
    {
        $this->LexofficeQuotationManage = new LexofficeQuotationManage();
    }

    public function index()
    {
        $id = 'e9066f04-8cc7-4616-93f8-ac9ecc8479c8';
        $quotationData=[
            'voucherDate' => '2023-02-22T00:00:00.000+01:00',
            'expirationDate' => '2023-02-22T00:00:00.000+01:00',
            'address' => [
                'name' => 'Bike & Ride GmbH & Co. KG',
                'countryCode' => 'DE',
            ],
            'lineItems' => [
                [
                    'type' => 'custom',
                    'name' => 'Abus Kabelschloss Primo 590',
                    'quantity' => 2,
                    'unitName' => 'Stück',
                    'unitPrice' => [
                        'currency' => 'EUR',
                        'netAmount' => 13.4,
                        'grossAmount' => 13.4,
                        'taxRatePercentage' => 19,
                    ],
                ],
            ],
            'totalPrice' => [
                'currency' => 'EUR',
            ],
            'taxConditions' => [
                'taxType' => 'net',
            ],
            'title' => 'Quotation Title',
            'introduction' => 'Introduction text for the quotation',
            'remark' => 'Closing remarks for the quotation',
        ];
        $finalize = false;  //optional  
        
        //1. Create Quotation

        $response = $this->LexofficeQuotationManage->create($quotationData,$finalize);

        // 2. Find Quotation
        $response = $this->LexofficeQuotationManage->find($id);

        // 3. Render Quotation PDF
        $response = $this->LexofficeQuotationManage->renderDocument($id);

        // 4. Generate Deeplinks
        $viewUrl = $this->LexofficeQuotationManage->getViewDeeplink($id);
        $editUrl = $this->LexofficeQuotationManage->getEditDeeplink($id);

        dd($response, $viewUrl, $editUrl);
    }
}
```
