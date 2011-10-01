<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Manage datagrid class
 * @author Victor Manuel Agudelo
 * @since 16-may-2010
 * @version 1.1
 *
 * url's
 * formats:
 * http://www.trirand.com/jqgridwiki/doku.php?id=wiki:predefined_formatter&s[]=date
 * edittype:
 * text, textarea, select, checkbox, password, button, image and file
 * http://www.trirand.com/jqgridwiki/doku.php?id=wiki:common_rules&s[]=date
 *
 * Rules
 * http://www.trirand.com/jqgridwiki/doku.php?id=wiki:common_rules
 *
 * example:
 * 
 *  $this->load->library('datagrid');
    $grid  = $this->datagrid;

    $grid->addField('id');
    $grid->label('ID')->validators (array('integer' => "{thousandsSeparator: ' ', defaultValue: '0'}"));
    $grid->params(array('align' => "'center'", 'width' => 50,'editable' => 'false','editoptions' => '{readonly:true,size:10}'));

    $grid->addField('descripcion');
    $grid->label('descripcion');
    $grid->params(array('width' => 300,'editable' => 'true','edittype' => "'textarea'", 'editrules' => '{required:true}'));

    $grid->addField('created_by');
    $grid->label('created_by');
    $grid->params(array('width' => 300,'editable' => 'true','edittype' => "'text'",'editrules' => '{date:true}'));

    #GET url
    $grid->setUrlget(site_url('welcome/getData/'));

    #Set url
    $grid->setUrlput(site_url('welcome/setData/'));

    #show paginator
    $grid->showpager(true);
    #titulo de la tabla
    $grid->setTitle('Prueba');

    #show/hide navigations buttonss
    $grid->setAdd(true);
    $grid->setEdit(true);
    $grid->setDelete(true);
    $grid->setSearch(true);

    $param['grid'] = $grid->deploy();
    $this->load->view('crud',$param);
 *
 *
 * controller
 /**
 * 
 #Get data result as json

public function getData()
{
    $this->load->library('datagrid');
    $grid             = $this->datagrid;
    $response         = $grid->getData('crud_test', array(array('table' => 'crud_relation', 'join' => 'crud_relation.id = crud_test.relation_id', 'fields' => array('description'))),array(),false);
    $rs = $grid->jsonresult( $response);
    echo $rs;


}


 #Put information

public function setData()
{
    $this->load->library('datagrid');
    $grid             = $this->datagrid;
    $response         = $grid->operations('crud_test','id');

}

 * 
 */

class Datagrid
{

    private $CI;
    public $_field;
    private $fieldtemp = '';
    #botones de acciones
    private $_buttons  = array('add'    => 'false',
                               'edit'   => 'false',
                               'delete' => 'false',
                               'search' => 'true',
                               'view'   => 'false',
							   'refresh'=> 'true'
                              );
    private $_export  = array('csv'     => false,
                              'pdf'     => false,
                              'excel'   => false,
                              'print'   => false,
                              'xml'     => false,
                              );
    private $_exportpdf = array();
    #Ordenacion de campos
    private $sortname  = '';
    private $sorttype  = 'desc';
    #urls de envio de informacion
    private $url_put   = '';
    
    #url de consulta
    private $url_get   = '';
   
    #url de edicion
    private $url_edit  = '';
    
    #url de eliminacion
    private $url_del   = '';

    private $datatype  = 'json';

    #numero de registros por pagina
    private $rowNum    = 20;
	
	private $rowList    = '10,20,50';
	private $rowNumbering = 'true';
	private $hiddenGrid = 'false';
	private $showsearch = 'false';
	private $scroll = 'false';

    #ancho de la pagina
    private $width = 635;

    #Ancho automatico
    private $autowidth = true;
    #muestra la barra de paginacion
    private $showpager = true;

    #alto de la pagina
    private $height  = '100%';//150;

    private $return  = array('table' => '', 'pager' => '');

    private $title    = '';

    private $_gridname;
	
	private $get_lang;

    function __construct ()
    {
       $this->CI =& get_instance();
       $this->CI->load->library('session');
	   
       if(empty($this->_gridname)){
           $this->_gridname = '_' . time();
       }
	   
	   $this->_lang();
    }
	
	private function _lang()
	{
		// LOAD LANG FILE
		$set_lang = $this->CI->session->userdata('set_lang');
		$this->CI->lang->load("general", $set_lang);
		$lang['btn_search'] = $this->CI->lang->line('btn_search');
		$lang['txt_search'] = $this->CI->lang->line('txt_search');
		$lang['btn_clear'] = $this->CI->lang->line('btn_clear');
		$lang['txt_clear'] = $this->CI->lang->line('txt_clear');
		
		$this->get_lang = $lang;
	}

    /**
     * Add fields to draw
     * @param String $field Field name
     * @return void
     */
    public function addField($field)
    {
        $this->fieldtemp = $field;
        $this->_field['field'][$field] = trim($field);
    }


    /**
     * Crea una clase con sus metodos
     * @param string $name nombre clase
     * @param <type> $args elementos que recibe la clase
     * @return void
     * 
     */
    function __call ($name, $args)
    {

        if ( substr(strtolower($name), 0, 3) == 'set' || substr(strtolower($name), 0, 3) == 'add' ) {
            $name = substr($name, 3);
            $name[0] = strtolower($name[0]);
        }

        $this->_field[$name][$this->fieldtemp] = $args[0];
        return $this;
    }

    function setgridName($name){
        $this->_gridname = '_' . $name;
    }


    /**
     *Show or not, the Add button
     * @param bool $element
     * @return void
     */
    public function setAdd($element)
    {
        $this->_buttons['add'] = "'{$element}'";
       
    }
    
    /**
     *Show or not, the Edit button
     * @param bool $element
     * @return void
     */
    public function setEdit($element)
    {
        $this->_buttons['edit'] = "'{$element}'";
    }
    
    /**
     *Show or not, the Delete button
     * @param bool $element
     * @return void
     */
    public function setDelete($element)
    {
        $this->_buttons['delete'] = "'{$element}'";
    }

    /**
     * Show or not, search button
     * @param bool $element
     * @return void
     */
    public function setSearch($element)
    {
        $this->_buttons['search'] = "'{$element}'";
    }
    /**
     * Show or not, view data button
     * @param bool $element
     * @return void
     */
    public function setView($element)
    {
        $this->_buttons['view'] = "'{$element}'";
    }

    /**
     * Show or not excel icon to export
     * @param bool $element
     * @return void
     */
    public function setExcel($element)
    {
        $this->_export['excel'] = "{$element}";
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
     * Show or not Csv icon to export
     * @param bool $element
     * @return void
     */
    public function setCsv($element)
    {
        $this->_export['csv'] = "{$element}";
    }

    /**
     * Show or not Csv icon to export
     * @param bool $element
     * @return void
     */
    public function setXml($element)
    {
        $this->_export['xml'] = "{$element}";
    }

    /**
     * Show or not print icon to export
     * @param bool $element
     * @return void
     */
    public function setPrint($element)
    {
        $this->_export['print'] = "{$element}";
    }

    /**
     * Ordenacion de campos
     * @param String $field campo por el cual va a ordenar
     * @param String $order Orden del campo, asc/desc
     */
    public function setSortname($field,$order = 'desc')
    {
        $this->sortname = $field;
        $this->sorttype = $order;
    }

    /**
     * Establece la URL de consulta
     * @param String $url url donde va a recibir la informacion
     */
    public function setUrlget($url)
    {
        $this->url_get = $url;
 
    }

    /**
     * Establece la URL de envio de informacion
     * @param String $url url donde va a enviar la informacion
     */
    public function setUrlput($url)
    {
        $this->url_put = $url;

    }

    /**
     *Devuelve la URL de donde trae la informacion
     * @return String url, url de consulta
     */
    public function getUrlget()
    {
        return $this->url_get;
    }


    /**
     *Tipo de datos de consulta
     * @param String $datatype json/xml
     *
     */
    public function setDataType($datatype = 'json')
    {
        $this->datatype = $datatype;
    }

    /**
     * Register per page
     * @param Int $rowNum registres
     */
    public function setRowNum($rowNum)
    {
        $this->rowNum = $rowNum;
    }
	
	/**
     * Register per page
     * @param Int $rowPage registres
     */
    public function setRowList($rowList)
    {
        $this->rowList = $rowList;
    }
	
	public function setRowNumbering($rowNumbering)
	{
		$this->rowNumbering = $rowNumbering;
	}
	
	public function setHiddenGrid($hiddenGrid)
	{
		$this->hiddenGrid = $hiddenGrid;
	}
	
	public function setScroll($scroll)
	{
		$this->scroll = $scroll;
	}
	
	 public function setRefresh($element)
    {
        $this->_buttons['refresh'] = "'{$element}'";
    }

    /**
     * Width table
     * @param Int $width Ancho de la pagina
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     *Height table
     * @param Int $height Height table
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Table title
     * @param String $title page title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * Generathe the HTML code
     */
    public function deploy()
    {

        /**
         * check if we must export result
         */
        $this->export();

        $html      = '';
        $loadbutton = false;
        if(false == empty($this->url_get)){
            $html .=  ",url:'{$this->url_get}/'\r\n";
            $post = (false == empty($this->url_put))?$this->url_put:$this->url_get;
            $html .=  ",editurl:'{$post}/'\r\n";
        }
   
        $html     .=  ",datatype:'{$this->datatype}'\r\n";
        $html     .=  ",rowNum:'{$this->rowNum}'\r\n";
		$html     .=  ",rowList:[$this->rowList]\r\n";
		$html     .=  ",rownumbers:$this->rowNumbering\r\n";
		$html     .=  ",hiddengrid:$this->hiddenGrid\r\n";
		$html     .=  ",scroll:$this->scroll\r\n";
		$html     .=  ",scrollrows:'true'\r\n";
		$html     .=  ",viewsortcols:'true'\r\n";
		$html     .=  ",sortable:'true'\r\n";
		//$html     .=  ",forceFit:'true'\r\n";
        if(false == empty($this->width)){
           $html  .= ",width:'$this->width'\r\n";
        }else{
            $html  .= ",autowidth:$this->autowidth\r\n";
        }
        if(false == empty($this->sortname)){
            $html .= ",sortname: '$this->sortname'\r\n";
            $html .= ",sortorder: '$this->sorttype'\r\n";
        }
        if($this->height){
            $html  .= ",height:'$this->height'\r\n";
        }
        if($this->showpager){
             $html .= ",pager: '#pnewapi{$this->_gridname}'\r\n";
        }
        if($this->title){
             $html .= ",caption:'{$this->title}'\r\n";
        }
        $querydata = array(
                           'dtgFields' => $this->_field,
                          );
        $this->CI->session->set_userdata($querydata);

        #propiedades de las ventanas
        //$html .= ",edit:{editCaption: 'xxxx'}";


         #calendario
         $calendar = "size: 10, maxlengh: 10,dataInit: function(element) { $(element).datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: '" . (date('Y',time()) - 30) .":" .(date('Y',time()) + 10) ."'})}";


       
        $html     .=  ',colModel:[' . "\r";
        $fieldname = '';
        if(false == empty($this->_field)){      


           #recorre la parametrizacion
           foreach($this->_field as $row => $value){
               //pprint_r($row);
               if($row == 'field'){
                   //if(isset($value[title))
                   //pprint_r($value);
                   #recorre c/u de los campos
                   foreach($value as $field){
                       $alias        = $field;
                       $validators   = '';
                       $params       = '';
                       $isdate       = false;
                       $editoptions  = false;
                       if(isset($this->_field['label'][$field])){
                           $alias = $this->_field['label'][$field];
                       }
                       if(isset($this->_field['validators'][$field])){
                           $validators = ',formatter:{';
                           foreach($this->_field['validators'][$field] as $param => $paramval){
                               if(empty($params)){
                                   $params = $param . ':' . $paramval . '';
                               }else{
                                   $params .=   ',' . $param . ':' . $paramval . '';
                               }
                               
                           }
                           $validators .= $params . '}';
                       }
                       $params = '';
                       $calc   = '';
                       if(isset($this->_field['params'][$field])){
                           //$alias = $this->_field['label'][$field];
                           foreach($this->_field['params'][$field] as $param => $paramval){
                               if(empty($params)){
                                   $params = ",{$param}:$paramval";
                               }else{
                                   $params .= ",{$param}:$paramval";
                               }
                               $addcal = '';
                               $calc   = '';
                               if($param == 'editrules'){
                                    #verifica si tiene un campo date
                                   if((isset($this->_field['params'][$field]['editoptions']) && strpos($params,'date:') > 0)){
                                       $pos = strpos($params,'editoptions:{');
                                       $addcal = substr($params, $pos +  13);
                                       //echo $addcal;
                                       if(false == empty($addcal)){
                                           $calc = ",editoptions: {{$calendar} $addcal,searchoptions: {{$calendar}}";
                                       }else{
                                           $calc = ",editoptions: {{$calendar}},searchoptions: {{$calendar}}";
                                       }
                                       
                                   }else{
                                           if(strpos($params,'date:') > 0){
                                               $isdate = true;
                                               if(false == empty($addcal)){
                                                  $calc = ",editoptions: {{$calendar} $addcal ,searchoptions: {{$calendar}}";
                                               }else{
                                                  $calc = ",editoptions: {{$calendar}},searchoptions: {{$calendar}}";
                                               }

                                            }
                                      }
                              }
                       }
                       
                       if(empty($fieldname)){
                           
                          $fieldname .= "{name:'{$field}',label:'{$alias}' {$params} {$validators} {$calc}}\r";
                       }else{
                          $fieldname .= ",{name:'{$field}',label:'{$alias}' {$params} {$validators} {$calc}}\r";
                       }
         
                   }
                 }
               }
               
           }
        }

        

        $html .= $fieldname . ']';         
        $this->return['table']       = $html;
        $this->return['gridname']    = $this->_gridname;
        $this->return['export']      = $this->_export;
        $this->return['querystring'] = ($this->CI->config->item('enable_query_strings') == FALSE)?'\'false\'':'\'true\'';
        
		if ($this->showsearch){
			$searchbar   = '';
            $searchbar  .= "
			jQuery(\"#newapi{$this->_gridname}\")
				.jqGrid('navButtonAdd',
				'#pnewapi{$this->_gridname}',
				{
					caption:\"{$this->get_lang['btn_search']}\",
					title:\"{$this->get_lang['txt_search']}\",
					buttonicon :'ui-icon-pin-s', 
					onClickButton:function(){ 
						jQuery(\"#newapi{$this->_gridname}\")[0].toggleToolbar() 
					} 
				}
			);
			jQuery(\"#newapi{$this->_gridname}\")
				.jqGrid('navButtonAdd',
				'#pnewapi{$this->_gridname}',
				{
					caption:\"{$this->get_lang['btn_clear']}\",
					title:\"{$this->get_lang['txt_clear']}\",
					buttonicon :'ui-icon-refresh', 
					onClickButton:function(){ 
						jQuery(\"#newapi{$this->_gridname}\")[0].clearToolbar() 
					} 
				}
			); 
			jQuery(\"#newapi{$this->_gridname}\").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false})[0].toggleToolbar()
			";
			$this->return['showsearch'] = $searchbar;
		}

		#drag and drop grid @HRIE
		if (false == empty($this->dnd)){
			$dnd   = '';
            $dnd  .= "jQuery(\"#newapi{$this->_gridname}\").jqGrid('gridDnD',{connectWith:'$this->dnd'});";
			$this->return['dnd'] = $dnd;
		}
		
        #paginador
         if($this->showpager){
            $bar   = '';
            $bar  .= "jQuery(\"#newapi{$this->_gridname}\")
                      .jqGrid('navGrid',
                              '#pnewapi{$this->_gridname}',
                              {view:{$this->_buttons['view']},
                               edit:{$this->_buttons['edit']},
                               add:{$this->_buttons['add']},
                               del:{$this->_buttons['delete']},
                               search:{$this->_buttons['search']},
							   refresh:{$this->_buttons['refresh']}
                               },
                               {closeAfterEdit:true,reloadAfterSubmit:true,mtype: 'POST'}/*edit options*/,
                               {closeAfterAdd:true,reloadAfterSubmit:true,mtype: 'POST'} /*add options*/,
                               {reloadAfterSubmit:true,mtype: 'POST'} /*delete options*/,
                               {sopt:['eq','cn','ge','le'],
                               overlay:false,mtype: 'POST'}/*search options*/
                             )";

            $key = array_search('true', $this->_export); // find if we muest show the export button;
            if($key){
                $bar  .= ".navButtonAdd('#pnewapi{$this->_gridname}',
                                           { caption:'', buttonicon:'ui-icon-extlink', onClickButton:dtgOpenExportdata, position: 'last', title:'Export data', cursor: 'pointer'}
                                          )";
                $loadbutton = true;
            }
            
            
            $bar     .= ";\r\n";
            if($loadbutton){
               $bar .= "dtgLoadButton();\r\n";
            }
  
            //$this->_buttons['excel'];
            $this->return['pager'] = $bar;
        }
        
        
        return $this->return;
        
    }

    /**
     * Show or not the pagination bar
     * @param bool $action true/false, si muestra o no la barra de paginacion
     * @return $return['pager'] codigo html de paginacion
     */
    public function showpager($action)
    {

        $this->showpager = $action;
       

    }
	
	 public function showsearch($action)
    {

        $this->showsearch = $action;
       

    }

    /**
     * Return an Array with table information:
     * Example:
     * $this->load->library('datagrid');
       $grid             = $this->datagrid;
     * Join with more than one table:
     * $grid->getData($table,
	 array(
		array(
			array(
				'table' => 'table_related', 
				'join' => 'table_related.primary_key = $table.foreignkey', 
				'fields' => 'field1,field2','type' => 'left'
			)
		),
		array(
			'table' => 'table_related2', 
			'join' => 'table_related2.primary_key = $table.foreignkey',
			direction
		)
	));//direction = Options are: left, right, outer, inner, left outer, and right outer
     * Query without relations
     * $grid->getData($table);
     * @param String $table table name
     * @param String/Array $joinmodel Join tables
     * @param Array $fields Field list to show
     * @param bool $prefix indicate si put prefix at recordset fields
     * @return Array $response
     */
    public function getData($table, $joinmodel = array(), $fields = array(), $prefix = true)
    {
        $limit      = $this->CI->input->get_post('rows');
        $limitstart = $this->CI->input->get_post('limitstart');
        $filter     = $this->CI->input->get_post('searchField');
        $filtertext = $this->CI->input->get_post('searchString');
        $oper       = $this->CI->input->get_post('searchOper');
        $sortby     = $this->CI->input->get_post('sidx');
        $sortdir    = $this->CI->input->get_post('sord');
        $page       = $this->CI->input->get_post('page');
        $fields2    = array();


        
       // if(!$sortby) $sortby =1;
        
        $response = array();
        $this->CI->db->select('count(1) as rows');
        $this->CI->db->from($table);

        if( false == empty($filter) ) {
            switch ($oper) {
                case 'cn':
                  $this->CI->db->like( $table .'.' . $filter, $filtertext );
                break;
                case 'eq':
                  $this->CI->db->where( $table .'.' . $filter , $filtertext );
                break;
                case 'ge':
                  $this->CI->db->where( "$table .{$filter} >=", $filtertext );
                break;
                 case 'le':
                  $this->CI->db->where( "$table .{$filter} <=", $filtertext );
                break;
                default:
                  $this->CI->db->like( $table .'.' . $filter, $filtertext );
                break;
            }
               
        }

        $total = $this->CI->db->get()->row();
        $count           = $total->rows;
        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
            
        } else {
            $total_pages = 0;

       }

        $response['records']  = $count;
        $response['total']    = $total_pages;
        $response['page']     = $page;
        if ($page > $total_pages){
            $page=$total_pages;
        }
        $limitstart = $limit*$page - $limit; // do not put $limit*($page - 1)
        $limitstart = ($limitstart < 0)?0:$limitstart;

		if (true == empty($joinmodel)):
			$this->CI->db->select('*');
			$this->CI->db->from($table);
		endif;
        
        if( false == empty($filter) ) {
            switch ($oper) {
                case 'cn':
                  $this->CI->db->like( $table .'.' . $filter, $filtertext );
                break;
                case 'eq':
                  $this->CI->db->where( $table .'.' . $filter , $filtertext );
                break;
                case 'ge':
                  $this->CI->db->where( "$table .{$filter} >=", $filtertext );
                break;
                 case 'le':
                  $this->CI->db->where( "$table .{$filter} <=", $filtertext );
                break;
                default:
                  $this->CI->db->like( $table .'.' . $filter, $filtertext );
                break;
            }

        }

        if( empty($sortdir) ) {
                $sortdir = 'asc';
        }

        if( !empty($sortby) ) {
                $this->CI->db->order_by( $sortby, $sortdir );
        }

        if( !isset($limitstart) || $limitstart == '' ) {
                $limitstart = 0;
        }

        if( isset($limitstart) && !empty($limit) ) {
               $this->CI->db->limit( $limit, $limitstart );
        }
        
        if(false == empty($joinmodel)){
            if(is_array($joinmodel)){                
                foreach($joinmodel as $model){
                    if(isset($model['table']) && isset($model['join'])){
					
                       $this->CI->db->join($model['table']/*tablename*/, $model['join']/*join fields*/, (isset($model['type']))?$model['type']:'inner'/*join type*/);
					   
                       if(isset($model['fields']) && false == empty($model['fields']) && $prefix){
                            foreach($model['fields'] as $field){
                                $fields2[] = "{$model['table']}.{$field} AS {$model['table']}_{$field}";
                            }                       
                        }else{
                            if(isset($model['fields']) && false == empty($model['fields'])){
                               foreach($model['fields'] as $field){
                                    $fields2[] = "{$model['table']}.{$field}";
                               } 
                            }
                        }
                       
                    }
                
                }

            }
            
            if(empty($fields) && $prefix){
                $fieldstable = $this->CI->db->list_fields($table);
                foreach($fieldstable as $field){                    
                    //$fields = array_push((array)$fields, (array)"{$field} AS {$table}_{$field}" );
                    $fields[] = "{$table}.{$field} AS {$table}_{$field}";
                }
            }else{
                if(empty($fields)){
                    $fieldstable = $this->CI->db->list_fields($table);
                    foreach($fieldstable as $field){
                        //$fields = array_push((array)$fields, (array)"{$field} AS {$table}_{$field}" );
                        $fields[] = "{$table}.{$field}";
                    }
                }                
            }

            $fields = array_merge($fields, $fields2);

            $this->CI->db->select($fields);
            $this->CI->db->from($table);
            $rs = $this->CI->db->get()->result_array();


        }else{
            $rs = $this->CI->db->get()->result_array();
        }
        //echo $this->CI->db->last_query();
       // $queryString = $this->CI->db->last_query();

        $querydata = array(
                           'dtgQuery'  => $this->CI->db->last_query(),
                          );
        $this->CI->session->set_userdata($querydata);

        $response['data'] = $rs;
        return $response;
    }

    /**
     * Execute CRUD process
     * @param String $table table name
     * @param String $key primary key
     * @return void
     */
    public function operations($table,$key = 'id')
    {

        $oper   = $this->CI->input->post('oper');
        //$oper   = $data['oper'];
        if($oper == 'add'){
            $data = $_POST;
            unset($data[$key]);
            unset($data['oper']);
            if(false == empty($data)){
                $this->CI->db->insert($table, $data);
            }

           echo '';
            return;

        }elseif($oper == 'edit'){
			
            $id   = $this->CI->input->post($key);
            $data = $_POST;
            unset($data['oper']);
            unset($data[$key]);
            $this->CI->db->where($key, $id);
            $this->CI->db->update($table, $data);
			
			//$this->CI->db->where('satuan_id',6);
			//$this->CI->db->update($table, array('satuan_nama'=>'wew'));
            return;

        }elseif($oper == 'del'){
            $id   = $this->CI->input->post($key);
            $this->CI->db->where($key, $id);
            $this->CI->db->delete($table);
            echo '';
            return;

        }
    }

    /**
     * Return data like json
     * @param Array $result
     * @return object json
     */
    public function jsonresult($result)
    {
        return json_encode($result);
    }


    /**
    * Convert result to valid json
    * @param json $json
    */
    function jqgridSelect($json)
    {
        $selectval = str_replace("[", '', $json);
        $selectval = str_replace("]", '', $selectval);
        $selectval = str_replace("{", '', $selectval);
        $selectval = str_replace("}", '', $selectval);
        $selectval = str_replace('"', '', $selectval);
        $selectval = str_replace(",", ';', $selectval);

        return $selectval;
    }


    /**
     * Export data to pdf or csv
     * @param String $type pdf/csv
     * @return <type> 
     */
    function export()
    {

       $queryString = $this->CI->config->item('enable_query_strings');
       if($queryString === false){
         $arrFormat = $this->CI->uri->uri_to_assoc();
         if(isset ($arrFormat['_exportto'])){
            $format = $arrFormat['_exportto'];
         }else{
             return false;
         }
       }else{
           $format = $this->CI->input->get('_exportto', TRUE);
           if(empty($format)){
              return false;
           }
       }
       $query  = $this->CI->session->userdata('dtgQuery');
       $fields = $this->CI->session->userdata('dtgFields');
       $sql    = $this->_cleanExportSql($query, $fields);

       if($format == 'csv'){
           $this->CI->load->dbutil();
           $query = $this->CI->db->query($sql);
           $delimiter = ",";
           $newline = "\r\n";
           header ("Content-disposition: attachment; filename=csvoutput_". time(). ".csv") ;
           echo $this->CI->dbutil->csv_from_result($query,$delimiter, $newline);
           exit;
       }elseif($format == 'xml'){
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
       }elseif($format == 'pdf'){
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
       }
       //echo "== {$query} ==";

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
    private function _cleanExportSql($sql, $fields)
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


/* End of file datagrid.php */
/* Location: ./system/application/libraries/Datagrid.php */