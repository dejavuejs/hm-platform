<?php
namespace Orca\Audience\Models;

use Illuminate\Database\Eloquent\Model;
use Orca\Audience\Contracts\UserGroup as UserGroupContract;

class UserGroup extends Model implements UserGroupContract
{
    protected $table = 'user_groups';

    protected $fillable = ['name', 'code', 'is_user_defined'];

    /**
     * Get the audience for this group.
    */
    public function user()
    {
        return $this->hasMany(UserProxy::modelClass());
    }
}
