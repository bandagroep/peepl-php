<?php

declare(strict_types=1);

namespace Peepl;

use Peepl\Resources\Activities;
use Peepl\Resources\AddressTypes;
use Peepl\Resources\Combinations;
use Peepl\Resources\Contacts;
use Peepl\Resources\Functions;
use Peepl\Resources\Groups;
use Peepl\Resources\Organisations;

class PeeplClient
{
    public Contacts      $contacts;
    public Organisations $organisations;
    public AddressTypes  $addressTypes;
    public Groups        $groups;
    public Functions     $functions;
    public Combinations  $combinations;
    public Activities    $activities;

    /**
     * @param string $apiToken  Your Peepl API token (Settings > API in Peepl)
     * @param string $baseUrl   Override for self-hosted / staging environments
     */
    public function __construct(
        string $apiToken,
        string $baseUrl = 'https://api.peepl.io/v1/admin'
    ) {
        $http = new PeeplHttpClient($apiToken, $baseUrl);

        $this->contacts      = new Contacts($http);
        $this->organisations = new Organisations($http);
        $this->addressTypes  = new AddressTypes($http);
        $this->groups        = new Groups($http);
        $this->functions     = new Functions($http);
        $this->combinations  = new Combinations($http);
        $this->activities    = new Activities($http);
    }
}
