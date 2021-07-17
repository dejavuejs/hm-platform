<?php

namespace Sanskriti\Video\Policies;

use Sanskriti\Video\Models\Video;
use ZapInv\Authorization\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Video Policy class responsible video model access to screens and resources
 * Strictly to be applied for all routes which are authenticated.
 * For non-authenticated route this strictly should not be used.
 */
class VideoPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Before callback for policies
     */
    // public function before(Video $video)
    // {
    //     $video->id === $video->team->owner_id;
    // }

    /**
     * Policy object to be processed for reading model object
     *
     * @return void
     */
    public function view(Video $video)
    {
        // dd('policy');
        return $video->id === $video->team->owner_id;
    }

    /**
     * Policy object to be processed for create method
     *
     * @return void
     */
    public function create(Video $video)
    {
        return false;
    }

    /**
     * Policy object to be processed for update method
     *
     * @return void
     */
    public function update(Video $video)
    {
        return false;
    }

    /**
     * Policy object to be processed for delete method
     *
     * @return void
     */
    public function delete(Video $video)
    {
        return false;
    }
}
