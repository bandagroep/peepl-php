<?php

declare(strict_types=1);

namespace Peepl\Tests;

use PHPUnit\Framework\TestCase;
use Peepl\PeeplClient;
use Peepl\PeeplException;
use Peepl\PeeplHttpClient;
use Peepl\PeeplPaginatedResult;
use Peepl\Resources\Contacts;

class PeeplClientTest extends TestCase
{
    public function testClientInstantiatesAllResources(): void
    {
        $client = new PeeplClient('test-token');

        $this->assertInstanceOf(\Peepl\Resources\Contacts::class,      $client->contacts);
        $this->assertInstanceOf(\Peepl\Resources\Organisations::class, $client->organisations);
        $this->assertInstanceOf(\Peepl\Resources\AddressTypes::class,  $client->addressTypes);
        $this->assertInstanceOf(\Peepl\Resources\Groups::class,        $client->groups);
        $this->assertInstanceOf(\Peepl\Resources\Functions::class,     $client->functions);
        $this->assertInstanceOf(\Peepl\Resources\Combinations::class,  $client->combinations);
        $this->assertInstanceOf(\Peepl\Resources\Activities::class,    $client->activities);
    }

    public function testPaginatedResultParsesCorrectly(): void
    {
        $data = [
            'count'    => 42,
            'next'     => 'https://api.peepl.io/v1/admin/contacts/?offset=10',
            'previous' => null,
            'results'  => [['id' => 1], ['id' => 2]],
        ];

        $result = new PeeplPaginatedResult($data);

        $this->assertSame(42, $result->count);
        $this->assertTrue($result->hasNextPage());
        $this->assertFalse($result->hasPreviousPage());
        $this->assertCount(2, $result->results);
    }

    public function testPeeplExceptionStoresHttpStatus(): void
    {
        $e = new PeeplException('Not Found', 404, ['detail' => 'Not Found']);

        $this->assertSame(404, $e->getHttpStatus());
        $this->assertSame('Not Found', $e->getMessage());
        $this->assertSame(['detail' => 'Not Found'], $e->getResponseBody());
    }

    public function testGroupsThrowsOnInvalidObjectType(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $http   = $this->createMock(PeeplHttpClient::class);
        $groups = new \Peepl\Resources\Groups($http);
        $groups->members(1, 'invalid_type');
    }
}
