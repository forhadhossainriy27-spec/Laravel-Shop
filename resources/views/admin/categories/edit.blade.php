@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

<div class="max-w-3xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Edit Category
    </h1>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-xl border shadow-sm p-6 space-y-5">

        @csrf
        @method('PUT')

        @include('admin.categories.form')

    </form>

</div>

@endsection