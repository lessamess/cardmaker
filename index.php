<?php
if (!empty($_POST['cards'])) {
    define('FPDF_FONTPATH','fpdf/font/');
    include("fpdf/fpdf.php");

    $strings = explode("\n", $_POST['cards']);

    $pdf = new FPDF("L","mm","A4");
    $pdf->SetTopMargin = 0;
    $pdf->SetDrawColor(220, 220, 220);

    // Linienbreite einstellen, 0.5 mm
    $pdf->SetLineWidth(0.1);

    Foreach ($strings as $key => $string) {
        $num = $key + 1;
        Switch ($num%4){
            case 1:
                $pdf->AddPage();

                // Linie zeichnen
                if(!empty($_POST['cropmark'])) {
                    $pdf->Line(148, 0, 148, 210);
                    $pdf->Line(0, 105, 297, 105);
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

        $pdf->SetFont('Arial','',12);
        $pdf->Cell( 110, 10, $num,0,2);
        $pdf->SetFont('Arial','B',14);
        $pdf->MultiCell( 110, 8, utf8_decode($string),0);
    }

    $pdf->Output("Cardsortdeck.pdf","D");



    die();
}

?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Cardmaker</title>
    <style>
        body {
            font-family: Georgia, "Times New Roman", serif;
            background:url(hintergrund.jpg);
            margin: 20px 0 20px -300px;
            padding-left: 50%;
            color: #c9a24f;
        }
        a:link {
            color: #b50000;
        }

        a:visited {
            color: #b50000;
        }
        #everything {
            width: 600px;
            background-color: #fff;
            -moz-border-radius: 15px;
                border-radius: 15px;
            padding:22px;
            background-color: #f7f6f2;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f7f6f2), color-stop(13%, #fff), color-stop(25%, #f7f6f2) );
            background-image: -moz-linear-gradient(top, #f7f6f2, #fff 13%, #f7f6f2 25%, #f7f6f2);
            border: 1px dotted #c9a24f;

        }

        .footer{
            border-bottom: 1px dotted #c9a24f;
            padding:22px;
            width: 600px;
            margin-top: 20px;
            font-family: helvetica, verdana, sans-serif;
            font-size: 0.8em;
            text-align: center;
        }
        h1 {
            width: 100%;
            text-align: center;
            font-weight: normal;
            font-size: 2.2em;
            margin: 0;
        }
        textarea {
            width: 100%;
            height: 300px;
            border: 1px solid #c9a24f;
        }

        .claim {
            width: 100%;
            text-align: center;
        }
        .instr {
            color:#87AF0E;
            width: 500px;
            margin-left: 50px;
            border-top: 1px dashed #c9a24f;
            border-bottom: 1px dashed #c9a24f;
            padding: 10px 0;
        }
        .button {
            border: 1px solid #4E7D0E;
            border-radius: 5px;
            width: 150px;
            display: inline-block;
            outline: none;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            padding: 7px 0;
            background: #000;
            background-image:
                -webkit-gradient(
                    linear,
                    left top,
                    left bottom,
                    color-stop(0.00, #7DB72F),
                    color-stop(100%, #4E7D0E)
                );
            background-image: -moz-linear-gradient(center top , #7DB72F, #4E7D0E);
        }
    </style>
    <script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-2297835-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</head>
<body>
    <div id="everything">
        <h1>Cardmaker</h1>
        <div class="claim">The easy way to make a cardsort deck.</div>
        <br>
        <p class="claim instr">Enter Card-Names&nbsp;&nbsp;&nbsp;→&nbsp;&nbsp;&nbsp; Get PDF&nbsp;&nbsp;&nbsp;→&nbsp;&nbsp;&nbsp;Print Your Cardsort Deck</p>
        <br>

        Enter Card-Names, one name per line:
        <form action="index.php" method="POST">
            <textarea name="cards" ></textarea>
            <br><br>
            <input type="checkbox" id="cropmark" name="cropmark" value=1> <label for="cropmark">Show cropmarks</label><br><br>
                <input type="submit" class="button" name="submit" value="Get PDF">

        </form>
    </div>
    <div class="footer">
    Ping me on <a href="http://twitter.com/bratwurstkomet">Twitter for feedback</a>
    </div>
<!-- PUT JS HERE -->
</body>