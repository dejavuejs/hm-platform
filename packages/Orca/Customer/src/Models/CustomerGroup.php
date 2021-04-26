<?php
namespace Orca\Customer\Models;

use Illuminate\Database\Eloquent\Model;
use Orca\Customer\Contracts\CustomerGroup as CustomerGroupContract;

class CustomerGroup extends Model implements CustomerGroupContract
{
    protected $table = 'customer_groups';

    protected $fillable = ['name', 'code', 'is_customer_defined'];

    /**
     * Get the customer for this group.
    */
    public function customer()
    {
        return $this->hasMany(CustomerProxy::modelClass());
    }
}
