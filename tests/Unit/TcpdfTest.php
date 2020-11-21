<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * @group tcpdf
 */
class TcpdfTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
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
        $img_file = __DIR__ . '/background.png';
        $pdf->Image($img_file, 0, 0, 297, 210, '', '', '', true, 300, '', false, false, 0);


        // set font and write some text...
        $pdf->SetFont('times', 'B', 20);
        $txt = "Some text...";
        $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

        // ---------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('/tmp/basic.pdf', 'F');
    }


    public function testCertificate()
    {
        $c = new \App\Certificate(
            'Thibault Debatty',
            'Advanced Network Security',
            \Carbon\Carbon::now(),
            155,
            2,
            23,
            'https://ctf.cylab.be/certificate/12345'
        );
        $c->save('/tmp/certificate.pdf');
    }
}
