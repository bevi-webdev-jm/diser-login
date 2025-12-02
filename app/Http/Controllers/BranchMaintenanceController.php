<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BranchMaintenanceController extends Controller
{
    public function index() {
        return view('pages.branch-maintenance.index');
    }

    public function create() {
        return view('pages.branch-maintenance.create');
    }
}
