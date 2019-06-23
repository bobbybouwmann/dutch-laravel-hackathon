<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\LaracastsScraper;
use App\Services\NullLaracastsScraper;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class LaracastsScraperTest extends TestCase
{
    protected $scraper;
    protected $stub;
    protected $mockedClient;
    protected $fakeScraper;
    protected $statistics;

    public function setUp(): void
    {
        parent::setUp();

        $this->stub = file_get_contents(
            base_path('tests/Unit/Services/stubs/laracasts-profile.html')
        );

        $this->mockedClient = Mockery::mock(new Client());

        $this->mockedClient
            ->shouldReceive('request')
            ->andReturnSelf()
            ->shouldReceive('getBody')
            ->andReturn($this->stub);
    }

    /** @test */
    public function if_a_user_is_not_found_a_null_object_is_returned()
    {
        $laracastsScraper = resolve(LaracastsScraper::class);

        $this->assertInstanceOf(
            NullLaracastsScraper::class,
            $laracastsScraper->getDataFor('not-existing-user')
        );
    }

    /** @test */
    public function it_returns_0_for_every_property_if_a_user_was_not_found()
    {
        $data = $this->getStatisticsFor('not-existing-user');

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

        $this->assertEquals($result, $data);
    }

    /** @test */
    public function it_returns_the_experience_points()
    {
        $this->mockClient();

        $this->assertStatistics(97720, 'experience');
    }

    /** @test */
    public function it_returns_the_number_of_completed_lessons()
    {
        $this->mockClient();

        $this->assertStatistics(771, 'lessons');
    }

    /** @test */
    public function it_returns_the_number_of_best_replies()
    {
        $this->mockClient();

        $this->assertStatistics(33, 'best_replies');
    }

    /** @test */
    public function it_returns_the_number_of_obtained_badges()
    {
        $this->mockClient();

        $this->assertStatistics(10, 'badges.total');
    }

    /** @test */
    public function it_returns_the_number_of_beginner_bages()
    {
        $this->mockClient();

        $this->assertStatistics(9, 'badges.beginner');
    }

    /** @test */
    public function it_returns_the_number_of_intermediate_badges()
    {
        $this->mockClient();

        $this->assertStatistics(1, 'badges.intermediate');
    }

    /** @test */
    public function it_returns_the_number_of_advanced_badges()
    {
        $this->mockClient();

        $this->assertStatistics(0, 'badges.advanced');
    }

    /**
     * Put a Mockery instance of GuzzleHttp Client
     * into the service container
     *
     * @return void
     */
    private function mockClient(): void
    {
        app()->instance(Client::class, $this->mockedClient);
    }

    /**
     * Collect data for a Laracasts User
     *
     * @param string $username
     * @return array
     */
    private function getStatisticsFor(string $username): array
    {
        return resolve(LaracastsScraper::class)
            ->getDataFor($username)
            ->statistics();
    }

    /**
     * Wrapper around assertEquals
     * Allowing for nested array values
     *
     * @param int $expectedValue
     * @param string $keys
     */
    private function assertStatistics(int $expectedValue, string $keys)
    {
        $result = $this->collectNestedKeys($keys)
            ->reduce(function ($data, $key) {
                return $data[$key];
            }, $this->getStatisticsFor('test-user'));

        $this->assertEquals($expectedValue, $result);
    }

    /**
     * Collect nested array keys, separated by a '.'
     * Example: 'nested.keys' will yield ['nested', 'keys']
     * Which will be returned as a collection
     *
     * @param string $keys
     * @return Collection
     */
    private function collectNestedKeys(string $keys): Collection
    {
        return collect(explode('.', $keys));
    }
}
