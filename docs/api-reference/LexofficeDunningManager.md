# LexofficeDunningManager Class Documentation

The `LexofficeDunningManager` class provides seamless integration with the LexOffice API for managing Dunnings. This class supports operations such as creating, retrieving, pursuing to Dunnings, rendering PDF documents, and generating deeplinks for Dunnings.

---

## Features

-   **Create Dunning**: Supports draft or finalized Dunning creation.
-   **Retrieve Dunning**: Fetch detailed information of a specific cDunning.
-   **Pursue to Dunning**: Convert a preceding sales voucher into a Dunning .
-   **Render Dunning Document**: Trigger PDF rendering of a Dunning .
-   **Generate Deeplinks**: Direct links to view or edit Dunning.

---

## Table of Contents

1. [Import Class File](#import-class-file)
2. [Creating a Dunning ](#creating-a-dunning)
3. [Retrieving a Dunning](#retrieving-a-dunning)
4. [Pursuing a Sales Voucher to a Dunning](#pursuing-a-sales-voucher-to-a-dunning)
5. [Rendering a Dunning Document (PDF)](#rendering-a-dunning-document-pdf)
6. [Generating Deeplinks for a Dunning](#generating-deeplinks-for-a-dunning)
7. [Example Usage in a Laravel Controller](#example-usage-in-a-laravel-controller)

---

## Import Class File

To use this class, ensure that the LexOffice API package is installed and include the `LexofficeDunningManager` class in your Laravel controller or service.

```php
use Codersgarden\PhpLexofficeApi\LexofficeDunningManager;
```

---

## Creating a Dunning

### Method: `create(array $data, string $precedingSalesVoucherId)`

This method creates a new Dunning in draft or finalized mode.

**Example:**

```php
$dunningData  = [
   "archived" => false,
    "voucherDate" => "2023-07-22T00:00:00.000+02:00",
    "address" => [
        "name" => "Bike & Ride GmbH & Co. KG",
        "supplement" => "Gebäude 10",
        "street" => "Musterstraße 42",
        "city" => "Freiburg",
        "zip" => "79112",
        "countryCode" => "DE"
    ],
    "lineItems" => [
        [
            "type" => "custom",
            "name" => "Energieriegel Testpaket",
            "quantity" => 1,
            "unitName" => "Stück",
            "unitPrice" => [
                "currency" => "EUR",
                "netAmount" => 5,
                "taxRatePercentage" => 0
            ],
            "discountPercentage" => 0
        ],
        [
            "type" => "text",
            "name" => "Strukturieren Sie Ihre Belege durch Text-Elemente.",
            "description" => "Das hilft beim Verständnis"
        ]
    ],
    "totalPrice" => [
        "currency" => "EUR",
        "totalNetAmount" => 15.0,
        "totalGrossAmount" => 17.85,
        "totalTaxAmount" => 2.85
    ],
    "taxConditions" => [
        "taxType" => "net"
    ],
    "shippingConditions" => [
        "shippingType" => "service",
        "shippingDate" => "2023-07-25T00:00:00.000+02:00",
        "shippingEndDate" => "2023-07-28T00:00:00.000+02:00"
    ],
    "title" => "Mahnung",
    "introduction" => "Wir bitten Sie, die nachfolgend aufgelisteten Lieferungen/Leistungen unverzüglich zu begleichen.",
    "remark" => "Sollten Sie den offenen Betrag bereits beglichen haben, betrachten Sie dieses Schreiben als gegenstandslos."
];

$response = $LexofficeDunningManager->create($dunningData,$precedingSalesVoucherId); // Pass true to finalize
```

**Return Value:**

-   `'success'`: Indicates success (`true`/`false`).
-   `'data'`: Created dunning details on success.
-   `'error'`: Error message if creation fails.

---

## Retrieving a Dunning

### Method: `find(string $dunningId)`

Fetch detailed information about a specific dunning request using its ID.

**Example:**

```php
$dunningId  = '66bc42a2-cbab-4532-9f90-83bcda139002';
$response = $LexofficeDunningManager->find($dunningId);
```

**Return Value:**

-   `'success'`: Boolean indicating the success.
-   `'data'`: Contains dunning details.
-   `'error'`: Error message on failure.

---

## Pursuing a Sales Voucher to a Dunning

### Method: `pursueTodunning(string $precedingSalesVoucherId, array $data)`

Convert a preceding sales voucher to a dunning.

**Example:**

```php
$precedingSalesVoucherId = 'e9066f04-8cc7-4616-93f8-ac9ecc8479c8';
$dunningData = [
    "archived" => false,
    "voucherDate" => "2023-07-22T00:00:00.000+02:00",
    "address" => [
        "name" => "Bike & Ride GmbH & Co. KG",
        "supplement" => "Gebäude 10",
        "street" => "Musterstraße 42",
        "city" => "Freiburg",
        "zip" => "79112",
        "countryCode" => "DE"
    ],
    "lineItems" => [
        [
            "type" => "custom",
            "name" => "Energieriegel Testpaket",
            "quantity" => 1,
            "unitName" => "Stück",
            "unitPrice" => [
                "currency" => "EUR",
                "netAmount" => 5,
                "taxRatePercentage" => 0
            ],
            "discountPercentage" => 0
        ],
        [
            "type" => "text",
            "name" => "Strukturieren Sie Ihre Belege durch Text-Elemente.",
            "description" => "Das hilft beim Verständnis"
        ]
    ],
    "totalPrice" => [
        "currency" => "EUR",
        "totalNetAmount" => 15.0,
        "totalGrossAmount" => 17.85,
        "totalTaxAmount" => 2.85
    ],
    "taxConditions" => [
        "taxType" => "net"
    ],
    "shippingConditions" => [
        "shippingType" => "service",
        "shippingDate" => "2023-07-25T00:00:00.000+02:00",
        "shippingEndDate" => "2023-07-28T00:00:00.000+02:00"
    ],
    "title" => "Mahnung",
    "introduction" => "Wir bitten Sie, die nachfolgend aufgelisteten Lieferungen/Leistungen unverzüglich zu begleichen.",
    "remark" => "Sollten Sie den offenen Betrag bereits beglichen haben, betrachten Sie dieses Schreiben als gegenstandslos."
];

$response = $LexofficeDunningManager->pursueToCreditNote($precedingSalesVoucherId, $dunningData);
```

**Return Value:**

-   `'success'`: Boolean indicating the success.
-   `'data'`: Created Dunning details.
-   `'error'`: Error message on failure.

---

## Rendering a Dunning Document (PDF)

### Method: `renderDocument(string $dunningId)`

Triggers rendering of a dunning's PDF document.

**Example:**

```php
$dunningId = '66bc42a2-cbab-4532-9f90-83bcda139002';
$response = $LexofficeDunningManager->renderDocument($dunningId);
```

**Return Value:**

-   `'success'`: Boolean indicating the success.
-   `'data'`: Contains `documentFileId`.
-   `'error'`: Error message on failure.

---

## Generating Deeplinks for a Dunning

### Methods:

1. **View Deeplink:** `getViewDeeplink(string $dunningId): string`
2. **Edit Deeplink:** `getEditDeeplink(string $dunningId): string`

**Example:**

```php
$dunningId = '66bc42a2-cbab-4532-9f90-83bcda139002';
$viewUrl = $LexofficeDunningManager->getViewDeeplink($dunningId);
$editUrl = $LexofficeDunningManager->getEditDeeplink($dunningId);

echo "View Dunning: " . $viewUrl;
echo "Edit Dunning: " . $editUrl;
```

---

## Example Usage in a Laravel Controller

Below is an example of how to use the `LexofficeDunningManager` class in a Laravel controller:

```php
<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficeDunningManager;

class HomeController extends Controller
{
    protected $LexofficeDunningManager;

    public function __construct()
    {
        $this->LexofficeDunningManager = new LexofficeDunningManager();
    }

    public function index()
    {
        $dunningId = '66bc42a2-cbab-4532-9f90-83bcda139002';
        $precedingSalesVoucherId = "c4ea398d-4ca4-4b4e-a24c-9d9499b49b78";
        $data = [
            "archived" => false,
            "voucherDate" => "2023-07-22T00:00:00.000+02:00",
            "address" => [
                "name" => "Bike & Ride GmbH & Co. KG",
                "supplement" => "Gebäude 10",
                "street" => "Musterstraße 42",
                "city" => "Freiburg",
                "zip" => "79112",
                "countryCode" => "DE"
            ],
            "lineItems" => [
                [
                    "type" => "custom",
                    "name" => "Energieriegel Testpaket",
                    "quantity" => 1,
                    "unitName" => "Stück",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 5,
                        "taxRatePercentage" => 0
                    ],
                    "discountPercentage" => 0
                ],
                [
                    "type" => "text",
                    "name" => "Strukturieren Sie Ihre Belege durch Text-Elemente.",
                    "description" => "Das hilft beim Verständnis"
                ]
            ],
            "totalPrice" => [
                "currency" => "EUR",
                "totalNetAmount" => 15.0,
                "totalGrossAmount" => 17.85,
                "totalTaxAmount" => 2.85
            ],
            "taxConditions" => [
                "taxType" => "net"
            ],
            "shippingConditions" => [
                "shippingType" => "service",
                "shippingDate" => "2023-07-25T00:00:00.000+02:00",
                "shippingEndDate" => "2023-07-28T00:00:00.000+02:00"
            ],
            "title" => "Mahnung",
            "introduction" => "Wir bitten Sie, die nachfolgend aufgelisteten Lieferungen/Leistungen unverzüglich zu begleichen.",
            "remark" => "Sollten Sie den offenen Betrag bereits beglichen haben, betrachten Sie dieses Schreiben als gegenstandslos."
        ];

        // 1. Create Dunning

        $response = $this->LexofficeDunningManager->create($data);

        //2.Fetch Dunning
        
        $response = $this->LexofficeDunningManager->pursueTodunning($precedingSalesVoucherId,$data);

        // 3 Find Dunning
        $response = $this->LexofficeDunningManager->find($dunningId);

        // 4. Render Dunning PDF
        $response = $this->LexofficeDunningManager->renderDocument($dunningId);

        // 5. Generate Deeplinks
        $viewUrl = $this->LexofficeDunningManager->getViewDeeplink($dunningId);
        $editUrl = $this->LexofficeDunningManager->getEditDeeplink($dunningId);

        dd($response, $viewUrl, $editUrl);
    }
}
```
