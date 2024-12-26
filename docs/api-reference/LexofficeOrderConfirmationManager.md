# LexofficeOrderConfirmationManager Class Documentation

The `LexofficeOrderConfirmationManager` class integrates with the LexOffice API to manage order confirmations. It supports operations such as creating order confirmations, retrieving details, rendering PDF documents, and generating deeplinks for order confirmations.

---

## Features

-   **Create Order Confirmations**: Supports draft or finalized Order confirmations creation.
-   **Retrieve Order Confirmations**: Fetch detailed information of a specific Order confirmations.
-   **Pursue to Order Confirmations**: Convert a preceding sales voucher into a Order confirmations.
-   **Render Order confirmations Document**: Trigger PDF rendering of a credit confirmations.
-   **Generate Deeplinks**: Direct links to view or edit credit confirmations.

---

## Table of Contents

1. [Import Class File](#import-class-file)
2. [Creating a Order Confirmation](#creating-a-order-confirmation)
3. [Retrieving a Order Confirmation](#retrieving-a-order-confirmation)
4. [Pursuing a Sales Voucher to a Order Confirmation](#pursuing-a-sales-voucher-to-a-order-confirmation)
5. [Rendering a Order Confirmation Document (PDF)](#rendering-a-order-confirmation-document-pdf)
6. [Generating Deeplinks for a Order Confirmation](#generating-deeplinks-for-a-order-confirmation)
7. [Example Usage in a Laravel Controller](#example-usage-in-a-laravel-controller)

---

## Import Class File

To use this class, ensure that the LexOffice API package is installed and include the `LexofficeOrderConfirmationManager` class in your Laravel controller or service.

```php
use Codersgarden\PhpLexofficeApi\LexofficeOrderConfirmationManager;
```

---

## Creating a Order Confirmation

### Method: `create(array $data)`

This method creates a new Order Confirmation in draft.

**Example:**

```php
$OrderData = [
        "archived": false,
        "voucherDate": "2023-02-22T00:00:00.000+01:00",
        "address": {
        "name": "Bike & Ride GmbH & Co. KG",
          "supplement": "Gebäude 10",
          "street": "Musterstraße 42",
          "city": "Freiburg",
          "zip": "79112",
          "countryCode": "DE"
        },
        "lineItems": [
          {
            "type": "custom",
            "name": "Abus Kabelschloss Primo 590 ",
            "description": "· 9,5 mm starkes, smoke-mattes Spiralkabel mit integrierter Halterlösung zur Befestigung am Sattelklemmbolzen · bewährter Qualitäts-Schließzylinder mit praktischem Wendeschlüssel · KabelØ: 9,5 mm, Länge: 150 cm",
            "quantity": 2,
            "unitName": "Stück",
            "unitPrice": {
              "currency": "EUR",
              "netAmount": 13.4,
              "taxRatePercentage": 19
            },
            "discountPercentage": 50
          },
          {
            "type": "custom",
            "name": "Aufwändige Montage",
            "description": "Aufwand für arbeitsintensive Montagetätigkeit",
            "quantity": 1,
            "unitName": "Stunde",
            "unitPrice": {
              "currency": "EUR",
              "netAmount": 8.32,
              "taxRatePercentage": 7
            },
            "discountPercentage": 0
          },
          {
            "type": "custom",
            "name": "Energieriegel Testpaket",
            "quantity": 1,
            "unitName": "Stück",
            "unitPrice": {
              "currency": "EUR",
              "netAmount": 5,
              "taxRatePercentage": 0
            },
            "discountPercentage": 0
          },
          {
            "type": "text",
            "name": "Strukturieren Sie Ihre Belege durch Text-Elemente.",
            "description": "Das hilft beim Verständnis"
          }
        ],
        "totalPrice": {
          "currency": "EUR"
        },
        "taxConditions": {
          "taxType": "net"
        },
        "paymentConditions": {
          "paymentTermLabel": "10 Tage - 3 %, 30 Tage netto",
          "paymentTermDuration": 30,
          "paymentDiscountConditions": {
            "discountPercentage": 3,
            "discountRange": 10
          }
        },
        "shippingConditions": {
          "shippingDate": "2023-04-22T00:00:00.000+02:00",
          "shippingType": "delivery"
        },
        "title": "Auftragsbestätigung",
        "introduction": "Ihre bestellten Positionen stellen wir Ihnen hiermit in Rechnung",
        "remark": "Vielen Dank für Ihren Einkauf",
        "deliveryTerms": "Lieferung an die angegebene Lieferadresse"

      ];

$response = $LexofficeOrderConfirmationManager->create($OrderData);
```

**Return Value:**

-   `'success'`: Indicates success (`true`/`false`).
-   `'data'`: Created Order on success.
-   `'error'`: Error message if creation fails.

---

## Retrieve an Order Confirmation

### Method: `find(string $Id)`

Fetch detailed information of a Order Confirmation by its ID.

**Example:**

```php
$Id = 'e9066f04-8cc7-4616-93f8-ac9ecc8479c8';
$response = $LexofficeOrderConfirmationManager->find($Id);
```

**Return Value:**

-   `'success'`: Boolean indicating the success.
-   `'data'`: Contains an order confirmation details.
-   `'error'`: Error message on failure.

---

## Pursuing a Sales Voucher to a an order confirmation

### Method: `pursue(string $precedingSalesVoucherId, array $data)`

Convert a preceding sales voucher to a an order confirmation.

**Example:**

```php
$precedingSalesVoucherId = 'e9066f04-8cc7-4616-93f8-ac9ecc8479c8';
$OrderData = [
      "archived": false,
      "voucherDate": "2023-02-22T00:00:00.000+01:00",
      "address": {
      "name": "Bike & Ride GmbH & Co. KG",
        "supplement": "Gebäude 10",
        "street": "Musterstraße 42",
        "city": "Freiburg",
        "zip": "79112",
        "countryCode": "DE"
      },
      "lineItems": [
        {
          "type": "custom",
          "name": "Abus Kabelschloss Primo 590 ",
          "description": "· 9,5 mm starkes, smoke-mattes Spiralkabel mit integrierter Halterlösung zur Befestigung am Sattelklemmbolzen · bewährter Qualitäts-Schließzylinder mit praktischem Wendeschlüssel · KabelØ: 9,5 mm, Länge: 150 cm",
          "quantity": 2,
          "unitName": "Stück",
          "unitPrice": {
            "currency": "EUR",
            "netAmount": 13.4,
            "taxRatePercentage": 19
          },
          "discountPercentage": 50
        },
        {
          "type": "custom",
          "name": "Aufwändige Montage",
          "description": "Aufwand für arbeitsintensive Montagetätigkeit",
          "quantity": 1,
          "unitName": "Stunde",
          "unitPrice": {
            "currency": "EUR",
            "netAmount": 8.32,
            "taxRatePercentage": 7
          },
          "discountPercentage": 0
        },
        {
          "type": "custom",
          "name": "Energieriegel Testpaket",
          "quantity": 1,
          "unitName": "Stück",
          "unitPrice": {
            "currency": "EUR",
            "netAmount": 5,
            "taxRatePercentage": 0
          },
          "discountPercentage": 0
        },
        {
          "type": "text",
          "name": "Strukturieren Sie Ihre Belege durch Text-Elemente.",
          "description": "Das hilft beim Verständnis"
        }
      ],
      "totalPrice": {
        "currency": "EUR"
      },
      "taxConditions": {
        "taxType": "net"
      },
      "paymentConditions": {
        "paymentTermLabel": "10 Tage - 3 %, 30 Tage netto",
        "paymentTermDuration": 30,
        "paymentDiscountConditions": {
          "discountPercentage": 3,
          "discountRange": 10
        }
      },
      "shippingConditions": {
        "shippingDate": "2023-04-22T00:00:00.000+02:00",
        "shippingType": "delivery"
      },
      "title": "Auftragsbestätigung",
      "introduction": "Ihre bestellten Positionen stellen wir Ihnen hiermit in Rechnung",
      "remark": "Vielen Dank für Ihren Einkauf",
      "deliveryTerms": "Lieferung an die angegebene Lieferadresse"
    ];

$response = $LexofficeOrderConfirmationManager->pursue($precedingSalesVoucherId, $OrderData);
```

**Return Value:**

-   `'success'`: Boolean indicating the success.
-   `'data'`: Created Order details.
-   `'error'`: Error message on failure.

---

## Rendering a Order Confirmation Document (PDF)

### Method: `renderDocument(string $id)`

Triggers rendering of a order confirmation PDF document.

**Example:**

```php
$id = '66bc42a2-cbab-4532-9f90-83bcda139002';
$response = $LexofficeOrderConfirmationManager->renderDocument($id);
```

**Return Value:**

-   `'success'`: Boolean indicating the success.
-   `'data'`: Contains `documentFileId`.
-   `'error'`: Error message on failure.

---

## Generating Deeplinks for an Order Confirmation

### Methods:

1. **View Deeplink:** `getViewDeeplink(string $id): string`
2. **Edit Deeplink:** `getEditDeeplink(string $id): string`

**Example:**

```php
$id = '66bc42a2-cbab-4532-9f90-83bcda139002';
$viewUrl = $LexofficeOrderConfirmationManager->getViewDeeplink($id);
$editUrl = $LexofficeOrderConfirmationManager->getEditDeeplink($id);

echo "View Order Confirmation: " . $viewUrl;
echo "Edit Order Confirmation: " . $editUrl;
```

---

## Example Usage in a Laravel Controller

Below is an example of how to use the `LexofficeOrderConfirmationManager` class in a Laravel controller:

```php
<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficeOrderConfirmationManager;

class HomeController extends Controller
{
    protected $LexofficeOrderConfirmationManager;

    public function __construct()
    {
        $this->LexofficeOrderConfirmationManager = new LexofficeOrderConfirmationManager();
    }

    public function index()
    {
        $id = '66bc42a2-cbab-4532-9f90-83bcda139002';


        $precedingSalesVoucherId="c4ea398d-4ca4-4b4e-a24c-9d9499b49b78";

        //1.create Order Confirmation

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
         $response = $this->LexofficeOrderConfirmationManager->create($data);

        //2. pursue Order Confirmation

          $response = $this->LexofficeOrderConfirmationManager->pursue($precedingSalesVoucherId,$data);

        // 3. Find Order Confirmation
        $response = $this->LexofficeOrderConfirmationManager->find($id);

        // 4. Render Order Confirmation PDF
        $response = $this->LexofficeOrderConfirmationManager->renderDocument($id);

        // 5. Generate Deeplinks
        $viewUrl = $this->LexofficeOrderConfirmationManager->getViewDeeplink($id);
        $editUrl = $this->LexofficeOrderConfirmationManager->getEditDeeplink($id);

        dd($response, $viewUrl, $editUrl);
    }
}
```
