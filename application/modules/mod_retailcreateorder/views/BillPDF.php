<?php
 
require_once 'vendor/autoload.php';
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf(['tempDir' =>  __DIR__ .'/tmp',
    'fontdata' => $fontData + [
            'sarabun' => [ 
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNew Italic.ttf',
                'B' =>  'THSarabunNew Bold.ttf',
                'BI' => "THSarabunNew BoldItalic.ttf",
            ]
        ],
]);
?>
 
<?php
$mpdf->AddPage('P','','','','',10,10,10,10,10,10);

$html .= "<style> body { font-family: 'Sarabun'; font-size: 19px;} .tbl-collaps {border-collapse: collapse;} </style>";
$html .= $htmlPDF;
 
$mpdf->WriteHTML($html);
$mpdf->Output();
?>