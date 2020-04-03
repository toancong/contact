<?php

namespace Bean\Contact\Api\Contacts;

use Bean\Contact\Models\Contact;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;

class Adapter extends AbstractAdapter
{
    protected $defaultSort = '-id';

    protected $defaultPagination = [
        'number' => 1,
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Contact, $paging);
    }

    protected function filter($query, Collection $filters)
    {
        $this->filterWithScopes($query, $filters);
    }
}
