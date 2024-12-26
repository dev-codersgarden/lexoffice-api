# LexofficePaymentManager Class Documentation

The `LexofficePaymentManager` class provides integration with the LexOffice API to manage payments. It supports operations such as retrieving payment details by voucher ID.

---

## Table of Contents

1. [Retrieving a Payment by VoucherId](#retrieving-a-payment-by-voucherId)

---

## Using the LexOffice API Package

To use the LexOffice API package, first import the main class:

```php
use Codersgarden\PhpLexofficeApi\LexofficePaymentManager;
```

---

### Retrieving a Payment by Voucher ID

```php
$voucherId = '1f1dc13c-fd68-11ea-a8b9-ff40c7cabfe0'; // Example ID
$response = $LexofficePaymentManager->find($voucherId);
```

**Description:**

-   Retrieves details of a Payment based on its unique identifier.

---

## Example Usage in a Controller

Below is a complete example demonstrating how to use the `LexofficePaymentManager` class within a Laravel controller:

```php

<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficePaymentManager;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $lexofficePaymentManager;

    public function __construct(LexofficePaymentManager $lexofficePaymentManager)
    {
        $this->lexofficePaymentManager = $lexofficePaymentManager;
    }

    public function index()
    {

        $voucherId = '1f1dc13c-fd68-11ea-a8b9-ff40c7cabfe0'; // Example ID
        $response = $LexofficePaymentManager->find($voucherId);
        dd($response);


    }
}
```
