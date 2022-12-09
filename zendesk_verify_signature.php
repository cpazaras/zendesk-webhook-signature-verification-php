/**
 * Verifies a request is indeed coming from Zendesk.
 *
 * At the time of implementation each webhook has its own secret - must be provided to the function manually.
 *
 * At the time of implementation any email addresses in the parameters must have the "@" symbol encoded as "%40" otherwise the resulting hash will not be the same (is the case already by default for Zendesk).
 *
 *
 * @param $incoming_signature	-- the signature received from Zendesk	---> getallheaders()['X-Zendesk-Webhook-Signature'];
 * @param $incoming_timestamp	-- the timestamp received from Zendesk	---> getallheaders()['X-Zendesk-Webhook-Signature-Timestamp'];
 * @param $incoming_body	-- the raw request body			---> file_get_contents("php://input");
 * @param $webhook_secret	-- the webhook secret key (each webhook has its own - different - key)
 *
 * @return bool
 */
function verifySignature($incoming_signature, $incoming_timestamp, $incoming_body, $webhook_secret){

	//the data to be signed (i.e. hashed)
	$to_hash	= $incoming_timestamp . $incoming_body;

	//recreate the signature
	$hash		= base64_encode(hash_hmac("sha256", $to_hash, $webhook_secret, true));

	//compare it to the received signature
	return hash_equals($incoming_signature, $hash);

}//end function


/**
 * Sample - Example webhook endpoint which will receive the request:
 */
function webhookEndpoint(){

	//incoming signature & timestamp
	$headers 		= getallheaders();
	$incoming_signature	= $headers['X-Zendesk-Webhook-Signature'];
	$incoming_timestamp	= $headers['X-Zendesk-Webhook-Signature-Timestamp'];

	//incoming body
	$body			= file_get_contents("php://input");

	//webhook secret
	$webhook_secret		= 'yourWebhookSecret';


	//verify
	if(!Zendesk::verifySignature($incoming_signature, $incoming_timestamp, $body, $webhook_secret)){
		echo ('failed');
	}//end if


	////// at this point we can trust that the request is coming from Zendesk


}//end function
