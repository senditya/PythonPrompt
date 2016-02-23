<?php

/*
 * Prompt Bot 'Hello World!' sample application
 * 
 * General notes (delete these once read):
 * 
 * BEFORE YOU START; You will need to update your library dependencies.
 * 
 * This is managed by composer. Check you have composer installed, then from the httpdocs directory;
 * cd include && rm -rf vendor/ && composer update
 * 
 * Installing;
 * - Bots run over the HTTP protocol. You will need to ensure the httpdocs directory is accessible via a webserver
 * - Ensure mod_rewrite is enabled to allow API versioning out of the box
 * - HTTPS SSL is prefered, although refular HTTP is accepted
 * - Test your installation by visiting it in a browser. If its correctly configured you should get a 401 Unauthorized.
 * 
 * Key tasks of a Bot;
 * - Message parsing and tokenization
 *   = Create a message parse such as the example in Bot\Parsers\PromptParser()
 *   = Extract the tokens from your parser
 * - Data processing (calling remote API's etc)
 *   = Create a set of utility classes that query and process the data
 *   = $hw = new Bot\HelloWorld\HelloWorldAPI(); $hw->process();
 * - Response message formatting
 *   = $hw->getMessageText();
 * 
 * - Explore the sample code in this file to extend the process described above
 * 
 * File structure;
 * - The API endpoint 
 * - Create business use classes in include/classes. 
 * - Typically use the Bot namespace for building functionality.
 * 
 * Security;
 * - Generate a new unique API key for each bot and put in setAPIKey(); http://randomkeygen.com/ (CodeIgniter Encryption Keys)
 * 
 * Testing;
 * - Your Bot endpoint URL is /api/1.0
 * - In the scripts directory, there are examples for calling your Bot over http
 * - Edit the simplerequest.sh file and insert your API key and edit your hostname (default is localhost)
 * - Run simplerequest.sh to connect to your bot and test it.
 * - The Prompt Library should output your response in a clean JSON format.
 * 
 * Integration;
 * - Use Unirest for remote API integrations where no native library is offered by the API
 * - Unirest: http://unirest.io/php.html
 * 
 */

// Bootstrap this Bot
require_once(sprintf("%s/include/initsystem_inc.php", $_SERVER['DOCUMENT_ROOT']));

// Load our request and response objects
use Prompt\Bot\Request;
use Prompt\Bot\Response;

// Access our own Bot utility classes
use Bot\HelloWorld;

// Creat instances of the Bot Request and Response objects
// The request object lets us inspect 'incoming' Prompt data,
// the response object ensures we are sending the correct data back to Prompt.
$request = new Request\Request();
$response = new Response\Response();

// This is our authentication key. This is the same key we ask Prompt to send us to avoid spoofing.
$request->setAPIKey('2Z1xF30H78lh0gm0O6CGeBxBF7V530Q3');

// If the API is authenticated, we can proceed
if ($request->isAPIAuthenticated()) {

    // All responses are based on Results\ResultItem abstract class
    // This example has implemented it, and the various data elements populated
    $resultitem = new Bot\Result\ResultItem();

    // Is this an external webook? e.g. A 3rd Party calling your bot.
    if ($request->getMessageType() == "webhook") {

        // We should ideally check for a key from the 3rd party host here to ensure it's really them
        // You would add this to your callback URL in the form ?key=***RANDOM_KEY***
        if (!$request->getGETVar('key') == '*** YOUR_KEY_YOU_INCLUDE_IN_YOUR_CALLBACK ***') {
            $request->sendFailedAuthentication(false);
            die("Webhook Key is invalid.");
        }

        // Process the web hook
        $myid = $request->getGETVar("confirmation_id");

        // The Webhook reply can be any string the caller expects, but is typically blank
        // If you want to send the user back to the chat interface, use the command string ||REDIRECT||
        $resultitem->setWebhookReply(NULL);

        // We can set the status code of the reply
        $response->setStatusCode('OK');
    }

    // Is this a regular message? This is how the majority of your calls will be processed.
    if ($request->getMessageType() == "message") {
        // foo
    }

    // Finaly, we reply with the result item we've created. 
    $response->reply($resultitem);

    // And we are done!
} else {
    // Failed authentication sends a common response back to Prompt
    $request->sendFailedAuthentication();
}
