<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    // Display the settings page
    public function index()
    {
        return view('admin.settings.index'); // Make sure this view exists
    }
}
