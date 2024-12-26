# LexofficeVoucherManager Class Documentation

The `LexofficeVoucherManager` class simplifies interactions with the LexOffice API, allowing operations such as creating, retrieving, updating, generating deeplinks, uploading files for vouchers, and retrieving filtered voucher lists.

---

## Table of Contents

1. [Using the LexOffice API Package](#using-the-lexoffice-api-package)
2. [Creating a Voucher](#creating-a-voucher)
3. [Retrieving a Voucher by ID](#retrieving-a-voucher-by-id)
4. [Updating a Voucher](#updating-a-voucher)
5. [Retrieving Vouchers with Filters](#retrieving-all-voucher-with-filters)
6. [Generate view and edit deeplinks for Voucher](#generate-view-and-edit-deeplinks-for-voucher)
7. [Upload a File for Voucher by ID](#upload-a-uile-to-a-voucher-by-ID)
8. [Example Usage in a Controller](#example-usage-in-a-controller)

---

## Using the LexOffice API Package

To use the LexOffice API package, first import the main class:

```php
use Codersgarden\PhpLexofficeApi\LexofficeVoucherManager;
```

---

### Creating an Voucher

```php
 $voucherData = [
            'type' => 'salesinvoice',
            'voucherNumber' => 'INV-2024-001',
            'voucherDate' => '2024-11-26',
            'shippingDate' => '2024-11-30',
            'dueDate' => '2024-12-15',
            'totalGrossAmount' => 119.00, 
            'totalTaxAmount' => 19.00,    
            'taxType' => 'gross',
            'voucherItems' => [
                [
                    'amount' => 119.00,
                    'taxAmount' => 19.00,   
                    'taxRatePercent' => 19,
                    'categoryId' => '8f8664a8-fd86-11e1-a21f-0800200c9a66',
                ],
            ],
            'remark' => 'Monthly subscription invoice.',
            'contactId' => '0d7d169c-21c9-4144-a52a-682e757f8b55',
        ];
$response = $LexofficeVoucherManager->create($voucherData);
```

**Description:**

-   Required fields: `voucherType`, `taxType`, `voucherItems` (with `amount`,`taxAmount`, `taxRatePercent`,`categoryId`).
-   Optional fields include `voucherStatus`, `voucherNumber`, `voucherDate`, `shippingDate`,`dueDate`,`totalGrossAmount`,`totalTaxAmount`,`useCollectiveContact`,`contactId`,`version`.

**Important Notes:**

-When creating a voucher with a status of unchecked, you can leave the fields voucherNumber, voucherDate, totalGrossAmount, and totalTaxAmount optional.
-The contactId is required unless useCollectiveContact is set to true.
-You must not include read-only fields in the request.

---

### Retrieving an Voucher by ID

```php
$voucherId = '0a739052-ce80-4ae6-a276-34524eec43b1'; // Example ID
$response = $LexofficeVoucherManager->find($voucherId);
```

**Description:**

-   Retrieves details of an Voucher based on its unique identifier.

---

### Updating an Voucher

```php
$voucherId = '0a739052-ce80-4ae6-a276-34524eec43b1'; // Example ID
$updateVoucherData  = [
            'type' => 'salesinvoice',
           
            'voucherDate' => '2024-11-26',
            'shippingDate' => '2024-11-30',
            'dueDate' => '2024-12-15',
            'totalGrossAmount' => 119.00, 
            'totalTaxAmount' => 19.00,    
            'taxType' => 'gross',
            'voucherItems' => [
                [
                    'amount' => 119.00,
                    'taxAmount' => 19.00,   
                    'taxRatePercent' => 19,
                    'categoryId' => '8f8664a8-fd86-11e1-a21f-0800200c9a66',
                ],
            ],
            'remark' => 'Monthly subscription invoice.',
            'contactId' => '0d7d169c-21c9-4144-a52a-682e757f8b55',
];
$response = $lexofficeArticleManager->update($voucherId, $updateVoucherData);
```

**Description:**

-   Updates an voucher using its ID and new data.

---

---

### Retrieving All voucher with Filters

```php
$filters = [
    'voucherNumber' => '123-456-789',

];
$response = $LexofficeVoucherManager->all($filters);
```

**Description:**

-   Retrieves all vouchers that match the specified filters. Supported filters include `voucherNumber`.

---

## Generating Deeplinks for a Voucher

### Methods:

1. **View Deeplink:** `getViewDeeplink(string $voucherId): string`
2. **Edit Deeplink:** `getEditDeeplink(string $voucherId): string`

**Example:**

```php
$voucherId = '0a739052-ce80-4ae6-a276-34524eec43b1';
$viewUrl = $LexofficeVoucherManager->getViewDeeplink($voucherId);
$editUrl = $LexofficeVoucherManager->getEditDeeplink($voucherId);

echo "View Voucher: " . $viewUrl;
echo "Edit Voucher: " . $editUrl;
```

## Generating Upload file for a voucher using ID.

```php
$voucherId = '0a739052-ce80-4ae6-a276-34524eec43b1'; // Example ID
$filePath = '/path/to/file.pdf';
$fileType = 'voucher';
$response = $LexofficeVoucherManager->uploadFile(string $voucherId, string $fileType, string $filePath);
if ($response['success']) {
    echo 'File uploaded successfully. File ID: ' . $response['data']['id'];
} else {
    echo 'Error: ' . $response['error'];
}

```

**Description:**

-   Retrieves details of an Voucher based on its unique identifier.

---

---

## Example Usage in a Controller

Below is a complete example demonstrating how to use the `LexofficeVoucherManager` class within a Laravel controller:

```php
<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficeVoucherManager;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $LexofficeVoucherManager;

    public function __construct(LexofficeVoucherManager $LexofficeVoucherManager)
    {
        $this->LexofficeVoucherManager = $LexofficeVoucherManager;
    }

    public function index()
    {
        // 1. Create an Voucher
         $voucherData = [
            'voucherDate' => '2024-11-27',
            'dueDate' => '2024-12-10',
            'voucherType' => 'invoice',
            'supplierName' => 'Example Supplier',
            'totalGrossAmount' => 123.45,
            'currency' => 'EUR',
            'lineItems' => [
                [
                    'description' => 'Item 1 Description',
                    'quantity' => 2,
                    'unitPrice' => 50.00,
                    'taxRate' => 19,
                    'totalAmount' => 119.00
                ]
            ]
        ];
        $createResponse = $this->LexofficeVoucherManager->create($voucherData);
        dd($createResponse);

        // 2. Retrieve an Voucher by ID
        $voucherId = 'dba9418a-2381-48cd-afa3-81c0c1d0e53e'; // Example ID
        $findResponse = $this->LexofficeVoucherManager->find($voucherId);
        dd($findResponse);

        // 3. Update an Voucher
        $voucherId = 'dba9418a-2381-48cd-afa3-81c0c1d0e53e'; // Example ID
        $updatedVoucherData = [
            'voucherDate' => '2024-11-27',
            'dueDate' => '2024-12-10',
            'voucherType' => 'invoice',
            'supplierName' => 'Example Supplier',
            'totalGrossAmount' => 123.45,
            'currency' => 'EUR',
            'lineItems' => [
                [
                    'description' => 'Item 1 Description',
                    'quantity' => 2,
                    'unitPrice' => 50.00,
                    'taxRate' => 19,
                    'totalAmount' => 119.00
                ]
            ]
        ];
        $updateResponse = $this->LexofficeVoucherManager->update($voucherId, $updatedVoucherData);
        dd($updateResponse);


        // 4. Retrieve an Voucher with  Filters
        $filters = [
            'voucherNumber' => '123-456-789',

        ];
        $Response = $this->LexofficeVoucherManager->all($filters);
        dd($Response);

        //5. Upload File


        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,png,xml|max:5120',
            'type' => 'required|in:voucher',
        ]);

        $filePath = $request->file('file')->getRealPath();
        $type = $request->input('type');

        $response = $this->lexofficeFileManager->uploadFile($filePath, $type);

        if ($response['success']) {
            return response()->json([
                'message' => 'File uploaded successfully.',
                'fileId' => $response['data']['id'],
            ], 202);
        }

        return response()->json([
            'message' => 'File upload failed.',
            'error' => $response['error'],
        ], $response['status'] ?? 500);
    }
}
```
