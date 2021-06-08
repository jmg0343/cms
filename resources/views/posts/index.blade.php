@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="row">
            <div class="col">
                <div class="card-header">
                    Posts
                    <a href="{{ route('posts.create') }}" class="btn btn-sm btn-success float-end">Add Post</a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Image</th>
                            <th>Title</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="w-50">
                                        {{-- php artisan storage:link links public storage folder to public folder --}}
                                        {{-- allows uploaded images to be displayed --}}
                                        <img src="{{ asset($post->image) }}" class="" width="120px" alt="{{ $post->title }}">
                                    </td>
                                    <td class="w-50">
                                        {{ $post->title }}
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-info btn-sm">Edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection