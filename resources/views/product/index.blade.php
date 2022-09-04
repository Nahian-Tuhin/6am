@extends('layout')

@section('title', 'Product List')

@section('content')
    <section class="p-3" style="min-height:calc(100vh - 112px)">
        <div class="message"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title m-0 float-left">Product List</h3>

                            <a href="{{ route('product.create') }}" class="btn btn-success float-right">Add New</a>
                            <div class="float-right">
                                <form action="{{ route('product.index') }}" method="get" class="form-inline">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="min_price" name="min_price"
                                               placeholder="Min Price">
                                        <input type="text" class="form-control" id="max_price" name="max_price"
                                               placeholder="Max Price">
                                         <div class="float-right mr-2">
                                             <div class="input-group">
                                                 <select class="form-control" id="status" name="status">
                                                     <option value="">All</option>
                                                     <option value="1">Active</option>
                                                     <option value="2">Inactive</option>
                                                 </select>
                                             </div>
                                         </div>
                                         <div class="float-right mr-2">
                                             <div class="input-group">
                                                 <select class="form-control" name="order">
                                                     <option value="">Order By Title</option>
                                                     <option value="asc">ASC</option>
                                                     <option value="desc">DESC</option>
                                                 </select>
                                             </div>
                                         </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit"
                                                    id="price_filter">Filter
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="card-body">
                            @if(Session::has('status'))
                                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}</p>
                            @endif
                            <table class="table table-bordered">
                                <thead>
                                <tr>

                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Information</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $row)
                                    <tr>

                                        <td>
                                            <img
                                                height="120" width="120"
                                                src="/storage/uploads/product/{{$row->image}}"
                                                alt="{{ $row->title }} ">

                                        </td>
                                        <td>
                                            {{ Str::words($row->title), 5, ' ...'}}
                                        </td>
                                        <td> {{ Str::words($row->text), 10, ' ...'}}
                                        </td>
                                        <td>{{ $row->price }}</td>
                                        <td>
                                            @if($row->status == '1')

                                                <span class="badge badge-success"> {{ 'Active' }}</span>
                                            @else
                                                <span class="badge badge-danger"> {{ 'Deactive' }}</span>
                                            @endif
                                        </td>
                                        <td><a href="{{url('product/'.$row->id.'/edit')}}" class="btn btn-dark">Edit</a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="delete-data btn btn-danger"
                                               data-id="{{$row->id}}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $products->links('pagination::bootstrap-4'); }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')

@endsection
