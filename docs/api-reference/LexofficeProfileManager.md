# LexofficeProfileManager Class Documentation

The `LexofficeProfileManager` The LexofficeProfileManager class integrates with the LexOffice API to manage profiles. It supports operations such as retrieving basic profile information.

---

## Table of Contents

1. [retrieving Profile Details ](#retrieving-Profile-Details)


---

## Using the LexOffice API Package

To use the LexOffice API package, first import the main class:

```php
use Codersgarden\PhpLexofficeApi\LexofficeProfileManager;
```

---
### Retrieving Profile Details

```php

$response = $LexofficeProfileManager->get();
```

**Description:**
- Retrieves the details of the company's profile. This includes information such as the organization ID, company name, user ID, user name, user email, business features, tax type, and whether the company is a small business.

---

## Example Usage in a Controller 

Below is a complete example demonstrating how to use the `LexofficeProfileManager` class within a Laravel controller:

```php

<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficeProfileManager;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $lexofficeProfileManager;

    public function __construct(LexofficeProfileManager $lexofficeProfileManager)
    {
        $this->lexofficeProfileManager = $lexofficeProfileManager;
    }

    public function index()
    {
        // Retrieve the profile details
        $response = $this->lexofficeProfileManager->get();

        // Dump the response (you can process or return this data as needed)
        dd($response);
    }
}