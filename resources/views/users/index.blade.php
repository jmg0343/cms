@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="row">
            <div class="col">
                <div class="card-header">
                    Users
                </div>

                <div class="card-body">
                    @if ($users->count() == 0)
                        <h3 class="text-center">No Users At This Time</h3>
                    @else
                        <table class="table">
                            <thead>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="w-25">
                                            <img width="40px" height="40px" style="border-radius: 50%;" src="{{ Gravatar::src($user->email) }}" alt="">
                                        </td>
                                        <td class="w-25">
                                            {{ $user->name }}
                                        </td>
                                        <td class="w-25">
                                            {{ $user->email }}
                                        </td>

                                        <td>
                                            @if (!$user->isAdmin())
                                                <form action="{{ route('users.make-admin', $user->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Make Admin</button>
                                                </form>
                                            @endif
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