@extends('admin.layouts.app')
@section('title','Criar novo Post')
@section('content')
<a href="{{ route('posts.index') }}">Página Inicial</a>
<hr>
<h1>Cadastrar novo Post</h1>
    <form action="{{route('posts.store') }}" method="post" enctype="multipart/form-data">
        @include('admin.posts._partials.form')
</form>



@endsection
