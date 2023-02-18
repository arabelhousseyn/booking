<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{trans('email.mail_password_reset_title')}}</title>
    <style>
        .mainDiv {
            display: flex;
            min-height: 100%;
            align-items: center;
            justify-content: center;
            background-color: #f9f9f9;
            font-family: 'Open Sans', sans-serif;
        }

        .cardStyle {
            width: 500px;
            border-color: white;
            background: #fff;
            padding: 36px 0;
            border-radius: 4px;
            margin: 30px 0;
            box-shadow: 0px 0 2px 0 rgba(0, 0, 0, 0.25);
        }

        #signupLogo {
            max-height: 100px;
            margin: auto;
            display: flex;
            flex-direction: column;
        }

        .formTitle {
            font-weight: 600;
            margin-top: 20px;
            color: #2F2D3B;
            text-align: center;
        }

        .inputLabel {
            font-size: 12px;
            color: #555;
            margin-bottom: 6px;
            margin-top: 24px;
        }

        .inputDiv {
            width: 70%;
            display: flex;
            flex-direction: column;
            margin: auto;
        }

        input {
            height: 40px;
            font-size: 16px;
            border-radius: 4px;
            border: none;
            border: solid 1px #ccc;
            padding: 0 11px;
        }

        input:disabled {
            cursor: not-allowed;
            border: solid 1px #eee;
        }

        .buttonWrapper {
            margin-top: 40px;
        }

        .submitButton {
            width: 70%;
            height: 40px;
            margin: auto;
            display: block;
            color: #fff;
            background-color: #065492;
            border-color: #065492;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.12);
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.035);
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .submitButton:disabled,
        button[disabled] {
            border: 1px solid #cccccc;
            background-color: #cccccc;
            color: #666666;
        }

        #loader {
            position: absolute;
            z-index: 1;
            margin: -2px 0 0 10px;
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #666666;
            width: 14px;
            height: 14px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
@if(session()->has('user_password_changed'))
    <div class="alert alert-success">{{trans('passwords.change')}}</div>
@endif
<div class="mainDiv">
    <div class="cardStyle">
        <form action="{{route('user-password-reset')}}" method="post" name="signupForm" id="signupForm">
            @csrf

            <img src="https://laravel.com/img/favicon/android-chrome-192x192.png" id="signupLogo"/>

            <input type="hidden" value="{{request()->query('email')}}" name="email">
            <input type="hidden" value="{{request()->query('token')}}" name="token">

            <div class="inputDiv">
                <label class="inputLabel" for="password">{{trans('email.password')}}</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="inputDiv">
                <label class="inputLabel" for="confirmPassword">{{trans('email.new_password')}}</label>
                <input type="password" id="confirmPassword" name="password_confirmation">
            </div>

            <div class="buttonWrapper">
                <button type="submit" id="submitButton" onclick="refresh()"
                        class="submitButton pure-button pure-button-primary">
                    <span>{{trans('email.change')}}</span>
                </button>
            </div>

        </form>
        {{ session()->remove('user_password_changed') }}
    </div>
</div>
<script>
    function refresh() {
        setTimeout(() => {
            window.location.reload()
        }, 3000)
    }
</script>
</body>
</html>
