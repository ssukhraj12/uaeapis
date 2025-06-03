<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Gallery;
use Illuminate\Http\Request;

class FrontController extends Controller
{
   public function allBlogs()
   {
       $blogs = Blog::get();
       return response()->json([
           'success' => true,
           'message' => 'All Blogs',
           'blogs' => $blogs
       ],200);
   }

   public function allGallery(){
       $galleries = Gallery::get();
       return response()->json([
           'success' => true,
           'message' => 'All Gallery',
           'galleries' => $galleries
       ]);
   }
}
