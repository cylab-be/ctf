<?php

namespace App;

use Carbon\Carbon;

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
    private $date;
    private $rank;
    private $participants;
    private $score;

    public function __construct(
        string $name,
        string $challenge,
        Carbon $date,
        int $score,
        int $rank,
        int $participants,
        string $link
    ) {
        $this->name = $name;
        $this->challenge = $challenge;
        $this->date = $date;
        $this->score = $score;
        $this->rank = $rank;
        $this->participants = $participants;
        $this->link = $link;

        $this->render();
    }

    public function render()
    {
        $pdf = new \TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('ctf.cylab.be');
        $pdf->SetTitle('CERTIFICATE of COMPLETION - ' . $this->name);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false, 0);

        // start page
        $pdf->AddPage();

        // background image
        $img_file = __DIR__ . '/../resources/certificate/bokeh.jpg';
        $pdf->Image($img_file, 0, 0, 297, 210, '', '', '', true, 300, '', false, false, 0);

        //define('K_PATH_FONTS', __DIR__);

        // set font and write some text...
        //$font = $pdf->addTTFfont(__DIR__ . '/../resources/certificate/VollkornRegular.ttf');
        //var_dump($pdf->AddFont('vollkorn', '', __DIR__ . '/vollkorn.php'));
        //\TCPDF_FONTS::addTTFfont(__DIR__ . '/../resources/certificate/VollkornBold.ttf');
        //$font = \TCPDF_FONTS::addTTFfont(__DIR__ . '/../resources/certificate/VollkornRegular.ttf');
        //\TCPDF_FONTS::addTTFfont(__DIR__ . '/../resources/certificate/VollkornBold.ttf');
        $font = 'dejavuserif';
        //$font = 'vollkorn';

        $pdf->SetFont($font, '', 28);

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
        $pdf->Write(0, 'This certifies that', '', false, 'C', true);

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
        $pdf->Write(0, 'completed the capture-the-flag challenge', '', false, 'C', true);

        $pdf->SetY($pdf->GetY() + 5);
        $pdf->WriteHTML('<p><b>' . $this->challenge . '</b></p>', true, false, true, false, 'C');

        $pdf->SetY($pdf->GetY() + 5);
        $pdf->writeHTML(
            '<p>with a final score of <b>' . $this->score . '</b> points</p>',
            true,
            false,
            true,
            false,
            'C'
        );

        $pdf->SetY($pdf->GetY() + 15);
        $pdf->SetFont($font, '', 20);
        $pdf->writeHTML(
            '<p>Date of challenge: <b>' . $this->date->toFormattedDateString() . '</b></p>',
            true,
            false,
            true,
            false,
            'C'
        );
        $pdf->writeHTML(
            '<p>Ranking: <b>' . ordinal($this->rank) . '</b> out of <b>'
                . $this->participants . '</b> participants</p>',
            true,
            false,
            true,
            false,
            'C'
        );

        $pdf->SetY($pdf->GetY() + 10);
        // https://tcpdf.org/examples/example_050/
        $options = [];
        $pdf->write2DBarcode($this->link, 'QRCODE,Q', null, null, 15, 15, $options, 'N');

        $pdf->SetY($pdf->GetY() + 2);
        $pdf->SetFont($font, '', 11);
        $pdf->writeHTML('<p>' . $this->link . '</p>', true, false, true, false, 'L');
        $pdf->writeHTML('<p>Powered by https://cylab.be</p>', true, false, true, false, 'L');

        $this->pdf = $pdf;
    }

    public function save(string $file)
    {
        $this->pdf->Output($file, 'F');
    }

    public function stream()
    {
        $this->pdf->Output();
    }
}
