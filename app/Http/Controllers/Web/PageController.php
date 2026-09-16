<?php

namespace App\Http\Controllers\Web;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function services()
    {
        return view('services');
    }

    public function specialties()
    {
        return view('specialties');
    }

    public function companies()
    {
        return view('companies');
    }

    public function plans()
    {
        return view('plans');
    }
}
