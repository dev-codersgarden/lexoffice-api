# LexofficePaymentConditionManager Class Documentation

The `LexofficePaymentConditionManager` class integrates with the LexOffice API to manage  payment conditions. It supports operations such as retrieving payment conditions details.

---

## Table of Contents

1. [retrieving payment condition ](#retrieving-payment-condition)


---

## Using the LexOffice API Package

To use the LexOffice API package, first import the main class:

```php
use Codersgarden\PhpLexofficeApi\LexofficePaymentConditionManager;
```

---
### Retrieving a Payment Condition

```php

$response = $LexofficePaymentConditionManager->all();
```

**Description:**
- Retrieves details of a Payemnt condition.

---

## Example Usage in a Controller 

Below is a complete example demonstrating how to use the `LexofficePaymentConditionManager` class within a Laravel controller:

```php

<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficePaymentConditionManager;
use Illuminate\Http\Request;

class PaymentConditionController extends Controller
{
    protected $LexofficePaymentConditionManager;

    public function __construct(LexofficePaymentConditionManager $LexofficePaymentConditionManager)
    {
        $this->LexofficePaymentConditionManager = $LexofficePaymentConditionManager;
    }

    public function index()
    {   
        //1. Retrive
        
        $response = $LexofficePaymentConditionManager->all();
        dd($response);
    }
}