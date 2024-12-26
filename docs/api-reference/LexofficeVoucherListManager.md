# LexofficeVoucherListManager Class Documentation

The `LexofficeVoucherListManager` class integrates with the LexOffice API to manage vouchers. It supports operations such as retrieving filtered lists of voucher lists.

---

## Table of Contents

1. [Retrieving All Vouchers with Filters](##retrieving-all-vouchers-with-filters)

---

## Using the LexOffice API Package

To use the LexOffice API package, first import the main class:

```php
use Codersgarden\PhpLexofficeApi\LexofficeVoucherListManager;
```

---

### Retrieving All Vouchers with Filters

```php
$filters = [
    'voucherType' => 'invoice', //required
    'voucherStatus': 'open', //required
    'voucherDateFrom' => '2023-03-01',
];
$response = $LexofficeVoucherListManager->all($filters);
```

**Description:**

-   Retrieves all Vouchers that match the specified filters. Supported filters include `voucherType`, `voucherStatus`, and `voucherDateFrom`.

---

## Example Usage in a Controller

Below is a complete example demonstrating how to use the `LexofficeVoucherListManager` class within a Laravel controller:

```php

<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficeVoucherListManager;
use Illuminate\Http\Request;

class VoucherListController  extends Controller
{
    protected $LexofficeVoucherListManager;

    public function __construct(LexofficeVoucherListManager $LexofficeVoucherListManager)
    {
        $this->LexofficeVoucherListManager = $LexofficeVoucherListManager;
    }

    public function index()
    {  

       //1. Retrive
       $filters =
        [
            'voucherType' => 'invoice',  //required
            'voucherStatus': 'open', //required
            'voucherDateFrom' => '2023-03-01',
        ];
        $response = $LexofficeVoucherListManager->all($filters);
        dd($response);


    }
}
```
