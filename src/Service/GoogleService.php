<?php

declare(strict_types=1);

namespace App\Service;

use Google_Client;
use Google_Exception;
use Google_Service_Docs;
use Google_Service_Docs_BatchUpdateDocumentRequest;
use Google_Service_Docs_Request;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Script;

/**
 * Class GoogleService
 * @package App\Service
 */
class GoogleService
{
    public $client;
    public $service;

    /**
     * GoogleService constructor.
     * @throws Google_Exception
     */
    public function __construct()
    {
        $this->client = self::getClient();
        $this->service = new Google_Service_Docs($this->client);
    }

    /**
     * @return Google_Client
     * @throws Google_Exception
     */
    public static function getClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Docs API PHP Quickstart');
        $client->setScopes([
            Google_Service_Docs::DOCUMENTS,
            Google_Service_Docs::DRIVE,
            Google_Service_Script::SCRIPT_DEPLOYMENTS
        ]);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');

        // Load previously authorized credentials from a file.
        $credentialsPath = self::expandHomeDirectory('token.json');
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            $client->setRedirectUri('http://localhost:8765/CodingTest/template');
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

            // Store the credentials to disk.
            if (!file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, json_encode($accessToken));
            printf("Credentials saved to %s\n", $credentialsPath);
        }
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }

        return $client;
    }

    /**
     * Expands the home directory alias '~' to the full path.
     * @param string $path the path to expand.
     * @return string the expanded path.
     */
    public static function expandHomeDirectory($path): string
    {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }
        return str_replace('~', realpath($homeDirectory), $path);
    }


    public function createNewDoc(string $baseDocumentId): string
    {
        $copy = new Google_Service_Drive_DriveFile(['name' => 'Copy Title']);
        $newDoc = (new Google_Service_Drive($this->client))->files->copy($baseDocumentId, $copy);

//        $newDocContent = $this->service->documents->get($newDoc->id);
//        $sectionHeader = $this->service->documents->get('141t4UMIIvCmutoGpWk1Z-9z8510pWuJekksCXiFg6Z8');

//        dd([$newDocContent->body->content, $sectionHeader->body->content]);


        $this->replaceSection($baseDocumentId, $newDoc->id);

        return $newDoc->id;
    }


    public function replaceSection($baseDocId, $newDocId)
    {
        $newDocId = "14h_8oWEj5waoeH2dNqVN3d_ZT09iV3k7CeHTI7X_RY8";

        $newDocContent = $this->service->documents->get($newDocId);
        $sectionHeader = $this->service->documents->get('141t4UMIIvCmutoGpWk1Z-9z8510pWuJekksCXiFg6Z8');

        $lastElement = end($newDocContent->body->content);

//        dd([$newDocContent->body->content]);

        $requests = array();
        $requests[] = new Google_Service_Docs_Request(array(
//            'insertPageBreak' => [
//                'location' => array(
//                    'index' => $lastElement->endIndex - 5,
//                ),
//            ],
            'insertText' => array(
                'text' => '\n insert',
                'location' => array(
                    'index' => $lastElement->endIndex - 1,
                ),
            ),
        ));

        $batchUpdateRequest = new Google_Service_Docs_BatchUpdateDocumentRequest(array(
            'requests' => $requests
        ));

        $this->service->documents->batchUpdate($newDocId, $batchUpdateRequest);

        dd();
//        dd([$sectionHeader->body->content, $sectionHeader]);
//
//        $batchUpdateRequest = new Google_Service_Docs_BatchUpdateDocumentRequest([
//            'requests' => $headerRequests,
//        ]);
//
//        $service->documents->batchUpdate($documentCopyId, $batchUpdateRequest);
    }
}
