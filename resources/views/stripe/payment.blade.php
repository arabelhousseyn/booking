<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>Payment</title>

    <link rel="stylesheet" href="{{asset('assets/payment_elements/html/css/base.css')}}"/>
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

            const url = new URL(window.location);
            const clientSecret = "{{$payment->clientSecret()}}";

            const {error, paymentIntent} = await stripe.retrievePaymentIntent(
                clientSecret
            );
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            // Load the publishable key from the server. The publishable key
            // is set in your .env file.
            const publishableKey = "{{config('app.stripe_key')}}";

            const stripe = Stripe(publishableKey, {
                apiVersion: '2020-08-27',
            });

            // On page load, we create a PaymentIntent on the server so that we have its clientSecret to
            // initialize the instance of Elements below. The PaymentIntent settings configure which payment
            // method types to display in the PaymentElement.
            const clientSecret = "{{$payment->clientSecret()}}";

            // Initialize Stripe Elements with the PaymentIntent's clientSecret,
            // then mount the payment element.
            const elements = stripe.elements({clientSecret});
            const paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');
            // Create and mount the linkAuthentication Element to enable autofilling customer payment details
            const linkAuthenticationElement = elements.create("linkAuthentication");
            linkAuthenticationElement.mount("#link-authentication-element");
            // If the customer's email is known when the page is loaded, you can
            // pass the email to the linkAuthenticationElement on mount:
            //
            //   linkAuthenticationElement.mount("#link-authentication-element",  {
            //     defaultValues: {
            //       email: 'jenny.rosen@example.com',
            //     }
            //   })
            // If you need access to the email address entered:
            //
            //  linkAuthenticationElement.on('change', (event) => {
            //    const email = event.value.email;
            //    console.log({ email });
            //  })

            // When the form is submitted...
            const form = document.getElementById('payment-form');
            let submitted = false;
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Disable double submission of the form
                if (submitted) {
                    return;
                }
                submitted = true;
                form.querySelector('button').disabled = true;

                const nameInput = document.querySelector('#name');

                // Confirm the payment given the clientSecret
                // from the payment intent that was just created on
                // the server.
                const {error: stripeError} = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: `${window.location.origin}/{{$booking->getKey()}}/return/{{$payment->clientSecret()}}`,
                    }
                });
            });
        });
    </script>
</head>
<body>
<main>
    <h1>Booking</h1>

    <form id="payment-form">
        <div id="link-authentication-element">
            <!-- Elements will create authentication element here -->
        </div>
        <div id="payment-element">
            <!-- Elements will create form elements here -->
        </div>
        <button
            id="submit">{{__('nominations.pay_now')}} {{(new NumberFormatter('fr_FR',NumberFormatter::CURRENCY))->formatCurrency($booking->caution,'dzd')}}</button>
        <div id="error-message">
            <!-- Display error message to your customers here -->
        </div>
    </form>

    <div id="messages" role="alert" style="display: none;"></div>
</main>
</body>
</html>
