<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Photo;
use App\Models\Rblog;
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

    public function allrBlogs()
    {
        $rblogs = Rblog::orderBy('created_at','desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'All Blogs',
            'rblogs' => $rblogs
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

   public function allPhotos()
   {
       $photos = Photo::with('rphotos')->orderBy('created_at','desc')->get();
       return response()->json([
           'success' => true,
           'message' => 'All Photos',
           'photos' => $photos
       ]);
   }
}
