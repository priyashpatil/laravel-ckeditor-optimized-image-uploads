@extends('layouts.admin')

@section('content')
    <div class="container py-3" style="max-width: 600px">
        <h1 class="mb-3">Edit Blog Post</h1>
        <p>Last updated: {{$blogPost->updated_at->format('d-m-Y H:i:s')}}</p>

        <form method="post">
            @method('PUT')
            @csrf

            <div class="mb-3">
                <label for="title"></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                       required value="{{old('title', $blogPost->title)}}">
                @error('title')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="body"></label>
                <textarea class="form-control @error('body') is-invalid @enderror" rows="5" id="body" name="body"
                          required>{{old('body', $blogPost->body)}}</textarea>
                @error('body')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('vendor/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript">
        ClassicEditor
            .create(document.querySelector('#body'), {
                simpleUpload: {
                    uploadUrl: '/editor-uploads',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
