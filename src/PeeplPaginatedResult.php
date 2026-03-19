<?php

declare(strict_types=1);

namespace Peepl;

class PeeplPaginatedResult
{
    public int $count;
    public ?string $next;
    public ?string $previous;
    public array $results;

    public function __construct(array $data)
    {
        $this->count    = (int) ($data['count']    ?? 0);
        $this->next     = $data['next']     ?? null;
        $this->previous = $data['previous'] ?? null;
        $this->results  = $data['results']  ?? [];
    }

    public function hasNextPage(): bool
    {
        return $this->next !== null;
    }

    public function hasPreviousPage(): bool
    {
        return $this->previous !== null;
    }
}
