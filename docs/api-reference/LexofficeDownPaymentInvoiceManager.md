# LexofficeDownPaymentInvoiceManager Class Documentation

## The `LexofficeDownPaymentInvoiceManager` class provides seamless integration with the LexOffice API for managing Down Payment Invoices. This class supports operations such as retrieving and generating deeplinks for down payment invoice.

## Table of Contents

1. [Retrieving a Down Payment Invoice by Id](#retrieving-a-down-payment-invoice-by-Id)
2. [Generating Deeplinks for a Down Payment Invoice](#generating-deeplinks-for-a-down-payment-invoice)

---

## Using the LexOffice API Package

To use the LexOffice API package, first import the main class:

```php
use Codersgarden\PhpLexofficeApi\LexofficeDownPaymentInvoiceManager;
```

### Retrieving a Down Payment Invoice by ID

```php
$id = '1f1dc13c-fd68-11ea-a8b9-ff40c7cabfe0'; // Example ID
$response = $LexofficeDownPaymentInvoiceManager->find($id);
```

**Description:**

-   Retrieves details of a Down Payment Invoice based on its unique identifier.

---

## Generating Deeplinks for a Down Payment Invoice

### Methods:

1. **View Deeplink:** `getViewDeeplink(string $$id): string`
2. **Edit Deeplink:** `getEditDeeplink(string $$id): string`

**Example:**

```php
$$id = '66bc42a2-cbab-4532-9f90-83bcda139002';
$viewUrl = $LexofficeDunningManager->getViewDeeplink($$id);
$editUrl = $LexofficeDunningManager->getEditDeeplink($$id);

echo "View Down Payment Invoice: " . $viewUrl;
echo "Edit Down Payment Invoice: " . $editUrl;
```

---

## Example Usage in a Controller

Below is a complete example demonstrating how to use the `LexofficeDownPaymentInvoiceManager` class within a Laravel controller:

```php

<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficeDownPaymentInvoiceManager;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $LexofficeDownPaymentInvoiceManager;

    public function __construct(LexofficeDownPaymentInvoiceManager $LexofficeDownPaymentInvoiceManager)
    {
        $this->LexofficeDownPaymentInvoiceManager = $LexofficeDownPaymentInvoiceManager;
    }

    public function index()
    {

      // 1. Find
        $id = '1f1dc13c-fd68-11ea-a8b9-ff40c7cabfe0'; // Example ID
        $response = $LexofficeDownPaymentInvoiceManager->find($id);

        // 2. Generate Deeplinks
        $viewUrl = $this->LexofficeDownPaymentInvoiceManager->getViewDeeplink($id);
        $editUrl = $this->LexofficeDownPaymentInvoiceManager->getEditDeeplink($id);

        dd($response, $viewUrl, $editUrl);


    }
}
```
