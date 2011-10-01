<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Generacion del archivo en formato pdf
 * @param String $html HTML a generar
 * @param String $filename Nombre de archivo
 * @param BOOL $stream Generar al vuelo o no
 * @param String $orientation Orientacion del archivo portrait/landscape
 */
function pdf_create($html, $filename, $stream=TRUE, $orientation = 'portrait')
{
    require_once("dompdf/dompdf_config.inc.php");
    set_time_limit(0);
    ini_set('memory_limit','512M');
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('letter', $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        $CI =& get_instance();
        $CI->load->helper('file');
        write_file("./temp/pdf_$filename.pdf", $dompdf->output());
    }
}

/**
 *devuelve el html
 * @param recordset $query Recordset a convertir a tabla html
 * @param array $exclude nombre de los campos a excluir en el proceso
 * @return string $html html generado
 */
function html_prepare($query,$exclude = array())
{
    
    $html    = '';
    $headers = ''; // just creating the var for field headers to append to below
    $data    = ''; // just creating the var for field data to append to below
    $obj     = & get_instance();
    $fields  = $query->field_data();
    if ($query->num_rows() == 0) {
          return '<p>Sin datos.</p>';
     } else {
         $html    .= '<table widht="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
         $html    .= '<thead>';
         $headers .= '<th  style="border:1px solid #000">&nbsp;</th>';

         #encabezados

         foreach ($fields as $field) {

             if(!in_array($field->name, $exclude)){#no esta dentro de los exluidos
                
                $headers .= '<th  style="border:1px solid #000">' . $field->name .'</th>';
             }
  
          }
           $html  .= "<tr>{$headers}</tr>";
          
         $html  .= '</thead>';

         #contenido
         $fila = 1;
         foreach ($query->result() as $row) {
               $line = '';
               //pprint_r($row );
               foreach($row as $index => $value) {
                   if(!in_array($index, $exclude)){#no esta dentro de los exluidos
                        if ((!isset($value)) OR ($value === '')) {
                             $value = "<td>&nbsp;</td>";
                        } else {
//                              if($index == 'Estado'){
//                                  $value = '<td style="border:1px solid #000" valign="top">' . mb_strtoupper( $value, "utf-8") . '</td>';
//                              }else{
//                                 $value = '<td style="border:1px solid #000" valign="top">' . $value .'</td>';
//                              }
                              $value = '<td style="border:1px solid #000" valign="top">' . mb_strtoupper( $value, "utf-8") . '</td>';
                            //$value = mb_convert_encoding($value, "iso-8859-2", "utf8");
                            //$value = utf8_encode($value);
                            //$value = '<td style="border:1px solid #000" valign="top">' . $value .'</td>';
                             
                        }
                        
                        $line .=  $value;
                   }
               }
               $counter = "<td  style='border:1px solid #000' valign='top'>{$fila}</td>";
               $data .= '<tr>' . $counter . trim($line)."</tr>";
               $fila++;
              
          }
         $html  .= $data;
         $html  .= '</table>';
     }

    return $html;
}
