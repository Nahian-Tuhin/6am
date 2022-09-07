    @extends('layout')

@section('title', 'Add New User')

@section('content')
<section class="p-3" style="min-height:calc(100vh - 112px)">
    <div class="message"></div>

      <div class="row">
        <div class="col-md-12">
            <div class="container">
            <h1>Simple Register Form!</h1>

            <input type="hidden" class="url" value="{{ route('register') }}" >
            <input type="hidden" class="url_2" value="{{ route('login') }}" >
            <form method="POST" id="reg_new">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Enter email" >
                </div>
                <div class="form-group">
                  <label for="username">User Name</label>
                  <input type="text" class="form-control" id="username" name="name" value="{{ old('name') }}"  placeholder="Enter username" >
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="tel" value="{{ old('phone') }}"
                    onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                    name="phone" class="form-control" required
                    id="phone" placeholder="01800000001">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
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
        $('#reg_new').validate({
            rules: {
                name: {required: true},
                email: {required: true},
                phone: {required: true},
                password: {required: true},
            },
            messages: {
                name: {required: "Please Enter Name"},
                email: {required: "Please Enter Valid Email"},
                phone: {required: "Please Enter Valid Phone"},
                password: {required: "Please Enter Password"},
            },
            submitHandler: function (form) {
                var url = $('.url').val();
                var url_2 = $('.url_2').val();
                var formdata = new FormData(form);
                $.ajax({
                    url: url,
                    url_2: url_2,
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (dataResult) {
                        if (dataResult == '1') {
                            messageShow("<div class='alert alert-success'>Saved Successfully.</div>");
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
    </script>
@endsection
