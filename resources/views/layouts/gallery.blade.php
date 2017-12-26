<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            a div:hover { 
                background-color: #ddd;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Gallery
                    <br>
                </div>
                <div class="container">
                <center><a href="/gallery/uploadfile"><button class="btn btn-primary" ><h5>Upload image</h5></button></a></center>
                    <div class="row">
                    @if(empty ( $images ))
                        <center>
                            <h2> No images in gallery </h2>
                        </center>
                    @endif
                    @foreach ($images as $img)
                    <a href="showimage/{{ $img->id }}">
                        <div class="col-md-3" style="padding-top:40px;">
                            {{ $img->real_name }} <br>
                            {{ $img->thumbnail_name }} <br>
                            <img src="{{asset('thumbnail_images/size_3/'.$img->thumbnail_name) }}" style="width: 100%;padding:50px;">
                        </div>
                    </a>
                    @endforeach 
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>
