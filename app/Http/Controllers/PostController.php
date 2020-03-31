<?php

namespace App\Http\Controllers;

use DataTables;
use App\Mail\DeletePostMail;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePostValidation;
// use SebastianBergmann\Environment\Console;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post.index');
    }

    public function dataTable()
    {

        $posts = Post::select("*", "image as image_path");

        return Datatables::of($posts)
            ->editColumn('created_at', function ($post) {
                return $post->created_at ? with(new Carbon($post->created_at))->format('m/d/Y') : '';
            })
            ->editColumn('updated_at', function ($post) {
                return $post->updated_at ? with(new Carbon($post->updated_at))->format('Y/m/d') : '';;
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
            })
            ->filterColumn('updated_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(updated_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
            })
            ->make(true);

        // return Datatables::of(Post::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostValidation $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->refrence = '123456';
        if ($imageFile = $request->file('image')) {

            $imageName = time() . '.' . $request->image->extension();
            $imagePath = $imageFile->store(config('custom.paths.postImage'));
            Storage::disk('public')->put(config('custom.paths.postImage') . $imageName, file_get_contents($imageFile));


            $post->image = $imageName;
        }


        $post->save();

        // session()->set('success','Item created successfully.');

        return redirect('/post')->with('success', 'Post is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = post::findOrFail($id);
        $imageFile = $request->file('image');
        $imageName = $post->image;

        if ($imageFile != '') {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'description' => 'required|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if (Storage::disk('public')->exists(config('custom.paths.postImage') . $post->image)) {
                Storage::disk('public')->delete(config('custom.paths.postImage') . $post->image);

            }

            $imageName = time() . '.' . $request->image->extension();
            $imagePath = $imageFile->store(config('custom.paths.postImage'));
            Storage::disk('public')->put(config('custom.paths.postImage') . $imageName, file_get_contents($imageFile));


        } else {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'description' => 'required|max:255',
            ]);
            

        }
        $form_data = array(
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName
        );
        Post::whereId($id)->update($form_data);

        return redirect('/post')->with('success', 'Post (' . $id . ') is successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Post::findOrFail($id)->delete();

        return redirect('/post')->with('success', 'Post is successfully delete');
    }

    


}
