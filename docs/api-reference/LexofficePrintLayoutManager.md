# LexofficePrintLayoutManager Class Documentation

The `LexofficePrintLayoutManager` class provides integration with the LexOffice API to manage print layout. It supports operations such as retrieving print layouts.

---

## Table of Contents

1. [Retrieving list of print layouts](#retrieving-a-print-layouts)


---

## Using the LexOffice API Package

To use the LexOffice API package, first import the main class:

```php
use Codersgarden\PhpLexofficeApi\LexofficePrintLayoutManager;
```

---
### Retrieving a Print Layouts

```php
$response = $LexofficePrintLayoutManager->all();
```

**Description:**
- Retrieves list of print layouts.

---

## Example Usage in a Controller 

Below is a complete example demonstrating how to use the `LexofficePrintLayoutManager` class within a Laravel controller:

```php

<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficePrintLayoutManager;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $LexofficePrintLayoutManager;

    public function __construct(LexofficePrintLayoutManager $LexofficePrintLayoutManager)
    {
        $this->LexofficePrintLayoutManager = $LexofficePrintLayoutManager;
    }

    public function index()
    {
        $response = $LexofficePrintLayoutManager->all();
        dd($response);
    }
}