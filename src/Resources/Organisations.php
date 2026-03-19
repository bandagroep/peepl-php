<?php

declare(strict_types=1);

namespace Peepl\Resources;

use Peepl\PeeplPaginatedResult;
use Peepl\PeeplResource;

class Organisations extends PeeplResource
{
    public function list(int $offset = 0, int $limit = 10): PeeplPaginatedResult
    {
        $data = $this->client->get('organisations', ['limit' => $limit, 'offset' => $offset]);
        return $this->paginated($data);
    }

    public function get(int $organisationId): array
    {
        return $this->client->get("organisations/{$organisationId}");
    }

    public function segment(int $segmentId, int $offset = 0): PeeplPaginatedResult
    {
        $data = $this->client->get("organisations/segments/{$segmentId}", ['offset' => $offset]);
        return $this->paginated($data);
    }

    public function customFieldCategories(): array
    {
        return $this->client->get('organisations/custom_field_categories');
    }

    public function customFields(): array
    {
        return $this->client->get('organisations/custom_fields');
    }

    public function positions(int $organisationId): array
    {
        return $this->client->get("organisations/{$organisationId}/positions");
    }

    // -------------------------------------------------------------------------
    // Addresses
    // -------------------------------------------------------------------------

    public function listAddresses(int $organisationId): array
    {
        return $this->client->get("organisations/{$organisationId}/addresses");
    }

    public function createAddress(int $organisationId, array $data): array
    {
        return $this->client->post("organisations/{$organisationId}/addresses", $data);
    }

    public function updateAddress(int $organisationId, int $addressId, array $data): array
    {
        return $this->client->put("organisations/{$organisationId}/addresses/{$addressId}", $data);
    }

    public function deleteAddress(int $organisationId, int $addressId): array
    {
        return $this->client->delete("organisations/{$organisationId}/addresses/{$addressId}");
    }

    // -------------------------------------------------------------------------
    // Email addresses
    // -------------------------------------------------------------------------

    public function createEmailAddress(int $organisationId, array $data): array
    {
        return $this->client->post("organisations/{$organisationId}/emailaddresses", $data);
    }

    public function updateEmailAddress(int $organisationId, int $emailId, array $data): array
    {
        return $this->client->put("organisations/{$organisationId}/emailaddresses/{$emailId}", $data);
    }

    public function deleteEmailAddress(int $organisationId, int $emailId): array
    {
        return $this->client->delete("organisations/{$organisationId}/emailaddresses/{$emailId}");
    }

    // -------------------------------------------------------------------------
    // Custom field values
    // -------------------------------------------------------------------------

    public function createCustomFieldValue(int $organisationId, array $data): array
    {
        return $this->client->post("organisations/{$organisationId}/customfieldvalues", $data);
    }

    public function updateCustomFieldValue(int $organisationId, int $valueId, array $data): array
    {
        return $this->client->put("organisations/{$organisationId}/customfieldvalues/{$valueId}", $data);
    }
}
