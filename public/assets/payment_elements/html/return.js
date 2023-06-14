document.addEventListener('DOMContentLoaded', async () => {
  // Load the publishable key from the server. The publishable key
  // is set in your .env file.
    const publishableKey = "pk_test_51NFjCuJK5jkQSg6d7ujvd7FJwGIpuT6WpAbL598jRnv6MjFFEd21lsFoFm5LQmefETjOMxDxhD5MwNzcPWJ7Wp8W00s0cNyl4F";

  const stripe = Stripe(publishableKey, {
    apiVersion: '2020-08-27',
  });

  const url = new URL(window.location);
  const clientSecret = url.searchParams.get('payment_intent_client_secret');

  const {error, paymentIntent} = await stripe.retrievePaymentIntent(
    clientSecret
  );
  if (error) {
    addMessage(error.message);
  }
  addMessage(`Payment ${paymentIntent.status}: ${paymentIntent.id}`);
});
