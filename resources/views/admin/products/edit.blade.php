@extends('layouts.admin')

@section('title','Edit Product')

@section('content')

<div class="max-w-7xl mx-auto">

    <h1 class="mb-6 text-3xl font-bold">

        Edit Product

    </h1>

    <form
        action="{{ route('admin.products.update',$product) }}"
        method="POST"
        enctype="multipart/form-data"
        class="rounded-xl border bg-white p-6 shadow">

        @csrf
        @method('PUT')

        @include('admin.products.form')

    </form>

</div>

@push('scripts')
<script>
function deleteGalleryImage(id) {
    if (!confirm('Are you sure you want to delete this image?')) {
        return;
    }

    const form = document.getElementById('galleryDeleteForm');
    form.action = "{{ url('admin/products/gallery') }}/" + id;
    form.submit();
}
</script>
@endpush

<form id="galleryDeleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@endsection