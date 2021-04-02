<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $audience = app('Orca\Audience\Repositories\AudienceRepository');

        $audience = $audience->all();

        $audience = $audience->first();

        $this->browse(function (Browser $browser) use($audience) {
            $browser->visit('/audience/login')
                ->type('email', $audience->email)
                ->type('password', $audience->password)
                ->click('input[type="submit"]')
                ->screenshot('error');
        });
    }
}
