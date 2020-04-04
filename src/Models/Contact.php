<?php

namespace Bean\Contact\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'bean_contacts';

    public $fillable = [
        'first_name', 'last_name', 'address', 'address_2', 'city',
        'state', 'postcode', 'country', 'phone', 'fax',
        'email', 'object_type', 'object_id', 'name',
    ];

    public function scopeObjectType($query, $type)
    {
        $type && $query->where('object_type', 'like', '%\\'.$type);
    }
}
