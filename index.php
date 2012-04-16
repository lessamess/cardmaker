<?php

if (!empty($_POST['cards'])) {

    define('tFPDF_FONTPATH','tfpdf/font/');
    include("tfpdf/tfpdf.php");

    $splitter ="\n";
    //detect "---"
    if(strpos($_POST['cards'], "---") !== false) {
        $splitter ="---";
    }

    $strings = explode($splitter, trim($_POST['cards']));

    $showNumbers = 0;
    if (!empty($_POST['showNumbers'])) {
        $showNumbers = 1;
    }


    $cardsPerPage = $_POST['cardsPerPage'];

    $orientation = "L";
    if ($cardsPerPage == 8) {
        $orientation = "P";
    }

    $pdf = new tFPDF($orientation, "mm", "A4");
    $pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);
    $pdf->AddFont('DejaVuBold','','DejaVuSans-Bold.ttf',true);
    $pdf->SetTopMargin = 0;
    $pdf->SetDrawColor(220, 220, 220);

    $pdf->SetLineWidth(0.1);
    switch ($cardsPerPage){
        case 1:
            $pdf = oneCardPdf($pdf, $strings, $showNumbers);
            break;
        case 4:
            $pdf = fourCardPdf($pdf, $strings, $showNumbers);
            break;
        case 8:
            $pdf = eightCardPdf($pdf, $strings, $showNumbers);
            break;
    }

    $pdf->Output("Cardsortdeck.pdf","D");

    die();
}

function oneCardPdf($pdf, $strings, $showNumbers){

        Foreach ($strings as $key => $string) {
        $string = trim($string);
        $num = $key + 1;
        $pdf->AddPage();
        $pdf->SetXY(20, 30);

        //write Number
        if ($showNumbers == 1) {
            $pdf->SetFont('DejaVu','',20);
            $pdf->Cell( 240, 20, (string)$num,0,2);
        }
        //write Card Name
        $pdf->SetFont('DejaVuBold','',32);
        $pdf->MultiCell( 257, 16, $string,0,"L"); // write Cardname
        //Syntax: MultiCell(float w , float h , string txt [, mixed border] [, string align] [, integer fill])
    }
    return $pdf;

}
function fourCardPdf($pdf, $strings, $showNumbers){
    Foreach ($strings as $key => $string) {
        $string = trim($string);
        $num = $key + 1;
        Switch ($num%4){
            case 1:
                $pdf->AddPage();

                // draw cropmarks
                if(!empty($_POST['cropmark'])) {
                    $pdf->Line(148, 0, 148, 20);
                    $pdf->Line(148, 190, 148, 210);
                    $pdf->Line(0, 105, 20, 105);
                    $pdf->Line(277, 105, 297, 105);
                }

                $pdf->SetXY(20, 30);
                break;
            case 2:
                $pdf->SetXY(170, 30);
                break;
            case 3:
                $pdf->SetXY(20, 125);
                break;
            case 0:
                $pdf->SetXY(170, 125);
            break;
        }
        //write Number
        if ($showNumbers == 1) {
            $pdf->SetFont('DejaVu','',12);
            $pdf->Cell( 110, 10, (string)$num ,0,2);
        }
        //write Card Name
        $pdf->SetFont('DejaVuBold','',14);
        $pdf->MultiCell( 110, 8, $string,0,"L"); // write Cardname
    }
    return $pdf;
}

function eightCardPdf($pdf, $strings, $showNumbers){
    Foreach ($strings as $key => $string) {
        $string = trim($string);
        $num = $key + 1;
        Switch ($num%8){
            case 1:
                $pdf->AddPage();

                // draw cropmarks
                if(!empty($_POST['cropmark'])) {
                    $pdf->Line(0, 74, 210, 74);
                    $pdf->Line(0, 148, 210, 148);
                    $pdf->Line(0, 222, 210, 222);
                    $pdf->Line(105, 0, 105, 297);
                }

                $pdf->SetXY(10, 10);
                break;
            case 2:
                $pdf->SetXY(115, 10);
                break;
            case 3:
                $pdf->SetXY(10, 82);
                break;
            case 4:
                $pdf->SetXY(115, 82);
                break;
            case 5:
                $pdf->SetXY(10, 154);
                break;
            case 6:
                $pdf->SetXY(115, 154);
                break;
            case 7:
                $pdf->SetXY(10, 226);
                break;
            case 0:
                $pdf->SetXY(115, 226);
                break;
        }
        //write Number
        if ($showNumbers == 1) {
            $pdf->SetFont('DejaVu','',12);
            $pdf->Cell( 85, 10, (string)$num,0,2);
        }
        //write Card Name
        $pdf->SetFont('DejaVuBold','',14);
        $pdf->MultiCell( 85, 7, $string,0,"L"); // write Cardname
    }
    return $pdf;
}

?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content=" minimum-scale=1.0, maximum-scale=1.0, width=device-width; user-scalable=no">
        <title>Cardmaker</title>
    <link href="style.css" media="screen" type="text/css" rel="stylesheet" />
</head>
<body>
    <div id="everything">
        <h1>Cardmaker</h1>
        <div class="claim">The easy way to make a cardsort deck.</div>
        <br>
        <p class="claim instr">Enter Card-Names&nbsp;&nbsp;&nbsp;→&nbsp;&nbsp;&nbsp; Get PDF&nbsp;&nbsp;&nbsp;→&nbsp;&nbsp;&nbsp;Print Your Cardsort Deck</p>
        <br>

        Enter Card-Names, one name per line<br>
        <span class="hint">(or use "---" as a separator to create multiple-line cards)</span><br><br>

        <form action="index.php" method="POST">
            <textarea name="cards" id="cards"></textarea>
            <br><br>
            Cards per page:
            <label><input type="radio" name="cardsPerPage" value="1"> 1 </label>&nbsp;
            <label><input type="radio" name="cardsPerPage" value="4" checked> 4 </label>&nbsp;
            <label><input type="radio" name="cardsPerPage" value="8"> 8 </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" id="showNumbers" name="showNumbers" value=1 checked> <label for="showNumbers">Show numbers</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br class="hideOnDesktop"><br class="hideOnDesktop">
            <input type="checkbox" id="cropmark" name="cropmark" value=1> <label for="cropmark">Show cropmarks</label><br>
            <br>
                <input type="submit" class="button" name="submit" value="Get PDF">
        </form>
    </div>
    <div class="footer">
    Ping me on <a href="http://twitter.com/bratwurstkomet">Twitter for feedback</a>
    </div>
<!-- PUT JS HERE -->
<script type="text/javascript" src="analytics.js"></script>
<script type="text/javascript" src="main.js"></script>
</body>