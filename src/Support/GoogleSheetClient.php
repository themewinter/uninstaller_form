<?php
namespace UninstallerForm\Support;

use Google_Client;
use Google_Service_Sheets;

class GoogleSheetClient {
    protected $client;
    protected $service;
    protected $spreadsheetId;
    protected $sheetName;

    public function __construct($credentialsPath, $spreadsheetId, $sheetName = 'Sheet1') {
        $this->spreadsheetId = $spreadsheetId;
        $this->sheetName     = $sheetName;

        $this->client = new Google_Client();
        $this->client->setAuthConfig($credentialsPath);
        $this->client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $this->service = new Google_Service_Sheets($this->client);
    }

    public function appendRow(array $values) {
        $body   = new \Google_Service_Sheets_ValueRange([
            'values' => [$values],
        ]);
        $params = ['valueInputOption' => 'RAW'];
        $range  = $this->sheetName;

        return $this->service->spreadsheets_values->append(
            $this->spreadsheetId,
            $range,
            $body,
            $params
        );
    }
}