# peepl-php

PHP client library for the [Peepl CRM API](https://www.peepl.io/en/apidocs/).

## Requirements

- PHP 7.4 or 8.x
- ext-curl
- ext-json

## Installation

```bash
composer require bandagroep/peepl-php
```

## Quick start

```php
use Peepl\PeeplClient;

$peepl = new PeeplClient('YOUR_API_TOKEN');

// List contacts (paginated)
$page = $peepl->contacts->list();
foreach ($page->results as $contact) {
    echo $contact['first_name'] . ' ' . $contact['last_name'] . PHP_EOL;
}

// Fetch a single contact
$contact = $peepl->contacts->get(1);

// Create a contact
$result = $peepl->contacts->create([
    'first_name'         => 'Jan',
    'last_name'          => 'De Smet',
    'birth_date'         => '1990-05-15',
    'birth_place'        => 'Gent',
    'preferred_language' => 'nl',
    'gender'             => 'M',
    'email'              => 'jan@example.be',
]);
echo $result['id']; // new contact ID
```

## Authentication

1. Log in to Peepl with administrator permissions.
2. Go to **Settings → API** and generate a token.
3. Pass the token to `PeeplClient`.

> ⚠️ The full token is only shown **once**. Store it safely (e.g. in an `.env` file).

## Resources

### Contacts

```php
$peepl->contacts->list(offset: 0, limit: 10);   // PeeplPaginatedResult
$peepl->contacts->get(int $id);
$peepl->contacts->create(array $data);
$peepl->contacts->update(int $id, array $data);
$peepl->contacts->search(['operator' => 'AND', 'last_name' => 'Doe']);
$peepl->contacts->segment(int $segmentId);
$peepl->contacts->customFields();
$peepl->contacts->customFieldCategories();
$peepl->contacts->positions(int $contactId);

// Addresses
$peepl->contacts->listAddresses(int $contactId);
$peepl->contacts->createAddress(int $contactId, array $data);
$peepl->contacts->updateAddress(int $contactId, int $addressId, array $data);
$peepl->contacts->deleteAddress(int $contactId, int $addressId);

// Secondary email addresses
$peepl->contacts->createEmailAddress(int $contactId, array $data);
$peepl->contacts->updateEmailAddress(int $contactId, int $emailId, array $data);
$peepl->contacts->deleteEmailAddress(int $contactId, int $emailId);

// Educations
$peepl->contacts->createEducation(int $contactId, array $data);
$peepl->contacts->updateEducation(int $contactId, int $educationId, array $data);
$peepl->contacts->deleteEducation(int $contactId, int $educationId);

// Company positions
$peepl->contacts->createCompanyPosition(int $contactId, array $data);
$peepl->contacts->updateCompanyPosition(int $contactId, int $positionId, array $data);
$peepl->contacts->deleteCompanyPosition(int $contactId, int $positionId);

// Custom field values
$peepl->contacts->createCustomFieldValue(int $contactId, array $data);
$peepl->contacts->updateCustomFieldValue(int $contactId, int $valueId, array $data);
```

### Organisations

Mirror of the Contacts resource, accessible via `$peepl->organisations`.

### Groups

```php
$peepl->groups->list();
$peepl->groups->members(int $groupId, 'contacts'|'organisations');
$peepl->groups->membersOnDate(int $groupId, 'contacts'|'organisations', 'yyyymmdd');
```

### Functions

```php
$peepl->functions->list();
$peepl->functions->members(int $functionId, 'contacts'|'organisations');
$peepl->functions->membersOnDate(int $functionId, 'contacts'|'organisations', 'yyyymmdd');
```

### Combinations

```php
$peepl->combinations->list();
$peepl->combinations->byGroup(int $groupId);
$peepl->combinations->byFunction(int $functionId);
$peepl->combinations->members(int $combinationId, 'contacts'|'organisations');
$peepl->combinations->membersOnDate(int $combinationId, 'contacts'|'organisations', 'yyyymmdd');
```

### Address Types

```php
$peepl->addressTypes->list();
$peepl->addressTypes->create(string $description, int $maxAmount);
$peepl->addressTypes->update(int $id, string $description, int $maxAmount);
$peepl->addressTypes->delete(int $id);
```

### Activities

```php
$peepl->activities->list();
$peepl->activities->createInternal(array $data);
$peepl->activities->createExternal(array $data);
```

## Pagination

Paginated endpoints return a `PeeplPaginatedResult` object:

```php
$page = $peepl->contacts->list(offset: 0);

echo $page->count;         // total number of results
$page->results;            // array of items on this page
$page->hasNextPage();      // bool
$page->hasPreviousPage();  // bool

// Loop through all pages
$offset = 0;
do {
    $page = $peepl->contacts->list($offset);
    foreach ($page->results as $contact) {
        // process...
    }
    $offset += 10;
} while ($page->hasNextPage());
```

> The API caps `limit` at **10** and allows up to **100 requests per minute**.

## Error handling

```php
use Peepl\PeeplException;

try {
    $contact = $peepl->contacts->get(99999);
} catch (PeeplException $e) {
    echo $e->getHttpStatus();   // e.g. 404
    echo $e->getMessage();      // e.g. "Not Found"
    print_r($e->getResponseBody());
}
```

## Self-hosted / staging

```php
$peepl = new PeeplClient('YOUR_TOKEN', 'https://your-own-peepl.example.com/v1/admin');
```

## Running tests

```bash
composer install
vendor/bin/phpunit
```

## License

MIT
