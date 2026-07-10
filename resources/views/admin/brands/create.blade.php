@extends('layouts.admin')

@section('title','Create Category')

@section('content')

<div class="max-w-3xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Create Brand
    </h1>

    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-xl shadow border p-6 space-y-5">

        @csrf

        @include('admin.brands.form')

    </form>

</div>

@endsection