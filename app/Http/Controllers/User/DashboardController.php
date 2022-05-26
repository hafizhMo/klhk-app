<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    public function dashboard() {
        // TODO: Get User's Details

        return view('user.dashboard');
    }
}