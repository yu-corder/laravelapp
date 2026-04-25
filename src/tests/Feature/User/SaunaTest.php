<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sauna;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SaunaTest extends TestCase
{
    use RefreshDatabase;
    /**
     * user index view test
     */
    public function test_index(): void
    {
        $saunas = Sauna::factory()->createMany([
            ['name' => 'テストサウナA'],
            ['name' => 'テストサウナB'],
        ]);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('test_b_image.jpg');
        $path = $file->store('sauna/1', 'public');

        $saunas[1]->images()->create([
            'file_path' => $path,
            'display_order' => 1,
        ]);

        $content = \App\Models\Content::factory()->create([
            'sauna_id' => $saunas[1]->id,
            'is_public' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(302);
        $response = $this->get('/saunas');
        $response->assertStatus(200);
        $response->assertSee('テストサウナ');
        $response->assertViewHas('saunas', function ($saunas) {
            return $saunas->count() === 2;
        });
        Storage::disk('public')->assertExists($path);
        $url = Storage::url($path);
        $response->assertSee($url, false);
        $response->assertSee(route('contents.show', $content->id));

        //don't has content
        $response->assertSee('準備中');
    }
}
