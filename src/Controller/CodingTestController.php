<?php

namespace App\Controller;

use App\Service\GoogleScriptService;
use App\Service\GoogleService;
use Google_Exception;

class CodingTestController extends AppController
{
    public function template()
    {
        $this->viewBuilder()->setLayout('document');
        $this->viewBuilder()->setHelpers(['Document']);

        $plaintiffs = [
            'Jesse Seale',
            'Nils Coleman',
            'Brad Daw',
            'Yon Beny',
            'Tom Lew',
            'Sara Kall',
        ];

        $defendants = [
            'GoSmith, Inc',
            'Bret Merreli',
            'Sam Guru',
            'Tony Lee',
        ];

        $dncrViolation = true;
        $idnclViolation = true;
        $tiaaViolation = true;

        $this->set(compact(
            'plaintiffs',
            'defendants',
            'dncrViolation',
            'idnclViolation',
            'tiaaViolation'
        ));
    }

    /**
     * @throws Google_Exception
     */
    public function generated()
    {
        $googleService = new GoogleService();

        // test doc
        $documentId = '1CRncMENzKXdYeH_WaXtXDHcV8kU2PNr4iAf0wzpV0Zw';

        $this->viewBuilder()->setLayout('document');
        $this->viewBuilder()->setHelpers(['Document']);

//        $requests = [];
//        $requests[] = new Google_Service_Docs_Request([
//            'replaceAllText' => [
//                'containsText' => [
//                    'text'      => 'SectionHeader',
//                    'matchCase' => 'true',
//                ],
//                'replaceText'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
//            ],
//        ]);

//        $headerRequests = [];
//        $headerRequests[] = new Google_Service_Docs_Request([
//            'replaceAllText' => [
//                'containsText' => [
//                    'text'      => 'SectionHeader',
//                    'matchCase' => 'true',
//                ],
//                'replaceText'  => $sectionHeader->body->content,
//            ],
//        ]);

        GoogleScriptService::insertParagraph();

//        $googleService->createNewDoc($documentId);


//        $batchUpdateRequest = new Google_Service_Docs_BatchUpdateDocumentRequest([
//            'requests' => $headerRequests,
//        ]);

//        $service->documents->batchUpdate($documentCopyId, $batchUpdateRequest);

//        printf("The document title is: %s\n", $doc->getTitle());

//        $this->set(compact('documentCopyId'));
    }
}
