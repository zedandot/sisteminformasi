<?php
require 'vendor/autoload.php';

$inputFileName = __DIR__ . '/storage/app/template_bap.xls';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

// Let's use the exact names from the previous output
$worksheet = $spreadsheet->getSheetByName('Foto ');
if (!$worksheet) {
    echo "Sheet 'Foto ' not found.\n";
    exit;
}

$highestRow = 50;
$highestColumn = 'M';

for ($row = 1; $row <= $highestRow; ++$row) {
    for ($col = 'A'; $col <= $highestColumn; ++$col) {
        $value = $worksheet->getCell($col . $row)->getValue();
        if ($value) {
            echo $col . $row . ' : ' . $value . "\n";
        }
    }
}
