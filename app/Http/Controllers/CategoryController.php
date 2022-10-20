<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Categories/Index', [
            'categories'    =>  CategoryResource::collection(
                Category::with('posts')
                    ->latest()
                    ->paginate()
            ),
            'filters' => $request->only(['search'])
        ]);
    }

    public function show(Category $category)
    {
        return Inertia::render('Feed/Index', [
            'posts'  =>  PostResource::collection(
                Post::with('user')
                ->withCount(['voters', 'upvoters', 'downvoters'])
                ->where('category_id', $category->id)
                ->latest()
                ->paginate()
            )
        ]);
    }
}
