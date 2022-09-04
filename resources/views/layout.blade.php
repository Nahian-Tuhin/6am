<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="site-url" content="{{ url('/') }}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap4.0.0.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <title>@yield('title')</title>
    <style>
        .page-link{
            color: #28A745;
        }
        .page-item.active .page-link{
            background-color: #28A745;
            border-color: #28A745;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <header class="bg-success p-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <div class="container-fluid">
                                <a class="navbar-brand" href="#">Product App</a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                        aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page"
                                               href="{{route('product.index')}}">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('product.create')}}">Create Product</a>
                                        </li>
                                        @if(auth()->user()->isAdmin())
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('user.index')}}">Manage User</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        @yield('content')

        <footer class="bg-success text-white p-2 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <span>Copyright © @php echo date('Y'); @endphp </span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/js/common.js')}}"></script>

    <script>
        $('#title').keyup(function () {
            var replaceSpace = $(this).val();
            var result = replaceSpace.replace(/ /g, "-");
            // $("#meta_title").val(replaceSpace);
            $("#slug").val(result);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#tenant_photo_viewer').attr('src', e.target.result);
                };
                $('#tenant_photo_viewer').removeClass('hidden');
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>

    @yield('script')
</body>
</html>
