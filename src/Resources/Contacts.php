<?php

declare(strict_types=1);

namespace Peepl\Resources;

use Peepl\PeeplPaginatedResult;
use Peepl\PeeplResource;

class Contacts extends PeeplResource
{
    /** Paginated list of all contacts. */
    public function list(int $offset = 0, int $limit = 10): PeeplPaginatedResult
    {
        $data = $this->client->get('contacts', ['limit' => $limit, 'offset' => $offset]);
        return $this->paginated($data);
    }

    /** Retrieve a single contact by ID. */
    public function get(int $contactId): array
    {
        return $this->client->get("contacts/{$contactId}");
    }

    /**
     * Create a new contact.
     *
     * Required: first_name, last_name, birth_date, birth_place,
     *           preferred_language, gender, email
     */
    public function create(array $data): array
    {
        return $this->client->post('contacts', $data);
    }

    /**
     * Update a contact's basic information.
     *
     * Required: first_name, last_name, birth_date, birth_place,
     *           preferred_language, gender, email
     */
    public function update(int $contactId, array $data): array
    {
        return $this->client->put("contacts/{$contactId}", $data);
    }

    /**
     * Search contacts.
     *
     * Required: operator ('AND'|'OR') + at least one of:
     *   first_name, last_name, city, email, last_modified (yyyy-mm-dd)
     */
    public function search(array $criteria): PeeplPaginatedResult
    {
        $data = $this->client->post('contacts/search', $criteria);
        return $this->paginated($data);
    }

    /** Get contacts in a segment. */
    public function segment(int $segmentId, int $offset = 0): PeeplPaginatedResult
    {
        $data = $this->client->get("contacts/segments/{$segmentId}", ['offset' => $offset]);
        return $this->paginated($data);
    }

    /** List all custom field categories for contacts. */
    public function customFieldCategories(): array
    {
        return $this->client->get('contacts/custom_field_categories');
    }

    /** List all custom fields for contacts. */
    public function customFields(): array
    {
        return $this->client->get('contacts/custom_fields');
    }

    /** List a contact's positions. */
    public function positions(int $contactId): array
    {
        return $this->client->get("contacts/{$contactId}/positions");
    }

    // -------------------------------------------------------------------------
    // Addresses
    // -------------------------------------------------------------------------

    public function listAddresses(int $contactId): array
    {
        return $this->client->get("contacts/{$contactId}/addresses");
    }

    public function createAddress(int $contactId, array $data): array
    {
        return $this->client->post("contacts/{$contactId}/addresses", $data);
    }

    public function updateAddress(int $contactId, int $addressId, array $data): array
    {
        return $this->client->put("contacts/{$contactId}/addresses/{$addressId}", $data);
    }

    public function deleteAddress(int $contactId, int $addressId): array
    {
        return $this->client->delete("contacts/{$contactId}/addresses/{$addressId}");
    }

    // -------------------------------------------------------------------------
    // Email addresses
    // -------------------------------------------------------------------------

    public function createEmailAddress(int $contactId, array $data): array
    {
        return $this->client->post("contacts/{$contactId}/emailaddresses", $data);
    }

    public function updateEmailAddress(int $contactId, int $emailId, array $data): array
    {
        return $this->client->put("contacts/{$contactId}/emailaddresses/{$emailId}", $data);
    }

    public function deleteEmailAddress(int $contactId, int $emailId): array
    {
        return $this->client->delete("contacts/{$contactId}/emailaddresses/{$emailId}");
    }

    // -------------------------------------------------------------------------
    // Educations
    // -------------------------------------------------------------------------

    public function createEducation(int $contactId, array $data): array
    {
        return $this->client->post("contacts/{$contactId}/educations", $data);
    }

    public function updateEducation(int $contactId, int $educationId, array $data): array
    {
        return $this->client->put("contacts/{$contactId}/educations/{$educationId}", $data);
    }

    public function deleteEducation(int $contactId, int $educationId): array
    {
        return $this->client->delete("contacts/{$contactId}/educations/{$educationId}");
    }

    // -------------------------------------------------------------------------
    // Company positions
    // -------------------------------------------------------------------------

    public function createCompanyPosition(int $contactId, array $data): array
    {
        return $this->client->post("contacts/{$contactId}/companypositions", $data);
    }

    public function updateCompanyPosition(int $contactId, int $positionId, array $data): array
    {
        return $this->client->put("contacts/{$contactId}/companypositions/{$positionId}", $data);
    }

    public function deleteCompanyPosition(int $contactId, int $positionId): array
    {
        return $this->client->delete("contacts/{$contactId}/companypositions/{$positionId}");
    }

    // -------------------------------------------------------------------------
    // Custom field values
    // -------------------------------------------------------------------------

    public function createCustomFieldValue(int $contactId, array $data): array
    {
        return $this->client->post("contacts/{$contactId}/customfieldvalues", $data);
    }

    public function updateCustomFieldValue(int $contactId, int $valueId, array $data): array
    {
        return $this->client->put("contacts/{$contactId}/customfieldvalues/{$valueId}", $data);
    }
}
