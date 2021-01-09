<?php

/**
 * CodeIgniter DomPDF Library
 *
 * Generate PDF's from HTML in CodeIgniter
 *
 * @packge        CodeIgniter
 * @subpackage        Libraries
 * @category        Libraries
 * @author        Ardianta Pargo
 * @license        MIT License
 * @link        https://github.com/ardianta/codeigniter-dompdf
 */

use Dompdf\Dompdf;

class PdfExtender extends Dompdf
{
    /**
     * PDF filename
     * @var String
     */
    public $filename;
    // protected $DomPdf;
    public function __construct()
    {
        $this->filename = "laporan.pdf";
    }
    /**
     * Get an instance of CodeIgniter
     *
     * @access    protected
     * @return    void
     */
    /**
     * Load a CodeIgniter view into domPDF
     *
     * @access    public
     * @param    string    $filename set filename to save
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }
    /**
     * Load a CodeIgniter view into domPDF
     *
     * @access    public
     * @param    string    $view The view to load
     * @param    array    $data The view data
     * @return    void
     */
    public function load_view($view, $data = array())
    {
        $html = view($view, $data);
        $this->loadHtml($html);
        // Render the PDF
        $this->render();
        // Output the generated PDF to Browser
        $this->stream($this->filename, array("Attachment" => false));
    }
}
