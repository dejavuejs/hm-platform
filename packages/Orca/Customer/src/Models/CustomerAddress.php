<?php
namespace Orca\Customer\Models;

use Illuminate\Database\Eloquent\Model;
use Orca\Customer\Contracts\CustomerAddress as CustomerAddressContract;

class CustomerAddress extends Model implements CustomerAddressContract
{
    protected $table = 'customer_addresses';

    protected $fillable = ['customer_id' ,'address1', 'country', 'state', 'city', 'postcode', 'phone', 'default_address'];
}
