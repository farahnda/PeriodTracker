<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index():view
    {
        $histories = History::latest()->get();
        return view('histories.index', compact('histories'));
    }
}