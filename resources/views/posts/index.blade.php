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
                    @if ($posts->count() == 0)
                        <h3 class="text-center">No Posts At This Time</h3>
                    @else
                        <table class="table">
                            <thead>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="w-25">
                                            {{-- php artisan storage:link links public storage folder to public folder --}}
                                            {{-- allows uploaded images to be displayed --}}
                                            <img src="{{ asset($post->image) }}" class="" width="120px" alt="{{ $post->title }}">
                                        </td>
                                        <td class="w-25">
                                            {{ $post->title }}
                                        </td>
                                        {{-- Post model tells Laravel that each post only has one category --}}
                                        <td class="w-25">
                                            <a href="{{ route('categories.edit', $post->category_id) }}">{{ $post->category->name }}</a>
                                        </td>
                                        @if ($post->trashed())
                                            <td>
                                                <form action="{{ route('restore-posts', $post->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit" class="btn btn-info btn-sm">Restore</button>
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info btn-sm">Edit</a>
                                            </td>
                                        @endif
                                        <td>
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <button type="submit" class="btn btn-danger btn-sm">{{ $post->trashed() ? 'Delete' : 'Trash' }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection