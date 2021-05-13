@extends('admin.layouts.app')
@section('title','Editar Post')
@section('content')

<div class="grid">
<a href="{{ route('posts.index') }}" class="my-4 uppercase px-8 py-2 rounded bg-green-600 text-blue-50 max-w-max shadow-sm hover:shadow-lg">Página Inicial</a>
</div>
<hr>

<h1 class="text-center text-3xl uppercase font-black my-4">Editar o Post: <strong>{{ $post->title}}</strong></h1>
<div class="w-11/12 p-12 bg-white sm:w-8/12 md:w-1/2 lg:w-5/12 mx-auto">
    <form action="{{ route('posts.update', $post->id)}}" method="post" enctype="multipart/form-data">

        @method('put')
        @include('admin.posts._partials.form')
</form>
</div>

@endsection

