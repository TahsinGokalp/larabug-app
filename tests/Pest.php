<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use function Pest\Laravel\seed;
use Tests\CreatesApplication;

uses(
    TestCase::class,
    CreatesApplication::class,
    LazilyRefreshDatabase::class,
    WithFaker::class
)
    ->beforeEach(fn () => seed(DatabaseSeeder::class))
    ->in(__DIR__);
