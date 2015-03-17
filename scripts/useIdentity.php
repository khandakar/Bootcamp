<?php

###Include our XMLRPC Library###
include("xmlrpc-2.0/lib/xmlrpc.inc");

###Set our Infusionsoft application as the client###
$client = new xmlrpc_client("https://mamun.infusionsoft.com/api/xmlrpc");

###Return Raw PHP Types###
$client->return_type = "phpvals";

###Dont bother with certificate verification###
$client->setSSLVerifyPeer(FALSE);

###Our API Key###
$key = "buunmh5h7gyvjjjgkhcfcpdp";

################################################################################
###Our Function to a tag to a contact                                        ###
################################################################################
function addTag($CID, $TID) {
###Set up global variables###
	global $client, $key;
###Set up the call to add to the group###
	$call = new xmlrpcmsg("ContactService.addToGroup", array(
		php_xmlrpc_encode($key), 		#The encrypted API key
		php_xmlrpc_encode($CID),		#The contact ID
		php_xmlrpc_encode($TID),		#The tag ID
	));
###Send the call###
	$result = $client->send($call);

	if(!$result->faultCode()) {
		print "Tag " . $TID . " added to contact.";
		print "<BR>";
	} else {
		print $result->faultCode() . "<BR>";
		print $result->faultString() . "<BR>";
	}
}

################################################################################
###Our Function to add contact to a Follow up sequence                        ###
################################################################################
function addCamp($CID, $FUS) {
###Set up global variables###
	global $client, $key;
	
###Set up the call to add to the Follow up sequence###
	$call = new xmlrpcmsg("ContactService.addToCampaign", array(
		php_xmlrpc_encode($key), 		#The encrypted API key
		php_xmlrpc_encode($CID),		#The contact ID
		php_xmlrpc_encode($FUS),		#The Follow up sequence ID
	));
###Send the call###
	$result = $client->send($call);

	if(!$result->faultCode()) {
		print "Contact added to Follow up sequence " . $CMP;
		print "<BR>";
	} else {
		print $result->faultCode() . "<BR>";
		print $result->faultString() . "<BR>";
	}
}

################################################################
###We only want to run the API script if there is posted data###
################################################################
if (isset($_POST['user'],$_POST['password'])) {
	if ($_POST['user'] == "" || $_POST['password'] == "") {
		//ABORT
		echo "<script>alert('You must fill out the required fields!');</script>";
	} else {
		
###Build a Key-Value Array to store a contact###
$contact = array(
		"UserName" => 	$_POST['user'],
		"Password" => 	$_POST['password'],
	);

###Set up the call###
$call = new xmlrpcmsg("ContactService.add", array(
		php_xmlrpc_encode($key), 		#The encrypted API key
		php_xmlrpc_encode($contact)		#The contact array
	));

###Send the call###
	$result = $client->send($call);

###Check the returned value to see if it was successful and set it to a variable/display the results###
	if(!$result->faultCode()) {
                $conID = $result->value();
		print "Contact added was " . $conID;
		print "<BR>";
	} else {
		print $result->faultCode() . "<BR>";
		print $result->faultString() . "<BR>";
	}
###Finally, lets alert them if they didnt post the required fields###
} else {
echo "<script>alert('Be sure to fill out all required fields.');</script>"; 
}
?>