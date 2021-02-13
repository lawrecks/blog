<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Ip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * @var Blog
     */
    private $blog;

    public function __construct( Blog $blog )
    {
        $this->blog = $blog;
    }

    public function index () {
        $ip = \request()->ip();
        $blogs = \App\Models\Blog::orderBy('created_at', 'desc')->get();
        foreach ($blogs as &$blog) {
            if (is_null($blog->image_url)) {
                $blog->image_url = 'assets/img/no_image.png';
            }
//            $blog->description = substr($blog->description, 0, 2);
        }

        $client = Ip::where('address', $ip)->first();
        if (is_null($client)) {
            Ip::create([
                'address' => $ip
            ]);
        }

        $unique_users = Ip::all()->count();

        return view('landing', compact('blogs', 'unique_users'));
    }

    public function create (Request $request) {
        $data = $request->except('_token');

        $rules = [
            'title' => 'required',
            'description' => 'required',
            'body' => 'required',
        ];

        $valid = Validator::make($data, $rules);

        if ($valid->fails()) {
            return back()
                ->withInput()
                ->withErrors($valid);
        }

        $found = $this->blog->where('title', $data['title'])->first();
        if (!is_null($found)) {
            return back()->with('error', 'Blog with the same title already exists')->withInput();
        }

        if ($request->hasFile('image')) {
            // Validate image
            $validated = $request->validate([
                'image' => 'required|mimes:jpeg,png|max:1024|dimensions:ratio=1/1'
            ]);

            $validated['name'] = md5(\Str::random(16). time());
            $extension = $request->image->extension();

            $image_url = $request->image->storeAs('/blog-images', $validated['name'].".".$extension, ['disk' => 'public']);
            $data['image_url'] = $image_url;
            unset($data['image']);
        }

        $new_blog = auth()->user()->blogs()->create($data);
        if (!$new_blog) {
            return back()->with('error', 'Error creating blog');
        }

        return back()->with('success', 'Blog created successfully!');
    }

    public function view ($id) {
        $blog = $this->blog->find($id);
        $blog->view_count++;
        $blog->save();

        if (is_null($blog->image_url)) {
            $blog->image_url = 'assets/img/no_image.png';
        }

        return view('view_blog', compact('blog'));
    }
}
