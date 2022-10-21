<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use App\Models\Category;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [

            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },

            'appName' => config('app.name'),

            'auth.user' => fn () => $request->user()
                ? $request->user()->only('id', 'name')
                : null,

            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],

            'categories' => fn () => Category::latest()
                ->get()
                ->map(fn ($category) => [
                    'id'    =>  $category->id,
                    'name'  =>  $category->name,
                    'slug'  =>  $category->slug
                ]),

            'filters' => $request->only(['search']),

            'unreadNotificationsCount' => $request->user() ? $request->user()->unreadNotifications()->count() : null,

            'can'   =>  [
                'admin' => $request->user() ? $request->user()->id === 1 : null
            ],

        ]);
    }
}
