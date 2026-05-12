<?php
require 'vendor/autoload.php';

$inputFileName = __DIR__ . '/storage/app/template_bap.xls';
$spreadsheet = @\PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
echo "Loaded successfully";
