<?php

namespace Bean\Contact\Api\Contacts;

use CloudCreativity\LaravelJsonApi\Contracts\Validation\ValidatorInterface;
use Illuminate\Validation\Rule;
use CloudCreativity\LaravelJsonApi\Validation\AbstractValidators;
use Illuminate\Database\Schema\Builder;

class Validators extends AbstractValidators
{

    /**
     * The include paths a client is allowed to request.
     *
     * @var string[]|null
     *      the allowed paths, an empty array for none allowed, or null to allow all paths.
     */
    protected $allowedIncludePaths = null;

    /**
     * The sort field names a client is allowed send.
     *
     * @var string[]|null
     *      the allowed fields, an empty array for none allowed, or null to allow all fields.
     */
    protected $allowedSortParameters = null;

    /**
     * The filters a client is allowed send.
     *
     * @var string[]|null
     *      the allowed filters, an empty array for none allowed, or null to allow all.
     */
    protected $allowedFilteringParameters = null;

    /**
     * Get resource validation rules.
     *
     * @param mixed|null $record
     *      the record being updated, or null if creating a resource.
     * @return mixed
     */
    protected function rules($record = null): array
    {
        $defaultStringLength = Builder::$defaultStringLength;
        if ($record == null) {
            return [
                'first_name'  => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'last_name'   => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'address'     => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'address_2'   => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'city'        => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'state'       => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'postcode'    => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'country'     => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'phone'       => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'fax'         => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'email'       => 'sometimes|nullable|string|max:'.$defaultStringLength,
                'object_type' => 'required|string|max:'.$defaultStringLength,
                'object_id'   => 'required|string|max:'.$defaultStringLength,
            ];
        }
        return [
            'first_name'  => 'sometimes|nullable|string|max:'.$defaultStringLength,
            'last_name'   => 'sometimes|nullable|string|max:'.$defaultStringLength,
            'address'     => 'sometimes|nullable|string|max:'.$defaultStringLength,
            'address_2'   => 'sometimes|nullable|string|max:'.$defaultStringLength,
            'city'        => 'sometimes|nullable|string|max:'.$defaultStringLength,
            'state'       => 'sometimes|nullable|string|max:'.$defaultStringLength,
            'postcode'    => 'sometimes|nullable|string|max:'.$defaultStringLength,
            'country'     => 'sometimes|nullable|string|max:'.$defaultStringLength,
            'phone'       => 'sometimes|nullable|string|max:'.$defaultStringLength,
            'fax'         => 'sometimes|nullable|string|max:'.$defaultStringLength,
            'email'       => 'sometimes|nullable|string|max:'.$defaultStringLength,
        ];
    }

    /**
     * Get query parameter validation rules.
     *
     * @return array
     */
    protected function queryRules(): array
    {
        return [
            'filter.object_type' => 'required|string',
            'filter.object_id'   => 'required|string',
            'filter.name'        => 'sometimes|required|string',
        ];
    }

    /**
     * @inheritDoc
     */
    public function create(array $document): ValidatorInterface
    {
        $defaultStringLength = Builder::$defaultStringLength;

        $validator = parent::create($document);
        $base = ((array)$validator)["\x00*\x00validator"]; // trick to access protected property
        $base->addRules([
            'name'               => [
                'required',
                'string',
                'max:'.$defaultStringLength,
                Rule::unique('bean_contacts')
                ->where(function ($query) use ($base) {
                    $attributes = $base->getData();
                    return $query->where('object_type', $attributes['object_type'])->where('object_id', $attributes['object_id']);
                })
            ]
        ]);
        return $validator;
    }

    /**
     * @inheritDoc
     */
    public function update($record, array $document): ValidatorInterface
    {
        $defaultStringLength = Builder::$defaultStringLength;

        $validator = parent::create($document);
        $base = ((array)$validator)["\x00*\x00validator"]; //trick to access protected property
        $base->addRules([
            'object_type' => 'required_with:object_id,name|string|max:'.$defaultStringLength,
            'object_id'   => 'required_with:object_type,name|string|max:'.$defaultStringLength,
            'name'               => [
                'required_with:object_id,object_type',
                'string',
                'max:'.Builder::$defaultStringLength,
                Rule::unique('bean_contacts')->ignore($record->id)
                ->where(function ($query) use ($base) {
                    $attributes = $base->getData();
                    return $query->where('object_type', $attributes['object_type'])->where('object_id', $attributes['object_id']);
                })
            ]
        ]);
        return $validator;
    }
}
