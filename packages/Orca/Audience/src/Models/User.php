<?php

namespace Orca\Audience\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Orca\Checkout\Models\CartProxy;
use Orca\Sales\Models\OrderProxy;
use Orca\Product\Models\ProductReviewProxy;
use Orca\Audience\Notifications\UserResetPassword;
use Orca\Audience\Contracts\User as UserContract;

class User extends Authenticatable implements UserContract
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = ['first_name', 'channel_id', 'last_name', 'gender', 'date_of_birth', 'email', 'phone', 'password', 'audience_group_id', 'subscribed_to_news_letter', 'is_verified', 'token', 'notes', 'status'];

    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the audience full name.
     */
    public function getNameAttribute() {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * Email exists or not
     */
    public function emailExists($email) {
        $results =  $this->where('email', $email);

        if ($results->count() == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the user group that owns the user.
     */
    public function group()
    {
        return $this->belongsTo(UserGroupProxy::modelClass(), 'user_group_id');
    }

    /**
    * Send the password reset notification.
    *
    * @param  string  $token
    * @return void
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPassword($token));
    }

    /**
     * Get the user address that owns the user.
     */
    public function addresses()
    {
        return $this->hasMany(UserAddressProxy::modelClass(), 'user_id');
    }

    /**
     * Get default user address that owns the user.
     */
    public function default_address()
    {
        return $this->hasOne(UserAddressProxy::modelClass(), 'user_id')->where('default_address', 1);
    }

    /**
     * User's relation with wishlist items
     */
    public function wishlist_items() {
        return $this->hasMany(WishlistProxy::modelClass(), 'user_id');
    }

    /**
     * get all cart inactive cart instance of a user
     */
    public function all_carts() {
        return $this->hasMany(CartProxy::modelClass(), 'user_id');
    }

    /**
     * get inactive cart inactive cart instance of a user
     */
    public function inactive_carts() {
        return $this->hasMany(CartProxy::modelClass(), 'user_id')->where('is_active', 0);
    }

    /**
     * get active cart inactive cart instance of a user
     */
    public function active_carts() {
        return $this->hasMany(CartProxy::modelClass(), 'user_id')->where('is_active', 1);
    }

    /**
     * get all reviews of a user
    */
    public function all_reviews() {
        return $this->hasMany(ProductReviewProxy::modelClass(), 'user_id');
    }

    /**
     * get all orders of a user
     */
    public function all_orders() {
        return $this->hasMany(OrderProxy::modelClass(), 'user_id');
    }
}