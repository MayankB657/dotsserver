<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .email-container {
            background: url('{{ url('/') }}/public/images/bg-image.svg');
            background-size: cover;
            background-position: center;
            max-width: 700px;
            color: #282828;
            font-family: Helvetica, sans-serif;
        }

        .csmt-yellow-color {
            color: #fdcf01;
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
            color: #00adef;
        }

        @media screen and (max-width: 400px) {
            .email-content-wrap {
                padding: 2px;
            }
        }
    </style>
</head>

<body>
    <div class="container mx-auto px-4 py-8 email-container">
        <div class="text-center font-medium text-3xl mb-4 email-header">
            <img src="{{ url('/') }}/public/images/dots-logo.png" alt="logo" />
            Hi {{ $user->name }},
            <br />
        </div>
        <div class="prose email-content-wrap px-20">
            
            <div>
                <h2>{{$auth}}</h2> 
                <p>Tagged You In a Comment</p> 
               <p>Comment is</p><p>{{$cmt}}</p>

                <p>
                    <i class="font-bold">Support:</i> If you have any questions or need
                    assistance, please visit our
                    <span class="cstm-text-teal cursor-pointer"><a
                            href="mailto:dots@support.in">dots@support.in</a></span>
                </p>
                <hr class="my-4" />
            </div>
            <p class="font-bold text-sm my-2">
                We are committed to providing you with the best experience possible.
            </p>
            <p class="font-bold text-sm">
                Should you have any questions, <br />feel free to reach out to our
                support team at
                <span class="cstm-text-teal cursor-pointer"><a href="mailto:dots@support.in">dots@support.in</a></span>
                or call us at 1800-02-2222
            </p>
            <p class="my-2 flex items-center gap-2 sm:text-left">
                <i class="font-bold text-sm">Thank you for choosing</i><img
                    src="{{ url('/') }}/public/images/dot2.svg" alt="lgo" /><i class="font-bold text-sm">We
                    look forward to working with you!</i>
            </p>
        </div>
    </div>
</body>

</html>

