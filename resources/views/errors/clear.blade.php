<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
    <style>
        .page_404 {
            padding: 40px 0;
            background: #fff;
            font-family: "Arvo", serif;
            margin: auto;
            width: 50%;
            text-align: center;
        }

        .page_404 img {
            width: 100%;
        }

        .four_zero_four_bg {
            background-image: url('public/images/ok.png');
            height: 400px;
            background-position: center;
        }

        h1 {
            font-size: 80px;
            color: #fdcf01;
        }

        .four_zero_four_bg h3 {
            font-size: 80px;
        }

        .link_404 {
            color: #fff !important;
            padding: 10px 20px;
            background: #39ac31;
            margin: 20px 0;
            display: inline-block;
        }
    </style>
</head>

<body>
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1 text-center">
                        <h1 class="text-center text-yellow">Cache Cleared</h1>
                        <div class="four_zero_four_bg"></div>
                        <div class="contant_box_404">
                            <h3 class="h2">
                                Looks great.
                            </h3>
                            <p>Your cache has been cleared, Please return to home.</p>
                            <a href="{{ route('dashboard') }}" class="link_404">Return Home</a>
                            <a href="{{ route('clear') }}" class="link_404">Clear again</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
