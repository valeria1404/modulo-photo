<?php
/*  
 *   Programmed by: Carlos E. Contreras Vara
 *                  carlosecv74@hotmail.com
 * 
 *   Based on JPEG Cam:
 *    
 *    http://code.google.com/p/jpegcam/
 *    MIT License
 *       
 * 
 */ 
include('./lib/xmlrpc.inc'); // Use phpxmlrpc library, available on sourceforge

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
setlocale(LC_ALL, 'es_ES');

foreach (glob(dirname(__FILE__) . DIRECTORY_SEPARATOR . "*.jpg") as $filename) {
  //  echo "$filename size " . filesize($filename) . "\n";
    unlink($filename);
}
$fecha=date('D_F_h_i_s_a');
$filename = $fecha . '.jpg';
//echo $filename;
$tnombre=date("l_F_j_Y_g_i_a");
$search  = array('January','February','March','April', 'May','June','July','August', 'September', 'October', 'November', 'December');
$replace = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$nombre=str_replace($search, $replace, $tnombre);
$tnombre=$nombre;
$search  = array('Monday', 'Tuesday', 'Wednesday', 'November', 'Friday','Saturday','Thursday','Sunday');
$replace = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes','Sabado','Domingo');
$filenamesinjpg=str_replace($search, $replace, $tnombre);
$filename=str_replace($search, $replace, $tnombre) . ".jpg";



$result = file_put_contents( dirname(__FILE__) . DIRECTORY_SEPARATOR . $filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Fallo al escribir los datos a $filename, checar permisos\n" . dirname(__FILE__) ;
	exit();
}

// ... define $HOST, $PORT, $DB, $USER, $PASS

$HOST="127.0.0.1"; 
$PORT="8069"; 
$DB="photos"; 
$USER="admin";
$PASS="demo";

//echo $fecha;

$client = new xmlrpc_client("http://$HOST:$PORT/xmlrpc/common");

$msg = new xmlrpcmsg("login");
$msg->addParam(new xmlrpcval($DB, "string"));
$msg->addParam(new xmlrpcval($USER, "string"));
$msg->addParam(new xmlrpcval($PASS, "string"));

$resp = $client->send($msg);
if ($resp->faultCode()){
        echo 'ERROR: Verifique el acceso al servidor de fotos ' . $filename;
        exit;
}
$uid = $resp->value()->scalarval();

//echo "Logged in as $USER (uid:$uid)";

$client = new xmlrpc_client("http://$HOST:$PORT/xmlrpc/object");


//echo "Aqui va....";

  $handle = fopen(dirname(__FILE__) . DIRECTORY_SEPARATOR . $filename,'r');
  $file_content = fread($handle,filesize($filename)); //read uploaded file
  fclose($handle);
  $encoded = chunk_split(base64_encode($file_content)); //encode it

$tnombre=date("l F j, Y, g:i a");
$search  = array('January','February','March','April', 'May','June','July','August', 'September', 'October', 'November', 'December');
$replace = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$nombre=str_replace($search, $replace, $tnombre);
$tnombre=$nombre;
$search  = array('Monday', 'Tuesday', 'Wednesday', 'November', 'Friday','Saturday','Thursday','Sunday');
$replace = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes','Sabado','Domingo');
$nombre=str_replace($search, $replace, $tnombre);


date_default_timezone_set('UTC');



$arrayVal = array(
'name'=>new xmlrpcval("Seguridad_$nombre", "string"),
'photo'=>new xmlrpcval($encoded, "string"),
'date'=>new xmlrpcval(date('Y-M-d h:i:s a'), "string"),
);

$msg = new xmlrpcmsg("execute");
$msg->addParam(new xmlrpcval("$DB", "string"));
$msg->addParam(new xmlrpcval("$uid", "int"));
$msg->addParam(new xmlrpcval("$PASS", "string"));
$msg->addParam(new xmlrpcval("photo.security", "string"));
$msg->addParam(new xmlrpcval("create", "string"));
$msg->addParam(new xmlrpcval($arrayVal, "struct"));

//echo "Enviando al openerp....";

$resp = $client->send($msg);
//echo "Enviado resp...";

if ($resp->faultCode())
        echo 'ERROR: '.$resp->faultString();
/*    else
        echo 'Foto: '.$resp->value()->scalarval().' creada';
*/
$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filenamesinjpg;
print "$url\n";

?>

