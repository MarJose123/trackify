<?php

namespace App\Providers;

use App\Enums\DefaultWindowSize;
use App\Enums\WindowName;
use Native\Laravel\Contracts\ProvidesPhpIni;
use Native\Laravel\Facades\Menu;
use Native\Laravel\Facades\Window;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {

        Window::open()
            ->id(WindowName::MAIN->getId())
            ->hideMenu()
            ->position(100, 100)
            ->minHeight(DefaultWindowSize::HEIGHT->getSize())
            ->minWidth(DefaultWindowSize::WIDTH->getSize())
            ->rememberState();
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }
}
