@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="row">
            <div class="col">
                <div class="card-header">
                    Categories
                    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-success float-end">Add Category</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($categories->count() == 0)
                <h3 class="text-center">No Categories At This Time</h3>
            @else
                <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Post Count</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="w-50">
                                    {{ $category->name }}
                                </td>
                                {{-- Laravel knows from Category model that categories have many posts --}}
                                <td class="w-25">
                                    {{ $category->posts->count() }}
                                </td>
                                <td>
                                    <div class="float-end">
                                        {{-- pass category id to satisfy dynamic uri requirement --}}
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">
                                            Edit
                                        </a>
                                        {{-- clicking initiates handleDelete method --}}
                                        <button class="btn btn-sm btn-danger" onclick="handleDelete({{ $category->id }})">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <form action="" method="post" id="deleteCategoryForm">
                @csrf
                {{-- specifies to Laravel what type of Post request (delete) --}}
                @method('DELETE')
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center text-bold">
                                    Are you sure you wish to delete this category?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // id of clicked item is passed into function
        function handleDelete(id) {
            // html form is instatiated as form variable
            var form = document.getElementById('deleteCategoryForm')
            // dynamically set form action to correct route
            form.action = '/categories/' + id

            $('#deleteModal').modal('show');
        }
    </script>
@endsection