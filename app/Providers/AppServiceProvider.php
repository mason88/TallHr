<?php

namespace App\Providers;

use App\Filament\Resources\UserResource\Pages\EditUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();  // save any field without $fillable

        // customize user menu
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                // link user name to edit profile
                //'account' => MenuItem::make()->url(route('filament.main.pages.dashboard')),

                // user settings
                MenuItem::make()
                    ->label('Settings')
                    //->url(route('filament.main.resources.users.edit'))
                    ->url(fn (): string => EditUser::getUrl([auth()->user()->id]))
                    ->icon('heroicon-s-cog'),
            ]);
        });
    }
}
