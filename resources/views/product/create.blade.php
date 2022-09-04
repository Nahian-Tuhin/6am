@extends('layout')

@section('title', 'Add New Product')

@section('content')
<section class="p-3" style="min-height:calc(100vh - 112px)">
    <div class="message"></div>

      <div class="row">
        <div class="col-md-12">
            <div class="container">
            <h1>Simple Product Page!</h1>

            <input type="hidden" class="product_store" value="{{ route('product.store') }}" >
            <input type="hidden" class="product_view" value="{{ route('product.index') }}" >
            <form method="post" id="product_new" >
                @csrf
                @method('post')
                <img class="card-img-top img-fluid rounded mx-auto  w-25 "
                id="tenant_photo_viewer">
                <hr>
                <div class="input-group mb-3">
                    <div class="custom-file">
                      <input type="file" name="image"  onchange="readURL(this);"  accept="image/x-png, image/jpeg, image/jpg, image/gif "
                       class="custom-file-input" id="inputGroupFile02">
                      <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                    </div>
                  </div>

                <div class="form-group">
                  <label for="title">Product Name</label>
                  <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"  placeholder="Enter title" >
                </div>
                <div class="form-group">
                  <label for="slug">Product Slug</label>
                  <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}"  >
                </div>


                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="num" value="{{ old('price') }}"
                    onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                    name="price" class="form-control" required
                    id="price" placeholder="">
                </div>
                <div class="form-group">
                    <label >Product Text</label>
                  <textarea  class="form-control" name="text" >{{ old('text') }}</textarea>
          </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        </div>
</div>
</section>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#product_new').validate({
                rules: {
                    title: {required: true},
                    slug: {required: true},
                    price: {required: true},
                    text: {required: true},
                    // image: {required:true},
                },
                messages: {
                    title: {required: "Please Enter Product Name"},
                    slug: {required: "Please Enter slug"},
                    price: {required: "Please Enter price"},
                    text: {required: "Please Enter info"},
                    // image: {required: "Please Upload an Image"},
                },
                submitHandler: function (form) {
                    var url = $('.product_store').val();
                    var url_2 = $('.product_view').val();
                    var formdata = new FormData(form);
                    $.ajax({
                        url: url,
                        url_2: url_2,
                        type: 'POST',
                        async: true,
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function (dataResult) {
                            if (dataResult.status == 'success') {
                                messageShow("<div class='alert alert-success'>Product Saved Successfully.</div>");
                                setTimeout(function () {
                                    window.location.href = url_2;
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
        });
    </script>
@endsection

