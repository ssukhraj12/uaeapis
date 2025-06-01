<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

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
        dd($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Admin Blog Added Successfully',
        ]);
    }

    public function adminBlogUpdate(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Admin Blog Updated Successfully',
        ]);
    }

    public function adminBlogDelete(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Admin Blog Deleted Successfully',
        ]);
    }
}
