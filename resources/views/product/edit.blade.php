
@extends('layout')

@section('title', 'Edit Product')

@section('content')
<section class="p-3" style="min-height:calc(100vh - 112px)">
    <div class="message"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title m-0 float-left">Edit Product</h3>
                        <a href="{{ route('product.index') }}" class="btn btn-success float-right">All Products</a>
                    </div>
                    <div class="card-body">
                        {{-- <input type="hidden" class="product_url_update" value="{{route('product.update',$product->id)}}" >
                        <input type="hidden" class="rdt-url" value="{{route('product.index')}}" > --}}

                        <form method="post" id="product_update">
                            @csrf
                            @method('put')

                            <img class="card-img-top img-fluid rounded mx-auto  w-25 "
                                 src="{{ asset('uploads/product/'.$product->image) }}"
                                 id="tenant_photo_viewer">
                            <hr>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" name="image" onchange="readURL(this);"
                                           accept="image/x-png, image/jpeg, image/jpg, image/gif "
                                           class="custom-file-input" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02"
                                           aria-describedby="inputGroupFileAddon02">Choose file</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">Product Name</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{$product->title}}" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="slug">Product Slug</label>
                                <input type="text" class="form-control" name="slug"
                                       value="{{ old('slug') ?? $product->slug }}">
                            </div>

                            <div class="form-group ">
                                <label for="">Status</label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control">
                                        <option {{ ( $product->status == 1 ) ? 'selected' : '' }}  value="1"> Active
                                        </option>
                                        <option {{ ( $product->status == 2 ) ? 'selected' : '' }} value="2">Deactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="num" value="{{ old('price') ?? $product->price }}"
                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                       name="price" class="form-control" required
                                       id="price" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Product Text</label>
                                <textarea class="form-control"
                                          name="text">{{ old('text') ?? $product->text }}</textarea>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <input type="submit" class="btn btn-success" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>

        $('#product_update').validate({
            rules: {
                title: {required: true},
                slug: {required: true},
                price: {required: true},
                text: {required: true},
            },
            messages: {
                title: {required: "Please Enter Product Name"},
                slug: {required: "Please Enter slug"},
                price: {required: "Please Enter price"},
                text: {required: "Please Enter info"},
            },
            submitHandler: function (form) {
                var formdata = new FormData(form);
                $.ajax({
                    url: '/product/{{$product->id}}',
                    type: 'POST',
                    data: formdata,
                    async: true,
                    processData: false,
                    contentType: false,
                    success: (dataResult) => {
                        if (dataResult.status == 'success') {
                            messageShow("<div class='alert alert-success'>"+dataResult.message+"</div>");
                            setTimeout(function () {
                                window.location.href = '/product';
                            }, 1000);

                        }
                    },
                    error: function (data) {
                        if (data.status == 422) {
                            $.each(data.responseJSON.errors, function (i, error) {
                                var el = $(document).find('[name="' + i + '"]');
                                el.after($('<span class="error">' + error[0] + '</span>'));
                            });
                        }
                    }
                });
            }
        });
    </script>
@endsection
