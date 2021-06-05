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
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                {{ $category->name }}
                            </td>
                            <td>
                                {{-- pass category id to satisfy dynamic uri requirement --}}
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">
                                    Edit
                                </a>
                                {{-- clicking initiates handleDelete method --}}
                                <button class="btn btn-sm btn-danger" onclick="handleDelete({{ $category->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      ...Test
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
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