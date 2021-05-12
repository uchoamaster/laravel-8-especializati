<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','DESC')->paginate(3);
        // dd($posts);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StoreUpdatePost $request)
    {
        $data = $request->all();

        if($request->file('image')->isValid()){
            $nameFile = Str::of($request->title)->slug('-'). '.' .$request->image->getClientOriginalExtension();
            $image = $request->file('image')->storeAs('posts', $nameFile);
            $data['image'] = $image;
        }

        Post::create($data);
        return redirect()
        ->route('posts.index')
        ->with('message','Post criado com sucesso!');
    }

    public function show($id)
    {
    //   $post = Post::where('id', $id)->first();
         if(!$post = Post::find($id)){
            return redirect()->route('posts.index');
         }
    //   dd($post);
         return view('admin.posts.show',compact('post'));
    }

    public function destroy($id)
    {
        if(!$post = Post::find($id))
            return redirect()->route('posts.index');
        if(Storage::exists($post->image))
            Storage::delete($post->image);
            $post->delete();
            return redirect()
            ->route('posts.index')
            ->with('message','Post deletado com sucesso!');
   }

   public function edit($id)
   {
        if(!$post = Post::find($id)){
            return redirect()->back();
         }

         return view('admin.posts.edit',compact('post'));
   }

   public function update(StoreUpdatePost $request, $id)
   {
    if(!$post = Post::find($id)){
        return redirect()->back();
     }

     $data = $request->all();
     if($request->file('image') && $request->file('image')->isValid()){
        if(Storage::exists($post->image))
            Storage::delete($post->image);

        $nameFile = Str::of($request->title)->slug('-'). '.' .$request->image->getClientOriginalExtension();
        $image = $request->file('image')->storeAs('posts', $nameFile);
        $data['image'] = $image;
    }

     $post->update($data);
     return redirect()
            ->route('posts.index')
            ->with('message','Post atualizado com sucesso!');
   }

   public function search(Request $request)
   {
       $filters = $request->except('_token');
       //so pra testar e ver se está chegando até este ponto aqui
    // dd("Pesquisando por {$request->search}");
    $posts = Post::where('title','LIKE', "%{$request->search}%")
                ->orWhere('content', 'LIKE', "%{$request->search}%")
                ->paginate(3);//como estamos usando paginação encerramos com paginate, se nao tivessemos com paginação seria get();

    return view('admin.posts.index', compact('posts','filters'));
   }

}

