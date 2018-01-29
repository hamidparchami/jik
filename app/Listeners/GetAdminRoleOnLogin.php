<?php

namespace App\Listeners;

use App\Role;
use Illuminate\Auth\Events\Login;

class GetAdminRoleOnLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //set allowed urls by user role in session
        $allowed_URLs = [];
        if (!is_null($event->user->role_id)) {
            $role = Role::find($event->user->role_id);
            if ($role !== null) {
                $allowed_URLs = array_column($role->urls->toArray(), 'url');
            }
        }

        session(['allowed_URLs' => $allowed_URLs]);
    }
}
