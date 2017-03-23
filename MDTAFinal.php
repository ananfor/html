<?php
$horaIni = microtime(true);
/* -------------------- FUNCIONES UTILIZADAS :  -------------------- */

/*  -Función para obtener tan solo la ultima palabra clave del string frase de palabra clave de cada tesauro  */

function only1($arg1){   
    $Vali = 0;
    while ($Vali <= count($arg1)){
        $pos[$Vali] = strrpos($arg1[$Vali][0], ".",-3);
        if ($pos[$Vali]!== false){$arg1[$Vali][0] = substr($arg1[$Vali][0],$pos[$Vali]+1);}
        $Vali++;}   
return $arg1;}

/* VARIABLES CON VALOR ASOCIADO UTILIZADAS SIN NCESIDAD DE BUCLE (para que no se redeclaren en cada iteración) */

$AnexoI=array("Parcelas catastrales", "Direcciones", "Redes de transporte", "Sistema de cuadrículas geográficas", "Hidrografía", "Sistemas de coordenadas de referencia", "Unidades administrativas", "Lugares protegidos", "Nombres geográficos", "Addresses", "Hydrography", "Administrative units", "Cadastral parcels", "Coordinate reference systems", "Protected sites", "Geographical grid systems", "Geographical names", "Transport networks");
 
$AnexoII=array("Cubierta terrestre", "Elevaciones", "Geología", "Ortoimágenes", "Land cover", "Orthoimagery", "Elevation", "Geology");

$AnexoIII=array("Aspectos geográficos de carácter meteorológico", "Condiciones atmosféricas", "Rasgos geográficos oceanográficos", "Recursos energéticos", "Recursos minerales", "Distribución de la población — demografía", "Distribución de las especies", "Regiones biogeográficas", "Edificios", "Regiones marinas", "Salud y seguridad humanas", "Servicios de utilidad pública y estatales", "Hábitats y biotopos", "Instalaciones agrícolas y de acuicultura", "Suelo", "Instalaciones de observación del medio ambiente", "Instalaciones de producción e industriales", "Unidades estadísticas", "Uso del suelo", "Zonas de riesgos naturales", "Zonas sujetas a ordenación, a restricciones o reglamentaciones y unidades de notificación", "Agricultural and aquaculture facilities", "Land use", "Area management/restriction/regulation zones and reporting units", "Meteorological geographical features", "Atmospheric conditions", "Mineral resources", "Bio-geographical regions", "Natural risk zones", "Buildings", "Oceanographic geographical features", "Population distribution — demography", "Production and industrial facilities", "Energy resources", "Environmental monitoring facilities", "Sea regions", "Soil", "Species distribution", "Statistical units", "Habitats and biotopes", "Human health and safety", "Utility and governmental services");

/* --------------------------------__ 'INICIO 2' DEL PROGRAMA __-------------------------------- */

        /* Directorio donde se encuentran los metadatos dato */
//$directorio = ('C:/Users/D53760969X/Desktop/ICV_ANTON/MD_MedioAmbiente/Trabajados/Resto');
//$directorio = ('C:/Users/D53760969X/Desktop/ICV_ANTON/MD_MedioAmbiente/Trabajados/CAZA_Y_PESCA');
$directorio = ('C:/Users/D53760969X/Desktop/ICV_ANTON/MD_MedioAmbiente/Trabajados/ESPACIOS PROTEGIDOS');
//$directorio = ('C:/Users/D53760969X/Desktop/ICV_ANTON/MD_MedioAmbiente/Iniciales_por_procesar');

        /* Escaneamos el directorio obteniendo el nombre de todos los ficheros y su cantidad */
$ficheros1 = scandir($directorio); //devuelve array con todos los ficheros del directorio y carpetas '.' y '..'
$ficheros1 = array_diff($ficheros1,array('.','..')); //quizas innecesario por que abajo i=2.
$cantidad = count($ficheros1);//Obtenemos la cantidad de ficheros a cargar, deben de haber solo XML.

/* --------------------------------------------------------------------------------------------- */

/* INICIO DEL BUCLE PRINCIPAL, ITERA SOBRE CADA ARCHIVO (para efectuar las mismas ordenes sobre todos los archivos) */
$i = 2;
while($i <= $cantidad+1){
unset($carga);
        $carga = simplexml_load_file($directorio.'/'.$ficheros1[$i]);

/* CONVERSIÓN de SimpleXML a DOMDocument (Tambien existe la conversión inversa) y a array , para poder extraer cualquier información de algun modo*/

$doc = new DOMDocument();
$doc = dom_import_simplexml($carga);

unset($arrayXML,$json);
$json = json_encode($carga);
$arrayXML = json_decode($json,TRUE);

/*acceder a las rutas XML que nos interesan (XPATH) y realizar modificaciones de ser necesario*/

        $identificador = substr("spa_icv_$ficheros1[$i]",0,-4); //Para quitar extension ".xml" del identificador.

        $nvlJerarquico = $carga->xpath('/MD_Metadata/identificationInfo/dataQualityInfo/DQ_DataQuality/scope/DQ_Scope/level');
        if ((string)$nvlJerarquico[0] = 'Conjunto de datos'){$nvlJerarquico = 'dataset';}
        else {$nvlJerarquico = (string)$nvlJerarquico[0];}

/*Fijo*/$nombreOrgMD = 'Institut Cartogràfic Valencià';
/*Fijo*/$direccionCorreoMD = 'responde_icv@gva.es';
/*Auto*/$fechaMD = date('d/m/Y'); //Fecha actual
        $fechaMD2 = $arrayXML[dateStamp];
        //$fechaMD2 = (string)$fechaMD2;
        $titulo = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/citation/CI_Citation/title');
        $titulo = (string)$titulo[0]; 

        $tituloAlte = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/citation/CI_Citation/alternateTitle');
        $tituloAlte = (string)$tituloAlte[0];
print_r('----------------'.$ficheros1[$i].'----------------');

unset($pp,$pc,$p,$NaMe,$vAlUe);
    $pp=0;


/*while($pp < $doc->getElementsByTagName('CI_Date')->length){$pc[]=$pp;$pp++;}
    foreach($carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/citation/CI_Citation/date/CI_Date') as $node){
    foreach($node as $node1){
        $key =$node1->nodeName;
        $val =$node1->nodeValue;
        $FECHA2[$key] = $val;}}
print_r($FECHA2);*/
    
    /* FECHAS DEL RECURSO (Creación, Publicación o Revisión) */
    
unset($cData1,$cData2,$pp,$FCrea,$FTypeCrea,$FPubli,$FTypePubli,$FRev,$FTypeRev,$Fecha01,$FeTyp01,$Fecha02,$FeTyp02,$Fecha03,$FeTyp03);
    
//$pp = 0;
//$cData1 = count($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation]['date']);
//$cData2 = count($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation]['date'][CI_Date]);
  //print_r($cData2);
    
if(empty($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][2][CI_Date]) != TRUE){
    $Fecha01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][0][CI_Date][date];
    $FeTyp01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][0][CI_Date][dateType];
    $Fecha02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][1][CI_Date][date];
    $FeTyp02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][1][CI_Date][dateType];
    $Fecha03 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][2][CI_Date][date];
    $FeTyp03 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][2][CI_Date][dateType];}
      
elseif(empty($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][1][CI_Date]) != TRUE){
    $Fecha01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][0][CI_Date][date];
    $FeTyp01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][0][CI_Date][dateType];
    $Fecha02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][1][CI_Date][date];
    $FeTyp02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][1][CI_Date][dateType];}
    
elseif(empty($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][0][CI_Date]) != TRUE){
    $Fecha01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][0][CI_Date][date];
    $FeTyp01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][0][CI_Date][dateType];}
    
elseif(empty($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][2]) != TRUE){
    $Fecha01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][0][date];
    $FeTyp01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][0][dateType];
    $Fecha02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][1][date];
    $FeTyp02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][1][dateType];
    $Fecha03 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][2][date];
    $FeTyp03 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][2][dateType];}
      
elseif(empty($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][1]) != TRUE){
    $Fecha01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][0][date];
    $FeTyp01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][0][dateType];
    $Fecha02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][1][date];
    $FeTyp02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][1][dateType];}
    
elseif(empty($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][0]) != TRUE){
    $Fecha01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][0][date];
    $FeTyp01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][0][dateType];}
 else{
    $Fecha01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date];
    $FeTyp01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][dateType];}   
    
    
    
    
/*elseif(empty($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date][2]) != TRUE){
    $Fecha01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date][0];
    $FeTyp01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][dateType][0];
    $Fecha02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date][1];
    $FeTyp02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][dateType][1];
    $Fecha03 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date][2];
    $FeTyp03 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][dateType][2];}
      
elseif(empty($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date][1]) != TRUE){
    $Fecha01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date][0];
    $FeTyp01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][dateType][0];
    $Fecha02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date][1];
    $FeTyp02 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][dateType][1];}
    
elseif(empty($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date][0]) != TRUE){
    $Fecha01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date][0];
    $FeTyp01 = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][dateType][0];}*/
    
/*if($cData1 > 1){  //caso1 -> varios 'date', uno para cada tipo de fecha
    while($pp < $cData1){
        if($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][$pp][CI_Date][dateType] == 'Creación'){$FCrea = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][$pp][CI_Date][date];$FTypeCrea = 'Creation';}
        if($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][$pp][CI_Date][dateType] == 'Publicación'){$FPubli = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][$pp][CI_Date][date];$FTypePubli = 'Publication';}
        if($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][$pp][CI_Date][dateType] == 'Revisión'){$FRev = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][$pp][CI_Date][date];$FTypeRev = 'Revison';}
        $pp++;}
;}elseif($cData2 > 1){ //caso2 -> varios 'CI_Date', uno para cada tipo de fecha
    unset($pp);
    $pp=0;
    while($pp < $cData1){
        if($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][$pp][dateType] == 'Creación'){$FCrea = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][$pp][date];$FTypeCrea = 'Creation';}
        if($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][$pp][dateType] == 'Publicación'){$FPubli = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][$pp][date];$FTypePubli = 'Publication';}
        if($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][$pp][dateType] == 'Revisión'){$FRev = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][$pp][date];$FTypeRev = 'Revison';}
        $pp++;}
    
;}else{ //caso3 -> unica fecha 

        if($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][dateType] == 'Creación'){$FCrea = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date];$FTypeCrea = 'Creation';}
        if($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][dateType] == 'Publicación'){$FPubli = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date];$FTypePubli = 'Publication';}
        if($arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][dateType] == 'Revisión'){$FRev = $arrayXML[identificationInfo][MD_DataIdentification][citation][CI_Citation][date][CI_Date][date];$FTypeRev = 'Revison';}
        
;}*/

    
/* TEMPORAL EXTENT DEL DATO (rango)  */
    
    
unset($tempIni,$tempFini,$tempExtent);
        $tempIni = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/extent/EX_Extent/temporalElement/EX_TemporalExtent/extent/TimePeriod/begin/TimeInstant/timePosition');
$tempIni = (string)$tempIni[0];
        $tempFini = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/extent/EX_Extent/temporalElement/EX_TemporalExtent/extent/TimePeriod/end/TimeInstant/timePosition');
$tempFini = (string)$tempFini[0];

if(empty($tempIni) == true){$tempExtent = 'ultima fecha conocida: '.$fecha;}//*****
elseif($tempIni == $tempFini){$tempExtent = $tempIni;}
elseif($tempIni !== $tempFini){$tempExtent =  $tempIni.'/'.$tempFini;}
else{$tempExtent = 'ERROR DESCONOCIDO';}//*****



        $codigo = substr("$ficheros1[$i]",0,-4); //Para quitar extension ".xml" del código.
/*Fijo*///$codigoSitio = ('http://cartoweb.cma.gva.es/');//NO ESTA CLARO, no aparece en los datos 'XML' y hay que fijar algo.
    
        $formPresentacion = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/citation/CI_Citation/presentationForm');
        if ((string)$formPresentacion[0] == 'Mapa Digital'){$formPresentacion = 'mapDigital';}
        else {$formPresentacion = (string)$formPresentacion[0];}

        $resumen = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/abstract');
        $resumen = (string)$resumen[0];

        $proposito = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/purpose');
        $proposito = (string)$proposito[0];
        $credito = ''/*poner al owner, mas abajo*/;

/* PUNTOS DE CONTACTO */
        
unset($PoC, $pp, $POC, $pc, $NaMe, $vAlUe, $contactInfo, $va, $ind, $glob, $Cva, $NomsIndi, $CNomsI, $va2, $ind2, $NomsIndi2,$Cpoc,$ccpoc,$cci);
/* obtenemos la información*/
$pp=0;
while($pp < $doc->getElementsByTagName('CI_ResponsibleParty')->length){$pc[]=$pp;$pp++;}
    foreach($pc as $js){
        foreach($doc->getElementsByTagName('CI_ResponsibleParty')->item($js)->childNodes as $p){
        //$NaMe[] = $p->nodeName;
        //$vAlUe[] = $p->nodeValue;
        $NaMe = $p->nodeName;
        $vAlUe[$NaMe] = $p->nodeValue;
        $contactInfo = array_values(array_filter(array_map(trim,(preg_split("/[\n]+/",(string)$vAlUe[contactInfo])))));
        $cci = count($contactInfo);
        $contactInfo[codigoSitio] = $contactInfo[$cci-1];
        unset($contactInfo[$cci-1]);
        unset($vAlUe['#text']);
        $PoC[$js]= array_merge($vAlUe,$contactInfo);
        unset($PoC[$js][contactInfo]);
        ;}
    if(strpos($PoC[$js][organisationName],'VAERSA')!== FALSE){$va[] = $js;}
    if(empty($PoC[$js][individualName])== FALSE){$ind[] = $js;}
    if(empty($PoC[$js][individualName])== TRUE){$glob[] = $js;}
;}
/* la procesamos, la arrglamos y cambiamos algunos valores de las claves numericas por palabras */
if(empty($va) != TRUE){
$Cva = count($va);
foreach($ind as $ind2){
    foreach($va as $va2){
                 if($va2 == $ind2){$NomsIndi[] = $PoC[$va2][individualName];
                                   $CNomsI = count($NomsIndi);
                                   $NomsIndi2 = implode(', ',$NomsIndi);
                                   if($CNomsI>1){unset($PoC[$va2]);
                                    //$NomsIndi2 = implode(', ',$NomsIndi);
                                    $PoC[$va2-1][individualName] = $NomsIndi2;}}
                        ;}
                      ;}
$PoC = array_values($PoC);
foreach($glob as $glob2){
    foreach($va as $va2){
        if($va2 == $glob2 && $CNomsI=1){unset($PoC[$va2]);}
                        ;}
                      ;}
}

$PoC = array_values($PoC);
$Cpoc = count($PoC);
unset($pp);
$pp=0;
if(empty($PoC[$Cpoc-1][individualName]) == FALSE){
    while($pp<$Cpoc-1){
if($PoC[$pp][organisationName] == $PoC[$Cpoc-1][organisationName]){/*$PoC[$pp][individualName] = $PoC[$Cpoc-1][individualName];*/unset($PoC[$Cpoc-1]);}
        $pp++;}  
    ;}  //Mezcla la ultima aparición de una organización (con nombre individual del creador de los metadatos) con su anterior aparición que no llevaba nombre individual para obtenerlo. INECESARIO, solo borrar la ultima aparición.

$PoC = array_values($PoC);
unset($pp,$meil,$pp1);
$pp=0;
$pp1=0;
while($pp < count($PoC)){
   
    if(strpos($PoC[$pp][4],'@') !== FALSE){
    $PoC[$pp][email] = $PoC[$pp][4];
    unset($PoC[$pp][4]);
     ;}   
    if(strpos($PoC[$pp][3],'@') !== FALSE){
    $PoC[$pp][email] = $PoC[$pp][3];
    unset($PoC[$pp][3]);
     ;}       
    if(strpos($PoC[$pp][5],'@') !== FALSE){
    $PoC[$pp][email] = $PoC[$pp][5];
    unset($PoC[$pp][5]);
     ;}
    if(strpos($PoC[$pp][6],'@') !== FALSE){
    $PoC[$pp][email] = $PoC[$pp][6];
    unset($PoC[$pp][6]);
     ;}
    
    if(strpos($PoC[$pp][0],'C/' ) !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][0];
    unset($PoC[$pp][0]);
     ;}   
    if(strpos($PoC[$pp][1],'C/') !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][1];
    unset($PoC[$pp][1]);
     ;}      
    if(strpos($PoC[$pp][2],'C/') !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}
    if(strpos($PoC[$pp][0],'c/' ) !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][0];
    unset($PoC[$pp][0]);
     ;}   
    if(strpos($PoC[$pp][1],'c/') !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][1];
    unset($PoC[$pp][1]);
     ;}   
    if(strpos($PoC[$pp][2],'c/') !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}
    if(strpos($PoC[$pp][0],'Plaza' ) !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][0];
    unset($PoC[$pp][0]);
     ;}   
    if(strpos($PoC[$pp][1],'Plaza') !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][1];
    unset($PoC[$pp][1]);
     ;}   
    if(strpos($PoC[$pp][2],'Plaza') !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}
    if(strpos($PoC[$pp][0],'place' ) !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][0];
    unset($PoC[$pp][0]);
     ;}   
    if(strpos($PoC[$pp][1],'place') !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][1];
    unset($PoC[$pp][1]);
     ;}   
    if(strpos($PoC[$pp][2],'place') !== FALSE){
    $PoC[$pp][direccion] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}
    
    if(strpos($PoC[$pp][3],'España' ) !== FALSE){
    $PoC[$pp][País] = $PoC[$pp][3];
    unset($PoC[$pp][3]);
     ;}   
    if(strpos($PoC[$pp][4],'España') !== FALSE){
    $PoC[$pp][País] = $PoC[$pp][4];
    unset($PoC[$pp][4]);
     ;} 
    if(strpos($PoC[$pp][5],'España') !== FALSE){
    $PoC[$pp][País] = $PoC[$pp][5];
    unset($PoC[$pp][5]);
     ;}
    
    if(strpos($PoC[$pp][3],'Francia' ) !== FALSE){
    $PoC[$pp][País] = $PoC[$pp][3];
    unset($PoC[$pp][3]);
     ;}   
    if(strpos($PoC[$pp][4],'Francia') !== FALSE){
    $PoC[$pp][País] = $PoC[$pp][4];
    unset($PoC[$pp][4]);
     ;}   
    if(strpos($PoC[$pp][5],'Francia') !== FALSE){
    $PoC[$pp][País] = $PoC[$pp][5];
    unset($PoC[$pp][5]);
     ;}
    
    if(strpos($PoC[$pp][2],'46' ) !== FALSE){ 
    if(strlen($PoC[$pp][2]) == '5'){
    $PoC[$pp][CP] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}}   
    if(strpos($PoC[$pp][4],'46') !== FALSE){
    if(strlen($PoC[$pp][4]) == '5'){
    $PoC[$pp][CP] = $PoC[$pp][4];
    unset($PoC[$pp][4]);
     ;}}   
    if(strpos($PoC[$pp][3],'46') !== FALSE){
    if(strlen($PoC[$pp][3]) == '5'){
    $PoC[$pp][CP] = $PoC[$pp][3];
    unset($PoC[$pp][3]);
     ;}}
    if(strpos($PoC[$pp][2],'28' ) !== FALSE){ 
    if(strlen($PoC[$pp][2]) == '5'){
    $PoC[$pp][CP] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}}   
    if(strpos($PoC[$pp][4],'28') !== FALSE){
    if(strlen($PoC[$pp][4]) == '5'){
    $PoC[$pp][CP] = $PoC[$pp][4];
    unset($PoC[$pp][4]);
     ;}}   
    if(strpos($PoC[$pp][3],'28') !== FALSE){
    if(strlen($PoC[$pp][3]) == '5'){
    $PoC[$pp][CP] = $PoC[$pp][3];
    unset($PoC[$pp][3]);
     ;}}
    if(strpos($PoC[$pp][2],'75') !== FALSE){
    if(strlen($PoC[$pp][2]) == '5'){
    $PoC[$pp][CP] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}}
    if(strpos($PoC[$pp][3],'75') !== FALSE){
    if(strlen($PoC[$pp][3]) == '5'){
    $PoC[$pp][CP] = $PoC[$pp][3];
    unset($PoC[$pp][3]);
     ;}}
    if(strpos($PoC[$pp][4],'75') !== FALSE){
    if(strlen($PoC[$pp][4]) == '5'){
    $PoC[$pp][CP] = $PoC[$pp][4];
    unset($PoC[$pp][4]);
     ;}}
    
    if(strpos($PoC[$pp][2],'Valencia' ) !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}   
    if(strpos($PoC[$pp][0],'Valencia') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][0];
    unset($PoC[$pp][0]);
     ;}   
    if(strpos($PoC[$pp][1],'Valencia') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][1];
    unset($PoC[$pp][1]);
     ;}
    if(strpos($PoC[$pp][3],'Valencia') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][3];
    unset($PoC[$pp][3]);
     ;}
    if(strpos($PoC[$pp][2],'Paterna' ) !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}   
    if(strpos($PoC[$pp][0],'Paterna') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][0];
    unset($PoC[$pp][0]);
     ;}   
    if(strpos($PoC[$pp][1],'Paterna') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][1];
    unset($PoC[$pp][1]);
     ;}
    if(strpos($PoC[$pp][3],'Paterna') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][3];
    unset($PoC[$pp][3]);
     ;}
    if(strpos($PoC[$pp][2],'Madrid' ) !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}   
    if(strpos($PoC[$pp][0],'Madrid') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][0];
    unset($PoC[$pp][0]);
     ;}   
    if(strpos($PoC[$pp][1],'Madrid') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][1];
    unset($PoC[$pp][1]);
     ;}
    if(strpos($PoC[$pp][3],'Madrid') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][3];
    unset($PoC[$pp][3]);
     ;}
    
    if(strpos($PoC[$pp][2],'París' ) !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][2];
    unset($PoC[$pp][2]);
     ;}   
    if(strpos($PoC[$pp][0],'París') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][0];
    unset($PoC[$pp][0]);
     ;}   
    if(strpos($PoC[$pp][1],'París') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][1];
    unset($PoC[$pp][1]);
     ;}
    if(strpos($PoC[$pp][3],'París') !== FALSE){
    $PoC[$pp][Poblacion] = $PoC[$pp][3];
    unset($PoC[$pp][3]);
     ;}
   
    $pp++;}

unset($pp,$CustRol,$CustName,$CustCode,$CustMail,$CustPobla,$OwnerRol,$OwnerName,$OwnerCode,$OwnerMail,$OwnerPobla,$CreaRol,$CreaName,$CreaCode,$CreaMail,$CreaPobla);
//print_r($PoC);


$pp=0;
while($pp < count($PoC)){
    
if ($PoC[$pp][role] == 'Conservador'){$CustRol = 'custodian';
                                      $CustName = $PoC[$pp][organisationName];
                                      $CustCode = $PoC[$pp][codigoSitio];
                                      $CustIname = $PoC[$pp][individualName];
                                      $CustCode = $PoC[$pp][codigoSitio];
                                      $CustDir = $PoC[$pp][direccion];
                                      $CustPostalC = $PoC[$pp][CP];
                                      $CustPais = $PoC[$pp][País];
                                      $CustPobla = $PoC[$pp][Poblacion];
                                      if(empty($PoC[$pp][email]) == FALSE){
                                          $CustMail = $PoC[$pp][email];}else{
                                          $CustMail = $direccionCorreoMD;};}
    
if ($PoC[$pp][role] == 'Propietario'){$OwnerRol = 'owner';
                                      $OwnerName = $PoC[$pp][organisationName];
                                      $OwnerCode = $PoC[$pp][codigoSitio];
                                      $OwnerIname = $PoC[$pp][individualName];
                                      $OwnerCode = $PoC[$pp][codigoSitio];
                                      $OwnerDir = $PoC[$pp][direccion];
                                      $OwnerPostalC = $PoC[$pp][CP];
                                      $OwnerPais = $PoC[$pp][País];
                                      $OwnerPobla = $PoC[$pp][Poblacion];
                                      if(empty($PoC[$pp][email]) == FALSE){
                                          $OwnerMail = $PoC[$pp][email];}else{
                                          $OwnerMail = $direccionCorreoMD;};}
    
if ($PoC[$pp][role] == 'Creador'){$CreaRol = 'originator';
                                  $CreaName = $PoC[$pp][organisationName];
                                  $CreaCode = $PoC[$pp][codigoSitio];
                                  $CreaIname = $PoC[$pp][individualName];
                                  $CreaCode = $PoC[$pp][codigoSitio];
                                  $CreaDir = $PoC[$pp][direccion];
                                  $CreaPostalC = $PoC[$pp][CP];
                                  $CreaPais = $PoC[$pp][País];
                                  $CreaPobla = $PoC[$pp][Poblacion];
                                  if(empty($PoC[$pp][email]) == FALSE){
                                      $CreaMail = $PoC[$pp][email];}else{
                                      $CreaMail = $direccionCorreoMD;};}
$pp++;} 
    
    
    
    
    
/*foreach($PoC as $cuak){
    
if ($cuak[role] = 'Conservador'){$CustRol = 'custodian';$CustName = $cuak[organisationName];$CustCode = $cuak[codigoSitio];if(empty($cuak[email]) == FALSE){$CustMail = $cuak[email];}else{$CustMail = $direccionCorreoMD;};$CustIname = $cuak[individualName];}
    
if ($cuak[role] = 'Propietario'){$OwnerRol = 'owner';$OwnerName = $cuak[organisationName];$OwnerCode = $cuak[codigoSitio];if(empty($cuak[email]) == FALSE){$OwnerMail = $cuak[email];}else{$OwnerMail = $direccionCorreoMD;};$OwnerIname = $cuak[individualName];}
    
if ($cuak[role] = 'Creador'){$CreaRol = 'originator';$CreaName = $cuak[organisationName];$CreaCode = $cuak[codigoSitio];if(empty($cuak[email]) == FALSE){$CreaMail = $cuak[email];}else{$CreaMail = $direccionCorreoMD;};$CreaIname = $cuak[individualName];}}*/


/*if($PoCG[$CG] == 'Conservador'){$CustRol = 'custodian';$CustName = $PoCG[0];$CustMail = $direccionCorreoMD;}
if($PoCG[$CG] == 'Propietario'){$OwnerRol = 'owner';$OwnerName = $PoCG[0];$OwnerMail = $direccionCorreoMD;}
if(($PoCG[$CG] == 'Creador') && (empty($PoCInName) === TRUE)){$CreaRol = 'custodian';$CreaName = $PoCG[0];$CreaMail = $direccionCorreoMD;}
if(($PoCI[$CI] == 'Creador') && (empty($PoCInName) === FALSE)){$CreaRol = 'custodian';$CreaName = $PoCI[1];$CreaIName = $PoCI[0];$CreaMail = $direccionCorreoMD;}*/

        $credito = $CreaName;


/* PALABRAS CLAVE */

/*unset($values,$values1);
foreach(($doc->getElementsByTagName('descriptiveKeywords')) as $node) {
    $values[]= $node->nodeValue;}

$CountValues = count($values)-1;
$iVal = 0;
while ($iVal <= $CountValues){
    $values1[] = trim ($values[$iVal]);
    $iVal++;}
$Vali = 0;
unset($values2);
while ($Vali <= $CountValues){
    $pos[$Vali] = strrpos($values1[$Vali], ".",-3);
    if ($pos[$Vali]!== false){$values2[] = substr($values1[$Vali],$pos[$Vali]+1);}
    else {$values2[] = $values1[$Vali];}
    $Vali++;}
    
$xxx= array();
$MDKey = array();

    $jk=0;
    while($jk <= ($CountValues)){
 
            $xxx = preg_split("/[\s,]+/",$values2[$jk]);
        unset($MDThes,$MDlen);
            
        $MDlen = count($xxx);
            if(is_numeric($xxx[$MDlen-1])){
                 $MDThes[2] = $xxx[$MDlen-2].' '.$xxx[$MDlen-1];
                 $MDThes[1] = $xxx[$MDlen-3];
           
                 $ggg = 0;
                        while($ggg <= ($MDlen-4)){
                             $MDkey[$jk][$ggg] = $xxx[$ggg];
                             $MDkg[$jk]=implode (" ",$MDkey[$jk]);
                             $MDThes[0]=$MDkg[$jk];
                                                        $ggg++;}
                ;}
          else {unset($MDkey,$MDkg,$MDkh);
                $MDThes[2] = $xxx[$MDlen-1];
                $MDThes[1] = $xxx[$MDlen-2];
                
                $hhh = 0;
                        while($hhh <= ($MDlen-3)){
                             $MDkey[$jk][$hhh] = $xxx[$hhh];
                             $MDkh[$jk]=implode (" ",$MDkey[$jk]);
                             $MDThes[0]=$MDkh[$jk];
                                                        $hhh++;}
                ;}
        
        
$MDThesg[]=$MDThes;
        
                                                                  $jk++;}*/
/* PALABRAS CLAVE */
unset($MDThesg);
foreach(($doc->getElementsByTagName('descriptiveKeywords')) as $node){
    $MDThesg[] = array_values(array_filter(array_map(trim,(preg_split("/[\n]+/",($node->nodeValue))))));} // antes 't' y no 'n', 'n' mejor parece ser

$MDThesg = only1($MDThesg); // funcion 'only1' descrita al inicio del programa. Se queda con la palabra clave y no con toda la frase de su procedencia

/* BUSCADO DE PALABRAS CLAVE INSPIRE PARA DEFINIR ANEXO (estan en inglés y castellano)*/

unset($pp,$Anexo);
$pp=0;
$Anexo='';
while($pp<=count($MDThesg)){
if (in_array(strtolower($MDThesg[$pp][0]),array_map('strtolower',$AnexoI))===TRUE){$Anexo[] ='ANEXO I';}
elseif (in_array(strtolower($MDThesg[$pp][0]), array_map('strtolower',$AnexoII))===TRUE){$Anexo[] ='ANEXO II';}
elseif (in_array(strtolower($MDThesg[$pp][0]), array_map('strtolower',$AnexoIII))===TRUE){$Anexo[] ='ANEXO III';}
$pp++;}



if(empty($Anexo)==TRUE){$Anexo[]='MD sin temas INSPIRE ';}//*****
unset($pp);
$Anexo = implode(' y ',((array)$Anexo));

/*  BORRADO DE ALGUNAS PALABRAS CLAVE REPETIDAS  */

unset($pp,$GMET,$NOGEM);
$pp=0;    
while($pp<=count($MDThesg)){
if (in_array('GEMET 4.0',(array)$MDThesg[$pp])==TRUE){
    $GMET[]=$pp;}
    else{$NOGEM[]=$pp;}   
$pp++;}//fin subprincipal  
unset($pp);

foreach((array)$GMET as $si){
    foreach((array)$NOGEM as $no){
    if(in_array(strtolower($MDThesg[$si][0]), array_map('strtolower', (array)$MDThesg[$no]))==TRUE){
    unset($MDThesg[$no]);}
    }
}
$MDThesg = array_values($MDThesg);

/*  BORRADO DE THESAURO EuropeanTerritorialUnits, para hacerlo fijo, y tambien el resto de tesauros de localización */

unset($pp,$p1p,$p2p);

$pp = 1;
while($pp<=count($MDThesg)){
if((in_array("place",(array)$MDThesg[$pp]))==TRUE){
    unset($MDThesg[$pp]);}
        $pp++;}//fin bucle 1

$MDThesg = array_values($MDThesg);
unset($pp,$p1p,$p2p);
     /* hay que pasar el bucle 2 veces...... */
$pp = 1;
while($pp<=count($MDThesg)){
if((in_array("place",(array)$MDThesg[$pp]))==TRUE){
    unset($MDThesg[$pp]);}
        $pp++;}//fin bucle 1

$MDThesg = array_values($MDThesg);
unset($pp,$p1p,$p2p);

/*  FIJANDO THESAURO EuropeanTerritorialUnits */

$thETU[0] = 'ESPAÑA';
$thETU[1] = 'COMUNIDAD VALENCIANA';
$thETU[2] = 'place';
$thETU[3] = 'EuropeanTerritorialUnits';

/* TABLAS ASOCIADAS */

unset($valuesTA);
foreach(($doc->getElementsByTagName('attr')) as $node) {
    $valuesTA[] = array_values(array_filter(array_map(trim,(preg_split("/[\t]+/",($node->nodeValue))))));}

$fta = fopen("C:/Users/D53760969X/Desktop/ICV_ANTON/MD_MedioAmbiente/Trabajados/PHP/TA/TA".$identificador.".csv","w");

  foreach ((array)$valuesTA as $campos){
             fputcsv($fta,$campos);}

/* USOS y CONDICIONES DE ACCESO, RESTRICCIONES */

$UsoSpecif = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/resourceSpecificUsage/MD_Usage/specificUsage');
$UsoSpecif = (string)$UsoSpecif[0];
        if (strlen($UsoSpecif)<1){$UsoSpecif = 'Conocimiento y gestión del territorio';}

$CondAccUso = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/resourceConstraints/MD_LegalConstraints/useLimitation');
$CondAccUso = (string)$CondAccUso[0];
        if (strlen($CondAccUso)<1){
            $CondAccUso =  $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/resourceConstraints/MD_LegalConstraints/useConstraints');
            $CondAccUso = (string)$CondAccUso[0];
            if (strlen($CondAccUso)<1){$CondAccUso ='CONDICIONES DESCONOCIDAS';}//*****
        }

/*$CondAccUso2 = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/resourceConstraints/MD_LegalConstraints/otherConstraints');
$CondAccUso2 = (string)$CondAccUso2[0];
        if (strlen($CondAccUso2)<1){$CondAccUso2 = 'restringido';}*/

$RestAcc = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/resourceConstraints/MD_LegalConstraints/accessConstraints');
$RestAcc = (string)$RestAcc[0];
/*if ((string)$RestAcc[0] == 'otherRestrictions'){$RestAcc = 'otherRestrictions';}
elseif ((string)$RestAcc[0] == 'copyright'){$RestAcc = 'copyright';}
elseif ((string)$RestAcc[0] == 'intellectualPropertyRights'){$RestAcc = 'intellectualPropertyRights';}
elseif ((string)$RestAcc[0] == 'trademark'){$RestAcc = 'trademark';}
elseif ((string)$RestAcc[0] == 'patentPending'){$RestAcc = 'patentPending';}
elseif ((string)$RestAcc[0] == 'restricted'){$RestAcc = 'restricted';}  
else {$RestAcc = 'condiciones desconocidas';}*/

$OResAcc = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/resourceConstraints/MD_LegalConstraints/otherConstraints');
$OResAcc = (string)$OResAcc[0];
        if (strlen($OResAcc)<1){$OResAcc = 'No hay limitaciones';}//*****

 /* EUROPEAN PETROLEUM SURVEY GROUP, sistema de coordenadas utilizado (ETRS89-UTM o WGS84-ED50) */

$epsgTit = $carga->xpath('/MD_Metadata/referenceSystemInfo/MD_CRS/referenceSystemIdentifier/RS_Identifier/authority/CI_Citation/title'); 
$epsgTit = $epsgTit[0];

$epsgCode = $carga->xpath('/MD_Metadata/referenceSystemInfo/MD_CRS/referenceSystemIdentifier/RS_Identifier/code');
$epsgCode = $epsgCode[0];
if ($epsgCode == 'EPSG:25830'){$epsgCode = 'EPSG:3042';}

$epsgVersion = $carga->xpath('/MD_Metadata/referenceSystemInfo/MD_CRS/referenceSystemIdentifier/RS_Identifier/version');
$epsgVersion = (string)$epsgVersion[0];


 /* REPRESENTACION ESPACIAL, IDIOMAS, ESCALA y RESOLUCIÓN */   

$TypRepEsp = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/spatialRepresentationType');
$TypRepEsp = (string)$TypRepEsp[0];

$Idioma1 = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/language');
$Idioma1 = (string)$Idioma1[0];

$Idioma2 = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/language');
$Idioma2 = (string)$Idioma2[1];


$Escala = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/spatialResolution/MD_Resolution/equivalentScale/MD_RepresentativeFraction/denominator');
$Escala = (string)$Escala[0];

$Resolu = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/spatialResolution/MD_Resolution/distance');
$Resolu = (string)$Resolu[0];
//if ($Escala>0){$Resolu = 0;}
if ($Resolu>$Escala){$EscReso=$Resolu;}
else{$EscReso=$Escala;}

/* CATEGORIA DE TEMAS (Y ANEXO AL QUE PERTENECEN, pero esto ultimo se ha borrado del resultado final) */

    $Temas = $carga->xpath('/MD_Metadata/identificationInfo/MD_DataIdentification/topicCategory');
        $Temas1 = $Temas;

        /*$AnexoT = array(); //ANEXOS DE LOS TEMAS -- NO ES NECESARIO, SE QUITA DEL RESULTADO FINAL
        $j = 0;
        while ($j <= 2){

                if ((string)$Temas[$j] == 'Agricultura'){$Temas1[$j] = 'farming';$AnexoT[$j]='ANEXO III';} 
                elseif ((string)$Temas[$j] == 'Biota'){$Temas1[$j] = 'biota';$AnexoT[$j]='ANEXO III';}
                elseif ((string)$Temas[$j] == 'Límites'){$Temas1[$j] = 'boundaries';$AnexoT[$j]='ANEXO I y III';}
                elseif ((string)$Temas[$j] == 'Atmósfera climatológica y meteorológica'){$Temas1[$j] = 'climatologyMeteorologyAtmosphere';$AnexoT='ANEXO III';}
                elseif ((string)$Temas[$j] == 'Economía'){$Temas1[$j] = 'economy';$AnexoT[$j]='ANEXO III';}
                elseif ((string)$Temas[$j] == 'Elevación'){$Temas1[$j] = 'elevation';$AnexoT[$j]='ANEXO II';}
                elseif ((string)$Temas[$j] == 'Medio ambiente'){$Temas1[$j] = 'environment';$AnexoT[$j]='ANEXO I';}
                elseif ((string)$Temas[$j] == 'Información geocientífica'){$Temas1[$j] = 'geoscientificInformation';$AnexoT[$j]='ANEXO III y II';}
                elseif ((string)$Temas[$j] == 'Salud '){$Temas1[$j] = 'health';$AnexoT[$j]='ANEXO III';}
                elseif ((string)$Temas[$j] == 'Cobertura de la Tierra con mapas básicos e imágenes'){$Temas1[$j] = 'imageryBaseMapsEarthCover';$AnexoT[$j]='ANEXO II';}
                elseif ((string)$Temas[$j] == 'Inteligencia militar'){$Temas1[$j] = 'intelligenceMilitary';}
                elseif ((string)$Temas[$j] == 'Aguas interiores '){$Temas1[$j] = 'inlandWaters';$AnexoT[$j]='ANEXO I';}
                elseif ((string)$Temas[$j] == 'Localización'){$Temas1[$j] = 'location';$AnexoT[$j]='ANEXO I';}
                elseif ((string)$Temas[$j] == 'Océanos'){$Temas1[$j] = 'oceans';$AnexoT[$j]='ANEXO III';}
                elseif ((string)$Temas[$j] == 'Planeamiento catastral'){$Temas1[$j] = 'planningCadastre';$AnexoT[$j]='ANEXO III';}
                elseif ((string)$Temas[$j] == 'Sociedad'){$Temas1[$j] = 'society';$AnexoT[$j]='ANEXO III';}
                elseif ((string)$Temas[$j] == 'Estructura'){$Temas1[$j] = 'structure';$AnexoT[$j]='ANEXO III';}
                elseif ((string)$Temas[$j] == 'Transporte'){$Temas1[$j] = 'transportation';$AnexoT[$j]='ANEXO I';}
                elseif ((string)$Temas[$j] == 'Redes de suministro'){$Temas1[$j] = 'utilitiesCommunication';$AnexoT[$j]='ANEXO III';}
                $j++;}*/

                
/* BoundingBox */

$BboxO = $carga->xpath('/MD_Metadata/dataQualityInfo/DQ_DataQuality/scope/DQ_Scope/extent/EX_Extent/geographicElement/EX_GeographicBoundingBox/westBoundLongitude');
$BboxO = (float)$BboxO[0]; // antes (string), mismo resultado

$BboxE = $carga->xpath('/MD_Metadata/dataQualityInfo/DQ_DataQuality/scope/DQ_Scope/extent/EX_Extent/geographicElement/EX_GeographicBoundingBox/eastBoundLongitude');
$BboxE = (float)$BboxE[0];

$BboxS = $carga->xpath('/MD_Metadata/dataQualityInfo/DQ_DataQuality/scope/DQ_Scope/extent/EX_Extent/geographicElement/EX_GeographicBoundingBox/southBoundLatitude');
$BboxS = (float)$BboxS[0];

$BboxN = $carga->xpath('/MD_Metadata/dataQualityInfo/DQ_DataQuality/scope/DQ_Scope/extent/EX_Extent/geographicElement/EX_GeographicBoundingBox/northBoundLatitude');
$BboxN = (float)$BboxN[0];

/* FORMATOS disponibles */

$Format = $carga->xpath('/MD_Metadata/distributionInfo/MD_Distribution/distributionFormat/MD_Format/name');
$Format1 = (string)$Format[0];
$Format2 = (string)$Format[1];
$Format3 = (string)$Format[2];
$Format4 = (string)$Format[3];
$Format5 = (string)$Format[4];
$Version = 'Desconocida';

/* ENLACES DISPONIBLES */

unset($OnRec);
foreach(($doc->getElementsByTagName('CI_OnlineResource')) as $node){
    $OnRec[] = array_values(array_filter(array_map(trim,(preg_split("/[\n]+/",($node->nodeValue))))));}

unset($pp,$OnlineRes);
$pp = 0;
while($pp<=count($OnRec)){
if (in_array('URL del visor web público',(array)$OnRec[$pp])===TRUE){$OnlineRes[0] = $OnRec[$pp];
                                                                     $OnlineRes[0][2] = 'URL del visor web público';
                                                                     $OnlineRes[0][3] = 'information';}
elseif (in_array('Servicio WMS',(array)$OnRec[$pp])===TRUE){$OnlineRes[1] = $OnRec[$pp];
                                                            $OnlineRes[1][2] = 'Servicio WMS';
                                                            $OnlineRes[1][3] = 'order';}
elseif (in_array('URL del visor web privado Conselleria',(array)$OnRec[$pp])===TRUE){$OnlineRes[2] = $OnRec[$pp];
                                                                                    $OnlineRes[2][2] = 'URL del visor web privado Conselleria';
                                                                                    $OnlineRes[2][3] = 'information';}
elseif (in_array('capa de polígonos de ArcSDE',(array)$OnRec[$pp])===TRUE){$OnlineRes[3] = $OnRec[$pp];
                                                                          $OnlineRes[3][2] = 'capa de ArcSDE';}
elseif (in_array('capa de puntos de ArcSDE',(array)$OnRec[$pp])===TRUE){$OnlineRes[3] = $OnRec[$pp];
                                                                       $OnlineRes[3][2] = 'capa de ArcSDE';}
elseif (in_array('capa de líneas de ArcSDE',(array)$OnRec[$pp])===TRUE){$OnlineRes[3] = $OnRec[$pp];
                                                                       $OnlineRes[3][2] = 'capa de ArcSDE';}
$pp++;}

//$OnlineRes = array_values((array)$OnlineRes);
/*   */
$Nivel = $carga->xpath('/MD_Metadata/dataQualityInfo/DQ_DataQuality/scope/DQ_Scope/level');
if ((string)$Nivel[0] == 'Conjunto de datos'){$Nivel = 'dataset';}
else {$Nivel = 'SERIE';}

$Conformidad2010 = 'false';
$Conformidad2008 = 'true';

/* Linage, cuando hay varios processtep o sources los unimos utilizando un while y la funcion implode */

$LiDecla = $carga->xpath('/MD_Metadata/dataQualityInfo/DQ_DataQuality/lineage/LI_Lineage/statment');
$LiDecla = (string)$LiDecla[0];

    $LiSource = $carga->xpath('/MD_Metadata/dataQualityInfo/DQ_DataQuality/lineage/LI_Lineage/source/LI_Source/description');
    $CoLiSource = count($LiSource);
    $LiSoEscal = $carga->xpath('/MD_Metadata/dataQualityInfo/DQ_DataQuality/lineage/LI_Lineage/source/LI_Source/scaleDenominator/MD_RepresentativeFraction/denominator');
    $CoLiSoEscal = count($LiSoEscal);
        $k = 0;
        while ($k < $CoLiSource){
          $Source1[$k] = (string)$LiSource[$k].'(escala 1/'.(string)$LiSoEscal[$k].')';
            $k++;}
$SourceLin = implode('. ',(array)$Source1);

if(empty($LiDecla) == TRUE){
    $LiDecla = $SourceLin;
    unset($SourceLin);}//si la declaración est vacia, cortamos y pegamos la fuente

unset($LiStepDate);
    $LiPrStep = $carga->xpath('/MD_Metadata/dataQualityInfo/DQ_DataQuality/lineage/LI_Lineage/processStep/LI_ProcessStep/description');
    $LiPrStep = array_values(array_filter(array_map(trim,$LiPrStep)));
    $CoLiPrStep = count($LiPrStep);
    $LiStepDate = $carga->xpath('/MD_Metadata/dataQualityInfo/DQ_DataQuality/lineage/LI_Lineage/processStep/LI_ProcessStep/dateTime');
    $LiStepDate = array_values(array_filter(array_map(trim,$LiStepDate)));
    $CoLiStepDate = count($LiStepDate);
        $t = 0;
        while ($t < $CoLiPrStep){
            if(empty($LiStepDate[$t])==TRUE){$PrStep1[$t]=(string)$LiPrStep[$t];
                                            $t++;} 
            else{
          $PrStep1[$t] = ' '.(string)$LiPrStep[$t].'(con fecha de '.(string)$LiStepDate[$t].').';
            $t++;}}
//$PrStepLin = implode(chr(13).chr(10),((array)$PrStep1));


    
/* preparando el volcado del contenido */

        $lista[$i] = array($identificador, $nvlJerarquico, $nombreOrgMD, $direccionCorreoMD, $fechaMD2, $fechaMD, $titulo, $tituloAlte, $Fecha01,$FeTyp01,$Fecha02,$FeTyp02,$Fecha03,$FeTyp03, $codigo, $formPresentacion, $resumen, $proposito, $credito, $OwnerName, $OwnerMail, $OwnerRol, $OwnerCode, $OwnerIname, $OwnerDir, $OwnerPostalC, $OwnerPais, $OwnerPobla, $UsoSpecif, $CustName, $CustMail, $CustRol, $CustCode, $CustIname, $CustDir, $CustPostalC, $CustPais, $CustPobla, $CreaName, $CreaMail, $CreaRol, $CreaCode, $CreaIname, $CreaDir, $CreaPostalC, $CreaPais, $CreaPobla, $RestAcc, $CondAccUso, $OResAcc, $TypRepEsp, $Idioma1, $Idioma2, $EscReso, $Temas[0], $Temas[1], $Temas[2], $BboxO, $BboxE, $BboxS, $BboxN, $Format1, $Version, $Format2, $Version, $Format3, $Version, $Format4, $Version, $Format5, $Version, $OnlineRes[0][0], $OnlineRes[1][0], $OnlineRes[2][0], $OnlineRes[3][0], $Nivel, $Conformidad2010, $Conformidad2008, $LiDecla, $PrStepLin, $SourceLin, $tempExtent, $epsgTit, $epsgCode, $epsgVersion, $Anexo, $thETU[0], $thETU[1], $thETU[2], $thETU[3]);


    // Añadimos el anexo inspire al que pertenece/n la palabra/s clave/s inspire dada/s
    // añadimos tesauro fijo EuropeanTerritorialUnits 

foreach($MDThesg as $tesauro){
    $lista[$i][] = $tesauro[0];
    $lista[$i][] = $tesauro[1];
    $lista[$i][] = $tesauro[2];
    }// añadiendo tesauros restantes a la lista al final

unset($MDThesg);
fclose($fta); //cerramos los archivos de las tablas asociadas     

 $i++;} //fin del bucle while nº1

$encabezados = array('Identificador', 'Nivel jerarquico', 'Nombre de la organización(MD)', 'Dirección de correo electrónico(MD)', 'Fecha de creación(metadatos)','Fecha de actualización(metadatos)', 'Identificación(Titulo)', 'Título alternativo', 'Fecha 1', 'Tipo de fecha 1','Fecha 2', 'Tipo de fecha 2','Fecha 3', 'Tipo de fecha 3', 'Código', 'Forma de presentación', 'Resumen (del recurso)', 'Propósito', 'Crédito', 'Nombre de la organización(PROPIETARIA)', 'Email', 'Rol (dueños de los datos)', 'Sitio', 'Nombre Individual', 'Direccion', 'Codigo Postal', 'Pais', 'Poblacion', 'Uso específico del recurso', 'Nombre organización(CONSERVADORA)', 'Email', 'Rol', 'Sitio', 'Nombre Individual', 'Direccion', 'Codigo Postal', 'Pais', 'Poblacion', 'Nombre de la organización(CREADORA)', 'Email', 'Rol (dueños de los datos)', 'Sitio', 'Nombre Individual', 'Direccion', 'Codigo Postal', 'Pais', 'Poblacion', 'Restricciones de acceso', 'Condiciones de acceso y uso', 'Otras restricciones', 'Tipo de representación espacial', 'Idioma del recurso', 'Idioma del recurso', 'Escala(denominador) o Tamaño del Píxel', 'Categoria de Temas', 'Categoria de Temas', 'Categoria de Temas', 'Límite de Longitud OESTE', 'Límite de Longitud ESTE', 'Límite de Latitud SUR', 'Límite de Latitud NORTE', 'Nombre', 'Versión', 'Nombre', 'Versión', 'Nombre', 'Versión', 'Nombre', 'Versión', 'Nombre', 'Versión', 'URL del visor web publico', 'URL servicio WMS', 'URL del visosr privado Conselleria', 'Dirección de la capa', 'Ámbito de los datos: nivel', 'Grado de conformidad(UE 1089/2010)', 'Grado de conformidad(CE 1205/2008)', 'Declaración', 'Pasos del proceso', 'Fuente', 'Extension temporal(Datos)', 'EPSG', 'EPSG codigo', 'EPSG Version', 'Palabras Clave');

/* Imprimir en pantalla los metadatos procesados */

$Q=$i-2;
print_r('Metadatos procesados: '.$Q.' || Variables :'.count($lista[2]).' || Encabezados : '.count($encabezados)); //metadatos procesados, variables y cabezeras. lista[2] por que '$i' emieza con valor 2 en el bucle, para ver la relación entre campos y encabezados de columna.

/* Volcamos en CSV */

$fp = fopen("C:/Users/D53760969X/Desktop/ICV_ANTON/MD_MedioAmbiente/Trabajados/PHP/METADAT5.csv","w");

   fputcsv($fp,$encabezados);  //Encabezados


  foreach($lista as $campos){
             fputcsv($fp,$campos);}   // Datos

fclose($fp);


/*                              MODIFICACIONES -- Observaciones 

-Escala / tamaño de pixel ahora es dinámico, o uno o otro, no uno con un valor y el otro con '0'.
-Palabras clave aparecen al final para que sean dinamicas sin 'entorpecer' en el encabezado de la tabla.
-Si alguna palabra clave es igual que la primera, se borra automaticamente evitando en parte la repeticion de las mismas.
-Borrado de tesauro EuropeanTerritorialUnits y todos los de localización (tesauros con valor 'place') si aparecen, para añadir localizacion como tesauro EuropeanTerritorialUnits de manera fija.
-Insertar en el tesauro fijo anterior (EuropeanTerritorialUnits) ESPAÑA tambien, aparte de COMUNIDAD VALENCIANA, se inserta al principio para evitar problemas con las cabeceras ya que este tendra 2 palabras clave y no 1 como el resto de tesauros.
-Borrado de tesauro ISO3166 (place, y posiblemente estaba mal rellenado).
-Creación de tablas asociadas a cada metadato, se crea un archivo csv por metadato.
-Corregido restricciones de acceso y uso ('otherConstraints' no se realizaba correctamente).
-Se quitan de las Categorias de temas los Anexos inspire a los que pertenece dicha categoria.
-Punto de contacto repetido pero como 'Point of contact' borrado, era el mismo que custodian.
-Linage, cuando no hay declaración, cortamos y pegamos el valor de la fuente.
-Se ha añadido variable microtime para saber que tarda en ejecutarse el programa, se vera por pantalla del simbolo del sistema (cmd - bat - ms dos).
-Se a añadido el elemeto 'Temporal extent', con las fechas de inicio y fin de los datos.
-Uso especifico del recurso generico = 'Conocimiento y gestión del territorio'.
-Como no todos los datos estan en ETRS89, ahora EPSG es variable.
-Online resources reducido a 3 posiblidades: Visor Publico, privado o WMS.
-Se han renovado los 'puntos de contacto', ahora incluye nombres individuales y es mas dinámico.
-Corregido error en pasos del proceso, cuando uno de estos no tenia fecha, aparecia igualmente un string 'con fecha de...' que sobraba.
-Se han vuelto a renovar los 'puntos de contacto', ahora también contemplan la dirección, el codigo postal, el pais y la poblacion aunque de un modo no estrictamente seguro (podría haber alguna calle, ciudad o país no contemplado y no se extraería).
-Se añade funcion que convierte todo el xml en una array(mediante codificación y decodificacion a json) par facilitar la extraccion de datos.


--------------------NOTAS REALIZACIÓN :

Ha sido clave para la realización la documentacion siguiente:
-La del propio PHP 'general', abrir y cerrar archivos etc...
-La extension php - SimpleXML (simplexml_load_file).
-La extension DOMDocument.
-La posible conversion de XML a array mediante codificación json (json_encode - json_decode), descubierta en ultima instancia del programa...
*/


$horaFin = microtime(true);
$interval = $horaFin-$horaIni;
print_r('                 |Tiempo transcurrido : '.$interval);
?>
