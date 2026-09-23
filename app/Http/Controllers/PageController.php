<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = StaticPage::active()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.show', compact('page'));
    }
}
