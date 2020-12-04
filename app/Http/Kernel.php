<?php

namespace warehouse\Http;

use GlobalTimeConfig;
use Fideloper\Proxy\TrustProxies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    public function registerBundles()
    {
        $bundles = [
            new Sentry\SentryBundle\SentryBundle()
        ];
    }
    
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \warehouse\Http\Middleware\RoleMiddleware::class, // optional boot services providers permission security behavior apps
        // \RenatoMarinho\LaravelPageSpeed\Middleware\InlineCss::class, //collapse syntax
        // \RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace::class, // optional if application interpretations web application CLEARED
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            'Fideloper\Proxy\TrustProxies',
            \warehouse\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \warehouse\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \warehouse\Http\Middleware\GlobalTimeConfig::class,
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \warehouse\Http\Middleware\TrimStrings::class,
            \RenatoMarinho\LaravelPageSpeed\Middleware\InsertDNSPrefetch::class,
            \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveComments::class,
            \RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls::class,
            \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            \RenatoMarinho\LaravelPageSpeed\Middleware\ElideAttributes::class
    
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \warehouse\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'csrf' => \warehouse\Http\Middleware\VerifyCsrfToken::class,
        // 'throttle' => \warehouse\Http\Middleware\ThrottleRequestsMiddleware::class,
        // 'role' => \warehouse\Http\Middleware\RoleMiddleware::class, this custom Role
        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'settinguser' => \warehouse\Http\Middleware\CekSettingUser::class,
        'BlockedBeforeSettingUser' => \warehouse\Http\Middleware\BlockedBeforeSettingUser::class,
        'CekOpenedTransaction' => \warehouse\Http\Middleware\CekOpenedTransactionMiddleware::class,
        'CekInjectionRoleBranchs' => \warehouse\Http\Middleware\CheckAllRoleInjectionBranchINF::class,
        'json.response' => \warehouse\Http\Middleware\ForceJsonResponse::class,
        'cookieConsident' => \Spatie\CookieConsent\CookieConsentMiddleware::class,
        'ipcheck' => \warehouse\Http\Middleware\IpMiddleware::class
    ];

}
