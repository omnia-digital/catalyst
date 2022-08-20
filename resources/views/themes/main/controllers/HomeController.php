<?php


namespace Themes\main\controllers;


class HomeController
{
    public function index(): \Illuminate\View\View
    {
        return view('themes.main.pages.home');
    }
}
