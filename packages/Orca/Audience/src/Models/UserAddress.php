<?php
namespace Orca\Audience\Models;

use Illuminate\Database\Eloquent\Model;
use Orca\Audience\Contracts\UserAddress as UserAddressContract;

class UserAddress extends Model implements UserAddressContract
{
    protected $table = 'user_addresses';

    protected $fillable = ['user_id' ,'address1', 'country', 'state', 'city', 'postcode', 'phone', 'default_address'];
}
