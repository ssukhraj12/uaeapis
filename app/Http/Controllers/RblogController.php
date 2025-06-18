<?php

namespace App\Http\Controllers;

use App\Models\Rblog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class RblogController extends Controller
{
    public function adminrBlogs()
    {
        $rblogs = Rblog::all();
        return response()->json([
            'status' => true,
            'message' => 'Admin Blogs List',
            'rblogs' => $rblogs
        ]);
    }

    public function adminrBlogAdd(Request $request)
    {
        $validated = $request->validate([
            'blog_title' => 'required|string',
            'blog_description' => 'required|string',
            'blog_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif',
            'tags' => 'array|nullable',
            'tags.*' => 'string', // each tag must be string
            'blog_status' => 'required|in:active,inactive',
            'meta_title' => 'string|nullable',
            'meta_desc' => 'string|nullable',
        ]);

        $rblog = new Rblog();
        $rblog->blog_title = $validated['blog_title'];
        $rblog->blog_description = $validated['blog_description'];
        $rblog->blog_slug = Str::slug(strtolower($validated['blog_title']),'-');
        if ($request->hasFile('blog_image')) {
            $image = $request->file('blog_image');
            $filename = "blog_image_".uniqid().'.png';
            $destinationPath = public_path('images/blog_image');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $img = Image::make($image->getRealPath())->resize(1200, 650, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);
            $rblog->blog_image = "images/blog_image/".$filename;
        }
        $rblog->tags = $validated['tags'] ?? [];
        $rblog->blog_status = $validated['blog_status'];
        $rblog->meta_title = $validated['meta_title'] ?? $validated['blog_title'];
        $rblog->meta_desc = $validated['meta_desc'] ?? $validated['blog_title'];
        $rblog->save();

        return response()->json([
            'status' => true,
            'message' => 'Blog Added Successfully',
            'rblog' => $rblog
        ]);
    }

    public function adminrBlogtoUpdate($rblog_id)
    {
        $rblog = Rblog::Where('rblog_id','=', $rblog_id)->first();
        if ($rblog) {
            return response()->json([
                'status' => true,
                'message' => 'Blog to update',
                'rblog_id' => $rblog_id,
                'rblog' => $rblog,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
                'rblog_id' => $rblog_id,
                'rblog' => null,
            ]);
        }

    }

    public function adminrBlogUpdate(Request $request,$rblog_id)
    {
        $rblog = Rblog::Where('rblog_id','=', $rblog_id)->first();
        if ($rblog) {
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
                $filename = "blog_image_".$rblog_id.uniqid().'.png';

                $destinationPath = public_path('images/blog_image');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
                $img = Image::make($image->getRealPath())->resize(1200, 650, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$filename);
                $rblog->blog_image = "images/blog_image/".$filename;
            }

            $rblog->blog_title = $validated['blog_title'];
            $rblog->blog_slug = Str::slug(strtolower($validated['blog_title']),'-');
            $rblog->blog_description = $validated['blog_description'];
            $rblog->tags = $validated['tags'] ?? [];
            $rblog->blog_status = $validated['blog_status'];
            $rblog->meta_title = $validated['meta_title'] ?? $validated['blog_title'];
            $rblog->meta_desc = $validated['meta_desc'] ?? $validated['blog_title'];
            $rblog->save();

            return response()->json([
                'status' => true,
                'message' => 'Blog Updated Successfully',
                'rblog' => $rblog,
                'rblog_id' => $rblog->rblog_id,
            ]);
        }

    }

    public function adminrBlogDelete(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Admin Blog Deleted Successfully',
        ]);
    }
}
