<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/login/css/bootsrap.min.css">





    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/login/css/animate.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/login/css/hamburgers.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/login/css/animsition.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/login/css/select2.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/login/css/daterangepicker.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/login/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;500;600;700;900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .login100-form-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        .login100-form-btn {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .login100-form {
            width: 560px;
            min-height: 100vh;
            display: block;
            background-color: #F8F8F8;
            padding: 173px 55px 55px;
        }
    </style>


    <meta name="robots" content="noindex, follow">
    <script nonce="80f0ffa4-0239-40e0-9967-363677b3eb7e">
        (function(w,d){!function(a,e,t,r){a.zarazData=a.zarazData||{};a.zarazData.executed=[];a.zaraz={deferred:[]};a.zaraz.q=[];a.zaraz._f=function(e){return function(){var t=Array.prototype.slice.call(arguments);a.zaraz.q.push({m:e,a:t})}};for(const e of["track","set","ecommerce","debug"])a.zaraz[e]=a.zaraz._f(e);a.zaraz.init=()=>{var t=e.getElementsByTagName(r)[0],z=e.createElement(r),n=e.getElementsByTagName("title")[0];n&&(a.zarazData.t=e.getElementsByTagName("title")[0].text);a.zarazData.x=Math.random();a.zarazData.w=a.screen.width;a.zarazData.h=a.screen.height;a.zarazData.j=a.innerHeight;a.zarazData.e=a.innerWidth;a.zarazData.l=a.location.href;a.zarazData.r=e.referrer;a.zarazData.k=a.screen.colorDepth;a.zarazData.n=e.characterSet;a.zarazData.o=(new Date).getTimezoneOffset();a.zarazData.q=[];for(;a.zaraz.q.length;){const e=a.zaraz.q.shift();a.zarazData.q.push(e)}z.defer=!0;for(const e of[localStorage,sessionStorage])Object.keys(e||{}).filter((a=>a.startsWith("_zaraz_"))).forEach((t=>{try{a.zarazData["z_"+t.slice(7)]=JSON.parse(e.getItem(t))}catch{a.zarazData["z_"+t.slice(7)]=e.getItem(t)}}));z.referrerPolicy="origin";z.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(a.zarazData)));t.parentNode.insertBefore(z,t)};["complete","interactive"].includes(e.readyState)?zaraz.init():a.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,0,"script");})(window,document);
    </script>
</head>

<body style="background-color: #666666;">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('password.email') }}">

                    @csrf
                    <span class="login100-form-title p-b-43">
                        Forgot Password
                    </span>
                    <center>
                        <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
                        <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                    </center>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" name="email" type="email" name="email" :value="old('email')" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Enter Email Adress</span>
                    </div>
                    <br>
                    <div class="container-login100-form-btn mt-4">
                        <button class="login100-form-btn" style="background-color: #629779" type="submit">
                            Email Password Reset Link
                        </button>

                    </div>
                </form>
                <div class="login100-more" style="background-image: url('/assets/login/img/forgot1.JPG');">
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets') }}/login/js/jquery-3.2.1.min.js"></script>

    <script src="{{ asset('assets') }}/login/js/animsition.min.js"></script>

    <script src="{{ asset('assets') }}/login/js/popper.js"></script>
    <script src="{{ asset('assets') }}/login/js/bootstrap.min.js"></script>

    <script src="{{ asset('assets') }}/login/js/select2.min.js"></script>

    <script src="{{ asset('assets') }}/login/js/moment.min.js"></script>
    <script src="{{ asset('assets') }}/login/js/daterangepicker.js"></script>

    <script src="{{ asset('assets') }}/login/js/countdowntime.js"></script>

    <script src="{{ asset('assets') }}/login/js/main.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>

    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194"
        integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw=="
        data-cf-beacon='{"rayId":"72ae9bf648c98964","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2022.6.0","si":100}'
        crossorigin="anonymous"></script>
</body>

</html>