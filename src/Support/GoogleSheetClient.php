<?php
namespace UninstallerForm\Support;

use Google_Client;
use Google_Service_Sheets;

/**
 * GoogleSheetClient class for the uninstaller form.
 * 
 * @since 1.0.0
 * 
 * @package UNINSTALLER_FORM
 */
class GoogleSheetClient {
    protected $client;
    protected $service;
    protected $spreadsheetId;
    protected $sheetName;

    /**
     * GoogleSheetClient Constructor.
     * 
     * @param string $credentialsPath The path to the Google credentials file.
     * @param string $spreadsheetId The ID of the Google spreadsheet.
     * @param string $sheetName The name of the Google sheet.
     * 
     * @since 1.0.0
     */
    public function __construct($credentialsPath, $spreadsheetId, $sheetName = 'Sheet1') {
        $this->spreadsheetId = $spreadsheetId;
        $this->sheetName     = $sheetName;

        $this->client = new Google_Client();
        $this->client->setAuthConfig($credentialsPath);
        $this->client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $this->service = new Google_Service_Sheets($this->client);
    }

    /**
     * Get data from a specific row in the Google sheet.
     * 
     * @param array $values The row number to retrieve data from.
     * 
     * @return array The data from the specified row.
     * 
     * @since 1.0.0
     */
    public function appendRow(array $values) {
        $sheets = $this->service->spreadsheets->get($this->spreadsheetId)->getSheets();
        $sheetExists = false;

        foreach ($sheets as $sheet) {
            if ($sheet->getProperties()->getTitle() === $this->sheetName) {
                $sheetExists = true;
                break;
            }
        }

        // Create sheet if it doesn't exist
        if (!$sheetExists) {
            $addSheetRequest = new \Google_Service_Sheets_Request([
                'addSheet' => [
                    'properties' => [
                        'title' => $this->sheetName,
                    ],
                ],
            ]);

            $batchUpdateRequest = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
                'requests' => [$addSheetRequest],
            ]);

            $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
        }

        // Append data
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => [$values],
        ]);
        $params = ['valueInputOption' => 'RAW'];

        return $this->service->spreadsheets_values->append(
            $this->spreadsheetId,
            $this->sheetName,
            $body,
            $params
        );
    }

}