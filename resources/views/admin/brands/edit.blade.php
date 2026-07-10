@extends('layouts.admin')

@section('title','Edit Brand')

@section('content')

<div class="max-w-3xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Edit Brand
    </h1>

    <form
        action="{{ route('admin.brands.update',$brand) }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-xl border shadow-sm p-6 space-y-5">

        @csrf
        @method('PUT')

        @include('admin.brands.form')

    </form>

</div>

@endsection