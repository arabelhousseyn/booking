<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Return</title>

    <link rel="stylesheet" href="{{asset('assets/payment_elements/html/css/base.css')}}" />
    <script src="https://js.stripe.com/v3/"></script>

    <script src="{{asset('assets/payment_elements/html/utils.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            // Load the publishable key from the server. The publishable key
            // is set in your .env file.
            const publishableKey = "{{config('app.stripe_key')}}";

            const stripe = Stripe(publishableKey, {
                apiVersion: '2020-08-27',
            });

            const clientSecret = "{{$clientSecret}}";

            const {error, paymentIntent} = await stripe.retrievePaymentIntent(
                clientSecret
            );
        });

    </script>
</head>
<body>
<main>
    <a href="/">Acceuil</a> <!-- todo : put the next url to open the app -->
    <h1>Thank you!</h1>

    <div id="messages" role="alert"></div>
</main>
</body>
</html>
