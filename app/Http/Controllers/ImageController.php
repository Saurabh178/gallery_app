<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Album;

class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin', ['only' => ['index', 'addImage', 'store', 'destroy', 'albumImage']]);
    }

    public function index()
    {
    	$images = Image::get();
    	return view('home', compact('images'));
    }

    public function show($id)
    {
        $albums = Album::findOrFail($id);
        return view('gallery', compact('albums'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'album' => 'required|min:3|max:50',
            'image' => 'required'
        ]);

    	$album = Album::create(['name' => $request->get('album')]);

    	if($request->hasFile('image'))
    	{
    		foreach ($request->file('image') as $image) 
    		{
    			$path = $image->store('uploads', 'public');
	    		Image::create([
	    			'name'=>$path,
	    			'album_id'=>$album->id	
	    		]);
	    	}
    	}
        return "<div class='alert alert-success'>Album Created Successfully!</div>";
    }

    public function destroy()
    {
        $id = request('id');
        $image = Image::findOrFail($id);
        $fileName = $image->name;
        $image->delete();

        \Storage::delete('public/'.$fileName);
        return redirect()->back()->with('message', 'Image Deleted Successfully!');
    }

    public function album()
    {
        $albums = Album::with('images')->get();
        return view('welcome', compact('albums'));
    }

    public function addImage(Request $request)
    {
        $this->validate($request, [
            'image' =>'required'
        ]);

        $album_id = request('id');

        if($request->hasFile('image'))
        {
            foreach ($request->file('image') as $image) 
            {
                $path = $image->store('uploads', 'public');
                Image::create([
                    'name'=>$path,
                    'album_id'=>$album_id  
                ]);
            }
        }
        return redirect()->back()->with('message', 'Image Added Successfully!');
    }

    public function albumImage(Request $request)
    {
        $this->validate($request, [
            'image' =>'required'
        ]);

        $album_id = request('id');

        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');
            Album::where('id', $album_id)->update([
                'image'=>$path,
            ]);
        }
        return redirect()->back()->with('message', 'Album Image Added Successfully!');
    }

}
