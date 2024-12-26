# LexofficePostingCategorieManager Class Documentation

The `LexofficePostingCategorieManager` class provides integration with the LexOffice API to manage posting categorie. It supports operations such as retrieving posting categories.

---

## Table of Contents

1. [Retrieving a Posting Categories](#retrieving-a-posting-categories)


---

## Using the LexOffice API Package

To use the LexOffice API package, first import the main class:

```php
use Codersgarden\PhpLexofficeApi\LexofficePostingCategorieManager;
```

---
### Retrieving a Posting Categories

```php
$response = $LexofficePostingCategorieManager->all();
```

**Description:**
- Retrieves details of a posting categories.

---

## Example Usage in a Controller 

Below is a complete example demonstrating how to use the `LexofficePostingCategorieManager` class within a Laravel controller:

```php

<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficePostingCategorieManager;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $LexofficePostingCategorieManager;

    public function __construct(LexofficePostingCategorieManager $LexofficePostingCategorieManager)
    {
        $this->LexofficePostingCategorieManager = $LexofficePostingCategorieManager;
    }

    public function index()
    {
        $response = $LexofficePostingCategorieManager->all();
        dd($response);
    }
}