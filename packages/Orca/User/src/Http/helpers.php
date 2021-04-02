<?php
    if (! function_exists('bouncer')) {
        function bouncer()
        {
            return app()->make(\Orca\User\Bouncer::class);
        }
    }
?>