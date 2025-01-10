<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Cache Clear!</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .email-container {
            background: url({{ asset($constants['IMAGEFILEPATH'] . 'bg-image.png') }});
            background-size: cover;
            background-position: center;
            max-width: 700px;
            color: #282828;
            font-family: Helvetica, sans-serif;
        }

        .csmt-yellow-color {
            color: #FDCF01;
        }

        .email-header {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 0.7rem;
        }

        hr {
            border-top-width: 2px;
            border-color: #1e1f20;
            width: 95%;
        }

        .cstm-text-teal {
            color: #00ADEF;
        }

        @media screen and (max-width: 400px) {
            .email-content-wrap {
                padding: 2px;
            }
        }
    </style>
</head>

<body class="bg-yellow-300">
    <div class="container mx-auto px-4 py-8 email-container ">
        <div class="text-center font-medium text-3xl mb-4 email-header">
            <img src="{{ asset($constants['IMAGEFILEPATH'] . 'dots-logo.png') }}" alt="logo">
            Hello Admin,
            <br />
        </div>
        <div class="prose email-content-wrap px-20">
            <p class="text-center  font-bold">Configuration has been clear for domain at {{ $dt }}.</p>
            <div>
                <p>
                    <i class="font-bold">Log in:</i> Visit website and log in using your username and password.
                </p>
                <p>
                    <i class="font-bold">Explore:</i> Take a tour of our features and see what we have to offer.
                </p>
                <p>
                    <i class="font-bold">Profile Setup:</i> Complete your profile to personalize your experience.
                </p>
                <p>
                    <i class="font-bold">Support:</i> If you have any questions or need assistance, please visit our
                    <span class="cstm-text-teal cursor-pointer">
                        <a href="mailto:dots@support.in">dots@support.in</a>
                    </span>
                </p>
                <hr class="my-4">
            </div>
            <p class="font-bold text-sm my-2">We are committed to providing you with the best experience possible.</p>
            <p class="font-bold text-sm">Should you have any questions, <br>feel free to reach out to our support team
                at <span class="cstm-text-teal cursor-pointer">
                    <a href="mailto:dots@support.in">dots@support.in</a>
                </span> or call us
                at <a href="tel:1800-02-2222">1800-02-2222</a>
            </p>
            <p class="my-2 flex items-center gap-2 sm:text-left">
                <i class="font-bold text-sm ">Thank you for
                    choosing</i>
                <img src="{{ asset($constants['IMAGEFILEPATH'] . 'dot2.png') }}" style="height: 30px" alt="lgo">
                <i class="font-bold text-sm ">We look forward to
                    working with you!</i>
            </p>
        </div>
    </div>
</body>

</html>
