<?php

namespace Modules\Articles\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the article.
     * @return Renderable
     */
    public function index()
    {
        return view('articles::index');
    }

    /**
     * Show the form for creating a new article.
     * @return Renderable
     */
    public function create()
    {
        return view('articles::create');
    }

    /**
     * Store a newly created article in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified article.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('articles::show');
    }

    /**
     * Show the form for editing the specified article.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('articles::edit');
    }

    /**
     * Update the specified article in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified article from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
