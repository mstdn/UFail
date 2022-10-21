<?php

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('max')->nullable();
            $table->text('caption')->nullable();
            $table->timestamps();
        });

        $data =  array(
            [
                'name' =>  'Funny',
                'slug' =>  'funny',
                'icon' =>  'fa-solid fa-face-laugh',
            ],
            [
                'name' => 'Latest News',
                'slug' =>  'latest-news',
                'icon' =>  'fa-solid fa-newspaper',
            ],
            [
                'name'  => 'WTF',
                'slug'  =>  'wtf',
                'icon'  =>  'fa-solid fa-skull-crossbones',
            ],
            [
                'name'  => 'Videos',
                'slug'  =>  'videos',
                'icon'  =>  'fa-solid fa-video',
            ],
            [
                'name'  => 'Wholesome',
                'slug'  =>  'wholesome',
                'icon'  => 'fa-solid fa-face-grin-hearts',
            ],
            [
                'name' => 'Memes',
                'slug'  =>  'memes',
                'icon'  =>  'fa-solid fa-hat-wizard',
            ],
            [
                'name' => 'GIFs',
                'slug'  =>  'gifs',
                'icon'  =>  'fa-solid fa-bolt',
            ],
            [
                'name'  => 'Random',
                'slug'  =>  'random',
                'icon'  =>  'fa-solid fa-bomb',
            ],
            [
                'name'  => 'Animals',
                'slug'  =>  'anime',
                'icon'  =>  'fa-solid fa-cat',
            ],
            [
                'name'  => 'Comics',
                'slug'  =>  'comics',
                'icon'  =>  'fa-solid fa-book',
            ],
        );
        foreach ($data as $datum) {
            $category = new Category(); //The Category is the model for your migration
            $category->name = $datum['name'];
            $category->slug = $datum['slug'];
            $category->icon = $datum['icon'];
            $category->save();
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
