# zendesk-webhook-signature-verification-php
PHP script to verify Zendesk webhook signatures.

A couple of points:
- Each webhook has its own secret - must be provided to the function manually.
- Email addresses in the parameters must have the "@" symbol encoded as "%40" (is the case already by default for Zendesk - no need to do anything).
- The secret for each webhook can be obtained in 3 ways:

---- from the Zendesk interface (https://yourdomain.zendesk.com/admin/apps-integrations/webhooks/webhooks)

---- or by making a GET API call to https://yourdomain.zendesk.com/api/v2/webhooks/{webhook ID}/signing_secret (e.g. via Postman) (webhook ID can be obtained from the webhook URL on the interface)

---- or from the webhook request headers themselves - header "X-Zendesk-Webhook-Id" contains the webhook ID (not sure if it can be trusted though)


*** Please do keep in mind that all of this was valid at the time of implementation and thus I cannot guarantee it will also be valid in the future in case Zendesk decides to change their approach. I do intend to keep it up to date though.


Hope this helps someone.
