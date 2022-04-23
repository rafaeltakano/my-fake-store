<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'category' => request('category'),
        ]);
    }
}
