<?php

namespace App\Providers;

use App\Models\Tenants\Flight;
use Illuminate\Support\Facades\Route;
use App\Services\Tenants\EventService;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $eventService;


    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        parent::__construct($app);

        $this->eventService = new EventService();
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        /*
         * When there is a callsign in a route it is always in relation to an event, therefore when a callsign is
         * in a route make sure that it is for the correct event.
         */
        Route::bind('callsign', function ($value) {
            $slug = Route::current()->parameter('slug');
            $eventId = $this->eventService->getBySlug($slug)->id;
            return Flight::where([
                    ['callsign', $value],
                    ['event_id', $eventId],
                ])->first() ?? abort(404);
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->domain(config('app.url_base'))
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
