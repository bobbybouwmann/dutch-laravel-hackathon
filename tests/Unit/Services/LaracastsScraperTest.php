<?php

namespace Tests\Unit\Services;

use App\Services\LaracastsScraper;
use App\Services\NullLaracastsScraper;
use GuzzleHttp\Client;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LaracastsScraperTest extends TestCase
{
    protected $laracastsScraper;
    protected $profile;
    protected $mockedClient;
    protected $fakeScraper;
    protected $statistics;

    public function setUp(): void
    {
        parent::setUp();

        $this->laracastsScraper = new LaracastsScraper;

        $this->mockedClient = Mockery::mock(new Client());

        $this->fakeScraper = new LaracastsScraper($this->mockedClient);

        $this->profile = file_get_contents(
            base_path('tests/Unit/Services/stubs/laracasts-profile.html')
        );

        $this->mockedClient
            ->shouldReceive('request')
            ->andReturnSelf()
            ->shouldReceive('getBody')
            ->andReturn($this->profile);

        $this->statistics = $this->fakeScraper->getDataFor('')->statistics();
    }

    /** @test */
    function it_returns_a_null_object_when_the_user_is_not_found()
    {
        $data = $this->laracastsScraper->getDataFor('not-existing-user');

        $this->assertTrue($data instanceof NullLaracastsScraper);

        $result = [
            'experience' => 0,
            'lessons' => 0,
            'best_replies' => 0,
            'badges' => [
                'beginner' => 0,
                'intermediate' => 0,
                'advanced' => 0,
                'total' => 0,
                'available_badges' => 21,
            ]
        ];

        $this->assertEquals($result, $data->statistics());
    }

    /** @test */
    function it_returns_the_experience_points()
    {
        $this->assertEquals(97720, $this->statistics['experience']);
    }

    /** @test */
    function it_returns_the_number_of_completed_lessons()
    {
        $this->assertEquals(771, $this->statistics['lessons']);
    }

    /** @test */
    function it_returns_the_number_of_best_replies()
    {
        $this->assertEquals(33, $this->statistics['best_replies']);
    }

    /** @test */
    function it_returns_the_number_of_obtained_badges()
    {
        $this->assertEquals(10, $this->statistics['badges']['total']);
    }

    /** @test */
    function it_returns_the_number_of_beginner_bages()
    {
        $this->assertEquals(9, $this->statistics['badges']['beginner']);
    }

    /** @test */
    function it_returns_the_number_of_intermediate_badges()
    {
        $this->assertEquals(1, $this->statistics['badges']['intermediate']);
    }

    /** @test */
    function it_returns_the_number_of_advanced_badges()
    {
        $this->assertEquals(0, $this->statistics['badges']['advanced']);
    }
}
