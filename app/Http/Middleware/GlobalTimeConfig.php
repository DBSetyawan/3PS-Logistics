<?php

    namespace warehouse\Http\Middleware;

    use Closure;

    class GlobalTimeConfig
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            $time_settings = [
                'company_timezone' => 'UTC',
                'company_date_format' => 'Y-m-d H:i:s',
                'display_time' => true,
            ];

            view()->share('time_settings', $time_settings);

            return $next($request);
        }
    }