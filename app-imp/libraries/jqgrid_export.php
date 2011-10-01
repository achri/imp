<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Jqgrid_export
{
	private $CI;
	private $_exportpdf = array();
	
	function __construct()
	{
		$this->CI =& get_instance();
		//$this->CI->load->library('session');
	}
	
	 /**
     * Show or not pdf icon to export
     * @param bool $element
     * @param array $params pdf properties array('exclude' => array('field1','fields'), // fields to exclude to show
     *                                           'title' => title, // pdf title
     *                                           'orientation' => portrait/landscape, //paper orientation
     *                                           'stream' => true/false, // download or save (./temp/filename.pdf)
     * @return void
     */
	public function setPdf($element,$params = array())
    {
        $this->_export['pdf']       = "{$element}";
        $this->_exportpdf['params'] = $params; //isset($params['title'])?$params['title']:'';
    }

	/**
     * Export data to pdf or csv
     * @param String $type pdf/csv
     * @return <type> 
     */
    function export()
    {
		$arrFormat = $this->CI->uri->rsegment_array();
		$key = array_search('jqgrid_export',$arrFormat);
		if($key)
			$format = $arrFormat[$key+1];
		else
			return false;
			
		$query  = $this->CI->session->userdata('dtgQuery');
		//$fields = $this->CI->session->userdata('dtgFields');
		$sql    = $this->_cleanExportSql($query);//, $fields);

		switch ($format):
			case 'csv' :
				$this->CI->load->dbutil();
				$query = $this->CI->db->query($sql);
				$delimiter = ",";
				$newline = "\r\n";
				header ("Content-disposition: attachment; filename=csvoutput_". time(). ".csv") ;
				echo $this->CI->dbutil->csv_from_result($query,$delimiter, $newline);
				exit;
			break;
			case 'xml' : 
				$this->CI->load->dbutil();
				$query = $this->CI->db->query($sql);
				header ("Content-disposition: attachment;content-type: text/xml; filename=xmloutput_". time(). ".xml") ;
				$config = array (
                      'root'    => 'root',
                      'element' => 'element',
                      'newline' => "\n",
                      'tab'     => "\t"
				);

				echo $this->CI->dbutil->xml_from_result($query, $config);
				exit;
			break;
			case 'pdf' :
				$this->CI->load->plugin('to_pdf');
				$query  = $this->CI->db->query($sql);
				$params = $this->_exportpdf['params'];
				$exclude     = (isset($params['exclude']))?$params['exclude']:array();
				$orientation = (isset($params['orientation']))?$params['orientation']:'portrait';
				$stream      = (isset($params['stream']))?$params['stream']:true;

				$html   = '';
				$html  .= (isset($params['title']))?'<h3><center>' .$params['title'] . '</center></h3>':'';
				$html  .= html_prepare($query, $exclude);
           
				//echo $html;
				pdf_create($html, "pdfoutput_". time(),$stream,$orientation);
			break;
		endswitch;
    }


    /**
     * Show report table
     * @param Int $reportid
     */
    function report($reportid)
    {
        
    }


    /**
     * Unset the Limit and show only the field data
     * @param String $sql
     * @param Array $fields
     * @return String $sql
     */
    private function _cleanExportSql($sql)//, $fields)
    {
        $query  = '';
        $frompos   = strpos($sql, 'FROM');
        $select    = 'SELECT ';        

//        if(isset($this->_field['field'])){
//            $i = 0;
//            foreach($this->_field['field'] as $field){
//
//                $select .= ($i== 0)?$field:',' . $field;
//                $i++;
//            }
//
//        }
        //echo $sql. '<hr>';
        $query     = $sql; //substr($sql, $frompos);
        $limitpos  = stripos($query, 'LIMIT ');
        if($limitpos > 0){
            $query     = substr($query, 0,$limitpos);
        }
        //echo  $query;
        return $query;
    }

}
	