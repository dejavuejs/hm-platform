<?php

namespace Orca\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Orca\Core\Contracts\CountryState as CountryStateContract;


class CountryState extends Model implements CountryStateContract
{
    public $timestamps = false;
}