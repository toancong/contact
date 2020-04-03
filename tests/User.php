<?php

namespace Bean\Contact\Tests;

use Bean\Contact\Traits\Contactable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Contactable;
}
