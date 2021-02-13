<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var Blog
     */
    private $blog;

    /**
     * Create a new controller instance.
     *
     * @param Blog $blog
     */
    public function __construct( Blog $blog )
    {
        $this->middleware('auth');
        $this->blog = $blog;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $blogs = auth()->user()->blogs()->orderBy('created_at', 'desc')->get();

        foreach ($blogs as &$blog) {
            if (is_null($blog->image_url)) {
                $blog->image_url = 'assets/img/no_image.png';
            }
        }
        return view('home', compact('blogs'));
    }
}
