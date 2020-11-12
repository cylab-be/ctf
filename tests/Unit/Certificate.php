<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Unit;

/**
 * Description of Certificate
 *
 * @author tibo
 */
class Certificate
{

    private $pdf;
    private $name;
    private $challenge;
    private $link;

    public function __construct(string $name, string $challenge, string $link)
    {
        $this->name = $name;
        $this->challenge = $challenge;
        $this->link = $link;
    }

    public function render()
    {
        $pdf = new \TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 002');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetAutoPageBreak(false, 0);

        // start page
        $pdf->AddPage();

        // background image
        $img_file = __DIR__ . '/bokeh.jpg';
        $pdf->Image($img_file, 0, 0, 297, 210, '', '', '', true, 300, '', false, false, 0);

        //define('K_PATH_FONTS', __DIR__);

        // set font and write some text...
        //var_dump($pdf->AddFont('vollkorn', '', __DIR__ . '/vollkorn.php'));
        \TCPDF_FONTS::addTTFfont(__DIR__ . '/VollkornBold.ttf');
        $fontname = \TCPDF_FONTS::addTTFfont(__DIR__ . '/VollkornRegular.ttf');
        $pdf->SetFont($fontname, '', 28);

        $pdf->setColor('text', 60, 60, 60);
        $pdf->SetY(30);
        $pdf->writeHTML(
            '<p><b>CERTIFICATE</b> <span style="font-size: 75%">of</span> <b>COMPLETION</b></p>',
            true,
            false,
            true,
            false,
            'C'
        );

        $pdf->SetY($pdf->GetY() + 10);
        $pdf->Write(0, 'This certifies that', '', 0, 'C', true);

        $pdf->SetY($pdf->GetY() + 5);
        $pdf->WriteHTML(
            '<p style="font-size: 110%"><b>' . strtoupper($this->name) . '</b></p>',
            true,
            false,
            true,
            false,
            'C'
        );

        $pdf->SetY($pdf->GetY() + 5);
        $pdf->Write(0, 'completed the capture-the-flag challenge', '', 0, 'C', true);

        $pdf->SetY($pdf->GetY() + 5);
        $pdf->WriteHTML('<p><b>' . $this->challenge . '</b></p>', true, false, true, false, 'C');

        $pdf->SetY($pdf->GetY() + 5);
        $pdf->writeHTML('<p>with a final score of <b>155</b> points</p>', true, false, true, false, 'C');

        $pdf->SetY($pdf->GetY() + 15);
        $pdf->SetFont($fontname, '', 20);
        $pdf->writeHTML('<p>Date of challenge: <b>' . date('Ymd') . '</b></p>', true, false, true, false, 'C');
        $pdf->writeHTML(
            '<p>Ranking: <b>' . ordinal(1) . '</b> out of <b>23</b> participants</p>',
            true,
            false,
            true,
            false,
            'C'
        );

        $pdf->SetY($pdf->GetY() + 10);
        // https://tcpdf.org/examples/example_050/
        $options = [];
        $pdf->write2DBarcode($this->link, 'QRCODE,Q', '', '', 15, 15, $options, 'N');

        $pdf->SetY($pdf->GetY() + 2);
        $pdf->SetFont($fontname, '', 11);
        $pdf->writeHTML('<p>' . $this->link . '</p>', true, false, true, false, 'L');
        $pdf->writeHTML('<p>Powered by https://cylab.be</p>', true, false, true, false, 'L');

        $this->pdf = $pdf;
    }

    public function save(string $file)
    {
        $this->pdf->Output($file, 'F');
    }
}

function ordinal($number)
{
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
        return $number . 'th';
    } else {
        return $number . $ends[$number % 10];
    }
}
