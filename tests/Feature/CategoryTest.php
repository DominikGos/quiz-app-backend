<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_user_can_view_category_list(): void
    {
        $response = $this->getJson(route('categories.index'));

        $response
            ->assertOk()
            ->assertJsonIsArray('categories');
    }
}
