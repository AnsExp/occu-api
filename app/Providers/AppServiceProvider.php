<?php

namespace App\Providers;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->configureDefaults();
        Gate::before(fn($user, $ability) => $user->hasRole('administrator') ? true : null);
        Gate::define('viewApiDoc', fn(User $user) => true);

        DB::listen(function ($query) {
            $sql = strtolower($query->sql);
            // if (str_starts_with($sql, 'select')) {
            //     return;
            // }
            $fullSql = vsprintf(
                str_replace(['%', '?'], ['%%', "'%s'"], $query->sql),
                $query->bindings
            );
            file_put_contents(
                storage_path('db_backups/' . date('Y-m-d') . '.sql'),
                $fullSql . ";\n",
                FILE_APPEND
            );
            // if (str_starts_with($sql, 'insert') || str_starts_with($sql, 'update') || str_starts_with($sql, 'delete')) {
            // }
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(
            fn(): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
