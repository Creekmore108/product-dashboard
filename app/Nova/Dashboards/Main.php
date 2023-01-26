<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;
use App\Nova\Metrics\UserPerRole;
use App\Nova\Metrics\RegisteredUsers;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new UserPerRole(),
            new RegisteredUsers()
        ];
    }
    public function name()
    {
        return 'Dashboard';
    }
}
