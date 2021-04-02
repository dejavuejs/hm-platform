<?php

namespace Tests\Feature;

use Tests\TestCase;

use Auth;
use Crypt;

use App;
use Faker\Generator as Faker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Audience\Repositories\AudienceRepository as Audience;

class AuthTest extends TestCase
{
    protected $audience;

    /**
     * To check if the audience can view the login page or not
     *
     * @return void
     */
    public function testAudienceLoginPage()
    {
        config(['app.url' => 'http://prashant.com']);

        $response = $this->get('/audience/login');

        $response->assertSuccessful();

        $response->assertViewIs('shop::audiences.session.index');
    }

    public function testAudienceResgistrationPage()
    {
        config(['app.url' => 'http://prashant.com']);

        $response = $this->get('/audience/register');

        $response->assertSuccessful();

        $response->assertViewIs('shop::audiences.signup.index');
    }

    public function testAudienceRegistration() {
        $faker = \Faker\Factory::create();

        $allAudiences = array();

        $audiences = app(Audience::class);

        $created = $audiences->create([
            'first_name' => explode(' ', $faker->name)[0],
            'last_name' => explode(' ', $faker->name)[0],
            'channel_id' => core()->getCurrentChannel()->id,
            'gender' => $faker->randomElement($array = array ('Male','Female', 'Other')),
            'date_of_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'email' => $faker->email,
            'password' => bcrypt('12345678'),
            'is_verified' => 1
        ]);

        $this->assertEquals($created->id, $created->id);
    }

    public function testAudienceLogin()
    {
        config(['app.url' => 'http://prashant.com']);

        $audiences = app(Audience::class);
        $audience = $audiences->findOneByField('email', 'john@doe.net');

        $response = $this->post('/audience/login', [
            'email' => $audience->email,
            'password' => '12345678'
        ]);

        $response->assertRedirect('/audience/account/profile');
    }

        /**
         * Test that audience cannot login with the wrong credentials.
         */
        public function willNotLoginWithWrongCredentials()
        {
            $audiences = app(Audience::class);
            $audience = $audiences->findOneByField('email', 'john@doe.net');

            $response = $this->from(route('login'))->post(route('audience.session.create'),
                        [
                            'email' => $audience->email,
                            'password' => 'wrongpassword3428903mlndvsnljkvsd',
                        ]);

            $this->assertGuest();
        }

        /**
         * Test to confirm that audience cannot login if user does not exist.
         */
        public function willNotLoginWithNonexistingAudience()
        {
            $response = $this->post(route('audience.session.create'), [
                            'email' => 'fiaiia9q2943jklq34h203qtb3o2@something.com',
                            'password' => 'wrong-password',
                        ]);

            $this->assertGuest();
        }

        /**
         * To test that audience can logout
         */
        public function allowsAudienceToLogout()
        {
            $audience = auth()->guard('audience')->user();

            $this->get(route('audience.session.destroy'));

            $this->assertGuest();
        }
}
