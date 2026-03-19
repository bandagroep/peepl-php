<?php

declare(strict_types=1);

namespace Peepl;

abstract class PeeplResource
{
    protected PeeplHttpClient $client;

    public function __construct(PeeplHttpClient $client)
    {
        $this->client = $client;
    }

    protected function paginated(array $data): PeeplPaginatedResult
    {
        return new PeeplPaginatedResult($data);
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function validateObjectType(string $type): void
    {
        if (!in_array($type, ['contacts', 'organisations'], true)) {
            throw new \InvalidArgumentException(
                "objectType must be 'contacts' or 'organisations', got '{$type}'."
            );
        }
    }
}
