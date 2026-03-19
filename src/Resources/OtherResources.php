<?php

declare(strict_types=1);

namespace Peepl\Resources;

use Peepl\PeeplPaginatedResult;
use Peepl\PeeplResource;

class AddressTypes extends PeeplResource
{
    public function list(): array
    {
        return $this->client->get('address_types');
    }

    public function create(string $description, int $maxAmount): array
    {
        return $this->client->post('address_types', [
            'description' => $description,
            'max_amount'  => $maxAmount,
        ]);
    }

    public function update(int $addressTypeId, string $description, int $maxAmount): array
    {
        return $this->client->put("address_types/{$addressTypeId}", [
            'description' => $description,
            'max_amount'  => $maxAmount,
        ]);
    }

    public function delete(int $addressTypeId): array
    {
        return $this->client->delete("address_types/{$addressTypeId}");
    }
}


class Groups extends PeeplResource
{
    /** Recursive list of all groups and their subgroups. */
    public function list(): array
    {
        return $this->client->get('groups');
    }

    /**
     * Paginated list of contacts or organisations currently in a group.
     *
     * @param string $objectType 'contacts' or 'organisations'
     */
    public function members(int $groupId, string $objectType, int $offset = 0): PeeplPaginatedResult
    {
        $this->validateObjectType($objectType);
        $data = $this->client->get("groups/{$groupId}/{$objectType}", ['offset' => $offset]);
        return $this->paginated($data);
    }

    /**
     * Paginated list of members in a group on a specific date.
     *
     * @param string $date Format: yyyymmdd
     */
    public function membersOnDate(int $groupId, string $objectType, string $date, int $offset = 0): PeeplPaginatedResult
    {
        $this->validateObjectType($objectType);
        $data = $this->client->get("groups/{$groupId}/{$objectType}/{$date}", ['offset' => $offset]);
        return $this->paginated($data);
    }
}


class Functions extends PeeplResource
{
    public function list(): array
    {
        return $this->client->get('functions');
    }

    public function members(int $functionId, string $objectType, int $offset = 0): PeeplPaginatedResult
    {
        $this->validateObjectType($objectType);
        $data = $this->client->get("functions/{$functionId}/{$objectType}", ['offset' => $offset]);
        return $this->paginated($data);
    }

    public function membersOnDate(int $functionId, string $objectType, string $date, int $offset = 0): PeeplPaginatedResult
    {
        $this->validateObjectType($objectType);
        $data = $this->client->get("functions/{$functionId}/{$objectType}/{$date}", ['offset' => $offset]);
        return $this->paginated($data);
    }
}


class Combinations extends PeeplResource
{
    public function list(): array
    {
        return $this->client->get('combinations');
    }

    public function byGroup(int $groupId): array
    {
        return $this->client->get("combinations/group/{$groupId}");
    }

    public function byFunction(int $functionId): array
    {
        return $this->client->get("combinations/function/{$functionId}");
    }

    public function members(int $combinationId, string $objectType, int $offset = 0): PeeplPaginatedResult
    {
        $this->validateObjectType($objectType);
        $data = $this->client->get("combinations/{$combinationId}/{$objectType}", ['offset' => $offset]);
        return $this->paginated($data);
    }

    public function membersOnDate(int $combinationId, string $objectType, string $date, int $offset = 0): PeeplPaginatedResult
    {
        $this->validateObjectType($objectType);
        $data = $this->client->get("combinations/{$combinationId}/{$objectType}/{$date}", ['offset' => $offset]);
        return $this->paginated($data);
    }
}


class Activities extends PeeplResource
{
    public function list(): array
    {
        return $this->client->get('activities');
    }

    /**
     * Create an internal activity.
     *
     * Required: name, description, default_price, start_date, is_public, permissions
     */
    public function createInternal(array $data): array
    {
        $data['type'] = 'internal';
        return $this->client->post('activities/internal', $data);
    }

    /**
     * Create an external activity.
     *
     * Required: name, description, start_date, is_public, permissions
     */
    public function createExternal(array $data): array
    {
        $data['type'] = 'external';
        return $this->client->post('activities/external', $data);
    }
}
