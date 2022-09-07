@extends('layout')

@section('title', 'Product List')

@section('content')
    <section class="p-3" style="min-height:calc(100vh - 112px)">
        <div class="message"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                    @endif
                @if(session('error'))
                <div class="alert alert-danger">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
                @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title m-0 float-left">User List</h3>

                        </div>
                        <div class="card-body">

                            <table class="table table-bordered">
                                <thead>
                                <tr>

                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $row)
                                    <tr>

                                        <td>{{ $row->email }}</td>
                                        <td>
                                            <form action="{{ route('user.role',$row->id) }}" method="post">
                                                @csrf
                                                <select name="role" id="role">
                                                    <option
                                                        {{ ( $row->role == 'admin' ) ? 'selected' : '' }}
                                                        value="admin">
                                                        Admin
                                                    </option>
                                                    <option
                                                        {{ (  $row->role == 'user' ) ? 'selected' : ''  }} value="user">
                                                        User
                                                    </option>
                                                </select>
                                                <button type="submit" class="btn btn-primary">Change</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $users->links('pagination::bootstrap-4'); }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')

@endsection
