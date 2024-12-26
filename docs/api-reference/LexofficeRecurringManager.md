# LexofficeRecurringManager Class Documentation

The `LexofficeRecurringManager` class provides integration with the LexOffice API to manage recurring invoices. It supports operations such as retrieving, deeplinks for recurring invoices and retrieving payment details by ID.

---

## Table of Contents

1. [Retrieving a Recurring Invoice by Id](#retrieving-a-recurring-invoice-by-id)
2. [Retrieving a Recurring Invoice](#retrieving-a-recurring-invoice)
3. [Generating Deeplinks for a Recurring Invoice](#generating-deeplinks-for-a-recurring-invoice)


---

## Using the LexOffice API Package

To use the LexOffice API package, first import the main class:

```php
use Codersgarden\PhpLexofficeApi\LexofficeRecurringManager;
```

---
### Retrieving a Recurring Invoice by ID

```php
$id = '1f1dc13c-fd68-11ea-a8b9-ff40c7cabfe0'; // Example ID
$response = $LexofficeRecurringManager->find($id);
```

**Description:**
- Retrieves recurring template based on its unique identifier.

---

---
### Retrieving a Recurring Invoice

```php
$response = $LexofficeRecurringManager->all();
```

**Description:**
- Retrieves recurring template based on its unique identifier.

---


## Generating Deeplinks for a Recurring Invoice

### Methods:
1. **View Deeplink:** `getViewDeeplink(string $id): string`
2. **Edit Deeplink:** `getEditDeeplink(string $id): string`

**Example:**
```php
$id = '66bc42a2-cbab-4532-9f90-83bcda139002';
$id = $lexofficeCreditNoteManager->getViewDeeplink($id);
$id = $lexofficeCreditNoteManager->getEditDeeplink($id);

echo "View Recurring Invoice: " . $viewUrl;
echo "Edit Recurring Invoice: " . $editUrl;
```

---



## Example Usage in a Controller 

Below is a complete example demonstrating how to use the `LexofficeRecurringManager` class within a Laravel controller:

```php

<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficeRecurringManager;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $LexofficeRecurringManager;

    public function __construct(LexofficeRecurringManager $LexofficeRecurringManager)
    {
        $this->LexofficeRecurringManager = $LexofficeRecurringManager;
    }

    public function index()
    {
       
        // 1. Find
        $id = '1f1dc13c-fd68-11ea-a8b9-ff40c7cabfe0'; // Example ID
        $response = $LexofficeRecurringManager->find($id);

        //2.Retrive

        $response = $LexofficeRecurringManager->all();

        //3.Generate Deeplinks
        
        $viewUrl = $this->LexofficeRecurringManager->getViewDeeplink($id);
        $editUrl = $this->LexofficeRecurringManager->getEditDeeplink($id);

        dd($response, $viewUrl, $editUrl);


    }
}