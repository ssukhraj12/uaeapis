<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Photo;
use App\Models\Rphoto;
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
            'blog_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif',
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
            $blog->blog_image = "images/blog_image/".$filename;
        }
        $blog->tags = $validated['tags'] ?? [];
        $blog->blog_status = $validated['blog_status'];
        $blog->meta_title = $validated['meta_title'] ?? $validated['blog_title'];
        $blog->meta_desc = $validated['meta_desc'] ?? $validated['blog_title'];
        $blog->save();

        return response()->json([
            'status' => true,
            'message' => 'Blog Added Successfully',
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

    public function adminGalleryList()
    {
        $galleries = Gallery::all();
        return response()->json([
            'status' => true,
            'message' => 'Gallery List',
            'galleries' => $galleries,
        ],200);
    }

    public function adminGalleryAdd(Request $request)
    {
        $gallery = new Gallery();
        $gallery->gallery_name = $request->gallery_name ?? "Gallery Pic";
        if ($request->hasFile('gallery_image')) {
            $image = $request->file('gallery_image');
            $filename = "gallery_image_".uniqid().'.png';
            $destinationPath = public_path('images/gallery');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $img = Image::make($image->getRealPath())->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);
            $gallery->gallery_image = "images/gallery/".$filename;
        }
        $gallery->gallery_status = $request->gallery_status;
        $gallery->save();
        if ($gallery) {
            return response()->json([
                'status' => true,
                'message' => 'Gallery Added Successfully',
                'gallery' => $gallery,
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gallery not saved',
                'gallery' => null,
            ]);
        }
    }

    public function adminGalleryUpdate(Request $request,$gallery_id)
    {
        $gallery = Gallery::find($gallery_id);
        $gallery->gallery_name = $request->gallery_name ?? "Gallery Pic";
        if ($request->hasFile('gallery_image')) {
            $image = $request->file('gallery_image');
            $filename = "gallery_image_".$gallery_id.uniqid().'.png';
            $destinationPath = public_path('images/gallery');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $img = Image::make($image->getRealPath())->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);
            $gallery->gallery_image = "images/gallery/".$filename;
        }
        $gallery->gallery_status = $request->gallery_status;
        $gallery->save();
        if ($gallery) {
            return response()->json([
                'status' => true,
                'message' => 'Gallery Updated Successfully',
                'gallery' => $gallery,
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gallery not saved',
                'gallery' => null,
            ]);
        }
    }

    public function adminGalleryDelete(Request $request,$gallery_id)
    {
        $gallery = Gallery::findOrFail($gallery_id);
        if ($gallery->gallery_image && File::exists(public_path($gallery->gallery_image))) {
            File::delete(public_path($gallery->gallery_image));
        }
        $gallery->delete();
        if ($gallery) {
            return response()->json([
                'status' => true,
                'message' => 'Admin Gallery Deleted Successfully',
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Admin Gallery not deleted',
            ]);
        }

    }

    public function adminPhotoList()
    {
        $photos = Photo::all();
        return response()->json([
            'status' => true,
            'message' => 'Photo List',
            'photos' => $photos,
        ]);
    }

    public function adminPhotoAdd(Request $request)
    {
        $photo = new Photo();
        $photo->photo_title = $request->photo_title ?? "Photo Title";
        $photo->photo_description = $request->photo_description ?? "Photo Description";
        $photo->photo_status = $request->photo_status ?? "active";
        if ($request->hasFile('photo_url')) {
            $image = $request->file('photo_url');
            $filename = "photo_".uniqid().'.png';
            $destinationPath = public_path('images/photo');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $img = Image::make($image->getRealPath())->resize(1200, 1200, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);
            $photo->photo_url = "images/photo/".$filename;
        }
        $photo->save();
        if ($photo) {
            return response()->json([
                'status' => true,
                'message' => 'Photo Added Successfully',
                'photo' => $photo,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Photo not saved',
                'photo' => null,
            ]);
        }
    }

    public function adminPhotoToUpdate($photo_id)
    {
        $photo = Photo::with('rphotos')->where('photo_id',$photo_id)->first();
        if ($photo) {
            return response()->json([
                'status' => true,
                'message' => 'Photo to Update',
                'photo_id' => $photo_id,
                'photo' => $photo,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Photo not found',
                'photo_id' => $photo_id,
                'photo' => null,
            ]);
        }
    }

    public function adminPhotoUpdate(Request $request,$photo_id)
    {
        $photo = Photo::Find($photo_id);
        $photo->photo_title = $request->photo_title ?? "Photo Title";
        $photo->photo_description = $request->photo_description ?? "Photo Description";
        $photo->photo_status = $request->photo_status ?? "active";
        if ($request->hasFile('photo_url')) {
            $image = $request->file('photo_url');
            $filename = "photo_".uniqid().'.png';
            $destinationPath = public_path('images/photo');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $img = Image::make($image->getRealPath())->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);
            $photo->photo_url = "images/photo/".$filename;
        }
        if($request->hasFile('arphotos')){
            foreach ($request->file('arphotos') as $file) {
                $filename = "arphoto_" . uniqid() . '.png';
                $destinationPath = public_path('images/arphotos');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
                $img = Image::make($file->getRealPath())->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$filename);
                $rphoto = new Rphoto();
                $rphoto->rphoto_url = "images/arphotos/".$filename;
                $rphoto->photo_id = $photo_id;
                $rphoto->save();
            }
        }
        $photo->save();

        if ($photo) {
            return response()->json([
                'status' => true,
                'message' => 'Photo Updated Successfully',
                'photo' => $photo,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Photo not saved',
                'photo' => null,
            ]);
        }
    }

    public function adminPhotoDelete(Request $request,$photo_id)
    {
        $photo = Photo::findOrFail($photo_id);
        if ($photo->photo_url && File::exists(public_path($photo->photo_url))) {
            File::delete(public_path($photo->photo_url));
        }
        $photo->delete();
        if ($photo) {
            return response()->json([
                'status' => true,
                'message' => 'Admin Photo Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Admin Photo not deleted',
            ]);
        }
    }
}
