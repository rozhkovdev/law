<?php

declare(strict_types=1);

namespace App\Service;

use Exception;
use Google_Service_Script;
use Google_Service_Script_ExecutionRequest;

/**
 * Class GoogleScriptService
 * @package App\Service
 */
class GoogleScriptService
{
    public static function insertParagraph()
    {
        $client = (new GoogleService())->client;
        $service = new Google_Service_Script($client);

        // script page, file -> project properties -> project key
        $scriptId = 'MjStAXufQB12Hf8cBJXg6c8Qk7Y1y7WoV';

//        dd((new Google_Service_Script($client)));

// Create an execution request object.
        $request = new Google_Service_Script_ExecutionRequest();
        $request->setFunction('insertParagraph');

        try {
            // Make the API request.
            $response = $service->scripts->run($scriptId, $request);

            if ($response->getError()) {
                // The API executed, but the script returned an error.

                // Extract the first (and only) set of error details. The values of this
                // object are the script's 'errorMessage' and 'errorType', and an array of
                // stack trace elements.
                $error = $response->getError()['details'][0];
                printf("Script error message: %s\n", $error['errorMessage']);

                if (array_key_exists('scriptStackTraceElements', $error)) {
                    // There may not be a stacktrace if the script didn't start executing.
                    print "Script error stacktrace:\n";
                    foreach ($error['scriptStackTraceElements'] as $trace) {
                        printf("\t%s: %d\n", $trace['function'], $trace['lineNumber']);
                    }
                }
            }
        } catch (Exception $e) {
            // The API encountered a problem before the script started executing.
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
}
