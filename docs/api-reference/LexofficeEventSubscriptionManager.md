# LexofficeEventSubscriptionManager Class Documentation

The `LexofficeEventSubscriptionManager` class provides seamless integration with the LexOffice API for managing event subscription. This class supports operations such as creating, retrieving,and deleting event subscriptions, as well as retrieving filtered lists of event subscription.

---

## Table of Contents

1. [Using the LexOffice API Package](#using-the-lexoffice-api-package)
2. [Creating an Event Subscription](#creating-an-event-subscription)
3. [Retrieving an Event Subscription by ID](#retrieving-an-event-subscription-by-id)
4. [Retrieving All Event Subscription](#retrieving-all-event-subscriptions)
5. [Deleting an Event Subscription](#deleting-an-event-subscription)
6. [Example Usage in a Controller](#example-usage-in-a-controller)

---

## Using the LexOffice API Package

To use the LexOffice API package, first import the main class:

```php
use Codersgarden\PhpLexofficeApi\LexofficeEventSubscriptionManager;
```

---

### Creating an Event Subscription

```php
$eventSubscriptionData = [
    'eventType' => 'contact.changed',
    'callbackUrl' => 'https://example.org/webhook',

];
$response = $LexofficeEventSubscriptionManager->create($eventSubscriptionData);
```

**Description:**

-   Required fields: `eventType`, `callbackUrl`.
-

---

### Retrieving an Event Subscription by subscriptionId

```php
$subscriptionId = 'eb46d328-e1dc-11ee-8444-2fadfc15a567'; // Example ID
$response = $LexofficeEventSubscriptionManager->find($subscriptionId);
```

**Description:**

-   Retrieves details of an event subscription based on its unique identifier.

---

### Deleting an Event Subscription

```php
$subscriptionId = 'eb46d328-e1dc-11ee-8444-2fadfc15a567'; // Example ID
$response = $LexofficeEventSubscriptionManager->delete($subscriptionId);
```

**Description:**

-   Deletes an Event Subscription based on its ID. Returns a success message upon successful deletion.

---

### Retrieving All Event Subscriptions

-   $response = $LexofficeEventSubscriptionManager->all();

**Description:**
- Retrieves all Event Subscriptions.

---

## Example Usage in a Controller

-  Below is a complete example demonstrating how to use the `LexofficeEventSubscriptionManager` class within a Laravel controller:

```php
<?php

namespace App\Http\Controllers;

use Codersgarden\PhpLexofficeApi\LexofficeEventSubscriptionManager;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $LexofficeEventSubscriptionManager;

    public function __construct(LexofficeEventSubscriptionManager $LexofficeEventSubscriptionManager)
    {
        $this->LexofficeEventSubscriptionManager = $LexofficeEventSubscriptionManager;
    }

    public function index()
    {
        // 1. Create an Event Subscription

        $eventSubscriptionData = [
            'eventType' => 'contact.changed',
            'callbackUrl' => 'https://example.org/webhook',
        ];
        $createResponse = $this->LexofficeEventSubscriptionManager->create($eventSubscriptionData);
        dd($createResponse);

        // 2. Retrieve an Event Subscription by SubscriptionId
        $subscriptionId = 'eb46d328-e1dc-11ee-8444-2fadfc15a567'; // Example ID
        $findResponse = $this->LexofficeEventSubscriptionManager->find($subscriptionId);
        dd($findResponse);


        // 3. Delete an Event Subscription
        $deleteResponse = $this->LexofficeEventSubscriptionManager->delete($subscriptionId);
        dd($deleteResponse);

        // 4. Retrieve All Event Subscription
        $allEventResponse = $this->LexofficeEventSubscriptionManager->all();
        dd($allEventResponse);
    }
}

````


