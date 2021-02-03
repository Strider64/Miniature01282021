<div class="subscribe_info">
    <h2>Only $15.00 Per Year!</h2>
    <p>The Miniature Photographer is a website development and photography company that is FREE to use, but
    I am asking for a $15.00 (USD) per year subscription to help offset the costs. It is strictly volunteer
    and no features will be left out without having a subscription.</p>
</div>
<div id="paypal-button-container"></div>
<script src="https://www.paypal.com/sdk/js?client-id=AfNFD6Lrv6FGJvVGXIycY1HhaNNq22Vw21JAwv4zFSp1cTNGCMItNEKsqEUvgiB2jmN2glzRjzacmqUX&vault=true&intent=subscription"
        data-sdk-integration-source="button-factory"></script>
<script>
    paypal.Buttons({
        style: {
            shape: 'pill',
            color: 'black',
            layout: 'vertical',
            label: 'subscribe'
        },
        createSubscription: function (data, actions) {
            return actions.subscription.create({
                'plan_id': 'P-5E965765G91370830MALBZOI'
            });
        },
        onApprove: function (data, actions) {
            alert(data.subscriptionID);
        }
    }).render('#paypal-button-container');
</script>
