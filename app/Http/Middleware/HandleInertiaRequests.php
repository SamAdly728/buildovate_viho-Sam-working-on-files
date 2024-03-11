<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Session;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $loginData = (object)[
            'email'=>Session::get('email'),
            'name'=>Session::get('name'),
            'role_name'=>Session::get('role_name'),
            'user_id'=>Session::get('user_id'),
            'display_name'=>Session::get('user_display_name'),
        ];

        $companyData = (object)[
            'logo' => Session::get('logo')
        ];

        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'auth.user' =>  fn () => $loginData,
            'company' => $companyData,
            'support' => [
                'email' => env('APP_SUPPORT'),
                'phone' => env('APP_SUPPORT_PHONE'),
            ],
            'csrf_token' => csrf_token(),
            'style' =>[
                'sidebar' => true,
                'sidebar_opacity' => 'opacity:1',
                'page_body'=> 'margin-left:290px',
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
        ]);
    }
}
