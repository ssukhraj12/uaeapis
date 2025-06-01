<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function adminBlogs()
    {
        $blogs = Blog::all();
        return response()->json([
            'status' => true,
            'message' => 'Admin Blogs List',
            'blogs' => $blogs
        ]);
    }

    public function adminBlogAdd(Request $request)
    {
        $validated = $request->validate([
            'blog_title' => 'required|string',
            'blog_description' => 'required|string',
            'blog_image' => 'required|image|mimes:jpg,jpeg,png,webp,gif',
            'tags' => 'array|nullable',
            'tags.*' => 'string', // each tag must be string
            'blog_status' => 'required|in:active,inactive',
            'meta_title' => 'string|nullable',
            'meta_desc' => 'string|nullable',
        ]);

        $blog = new Blog();
        $blog->blog_title = $validated['blog_title'];
        $blog->blog_description = $validated['blog_description'];
        $blog->blog_slug = Str::slug(strtolower($validated['blog_title']),'-');
        $blog->tags = $validated['tags'] ?? [];
        $blog->blog_status = $validated['blog_status'];
        $blog->meta_title = $validated['meta_title'] ?? $validated['blog_title'];
        $blog->meta_desc = $validated['meta_desc'] ?? $validated['blog_title'];
        $blog->save();

        return response()->json([
            'status' => true,
            'message' => 'Admin Blog Added Successfully',
            'blog' => $blog
        ]);
    }

    public function adminBlogtoUpdate($blog_id)
    {
       $blog = Blog::Where('blog_id','=', $blog_id)->first();
       if ($blog) {
           return response()->json([
               'status' => true,
               'message' => 'Blog to update',
               'blog_id' => $blog_id,
               'blog' => $blog,
           ]);
       } else {
           return response()->json([
               'status' => false,
               'message' => 'Blog not found',
               'blog_id' => $blog_id,
               'blog' => null,
           ]);
       }

    }

    public function adminBlogUpdate(Request $request,$blog_id)
    {
        $blog = Blog::Where('blog_id','=', $blog_id)->first();
        if ($blog) {
            $validated = $request->validate([
                'blog_title' => 'required|string',
                'blog_description' => 'required|string',
                'blog_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif',
                'tags' => 'array|nullable',
                'tags.*' => 'string',
                'blog_status' => 'required|in:active,inactive',
                'meta_title' => 'string|nullable',
                'meta_desc' => 'string|nullable',
            ]);
            if ($request->hasFile('blog_image')) {
                $image = $request->file('blog_image');
                $filename = "blog_image_".$blog_id.uniqid().'.png';

                $destinationPath = public_path('images/blog_image');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
                $img = Image::make($image->getRealPath())->resize(1200, 650, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$filename);
                $blog->blog_image = "images/blog_image/".$filename;
            }

            $blog->blog_title = $validated['blog_title'];
            $blog->blog_slug = Str::slug(strtolower($validated['blog_title']),'-');
            $blog->blog_description = $validated['blog_description'];
            $blog->tags = $validated['tags'] ?? [];
            $blog->blog_status = $validated['blog_status'];
            $blog->meta_title = $validated['meta_title'] ?? $validated['blog_title'];
            $blog->meta_desc = $validated['meta_desc'] ?? $validated['blog_title'];
            $blog->save();

            return response()->json([
                'status' => true,
                'message' => 'Blog Updated Successfully',
                'blog' => $blog,
                'blog_id' => $blog->blog_id,
            ]);
        }

    }

    public function adminBlogDelete(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Admin Blog Deleted Successfully',
        ]);
    }
}
