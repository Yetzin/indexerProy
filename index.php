<?php
/*
*   Importante!
*
*   Para que los directorios aparezcan es necesario agregarlos
*   en el array $directorios.
*
*/
$directorios = array(
  'mitazu/',
  'tiltlac/',
  'metodosn/u1/',
  'metodosn/u2/',
  'metodosn/u3/',
  'metodosn/RegLinealU4/'
);

function dirToArray($dir){
  $result = array();
  $cdir = scandir($dir);
  foreach ($cdir as $key => $value){
    if(!in_array($value,array(".",".."))){
      if(is_dir($dir . DIRECTORY_SEPARATOR . $value)){
        $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
        echo $value.'<br>';
      } else {
        $result[] = $value;
      }
    }
  }
  return $result;
}

$indicesServer = array(
  'PHP_SELF',
  'argv',
  'argc',
  'GATEWAY_INTERFACE',
  'SERVER_ADDR',
  'SERVER_NAME',
  'SERVER_SOFTWARE',
  'SERVER_PROTOCOL',
  'REQUEST_METHOD',
  'REQUEST_TIME',
  'REQUEST_TIME_FLOAT',
  'QUERY_STRING',
  'DOCUMENT_ROOT',
  'HTTP_ACCEPT',
  'HTTP_ACCEPT_CHARSET',
  'HTTP_ACCEPT_ENCODING',
  'HTTP_ACCEPT_LANGUAGE',
  'HTTP_CONNECTION',
  'HTTP_HOST',
  'HTTP_REFERER',
  'HTTP_USER_AGENT',
  'HTTPS',
  'REMOTE_ADDR',
  'REMOTE_HOST',
  'REMOTE_PORT',
  'REMOTE_USER',
  'REDIRECT_REMOTE_USER',
  'SCRIPT_FILENAME',
  'SERVER_ADMIN',
  'SERVER_PORT',
  'SERVER_SIGNATURE',
  'PATH_TRANSLATED',
  'SCRIPT_NAME',
  'REQUEST_URI',
  'PHP_AUTH_DIGEST',
  'PHP_AUTH_USER',
  'PHP_AUTH_PW',
  'AUTH_TYPE',
  'PATH_INFO',
  'ORIG_PATH_INFO'
);
$fragHtml = '';
$tbHtml = '<table> <tr><th>Propiead</th><th>Valor</th></tr>';
foreach($indicesServer as $arg){
  if(isset($_SERVER[$arg])){
    if(strlen($_SERVER[$arg]) > 0){
      $tbHtml.='<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>';
    }
  } else {
    //$tbHtml.='<tr><td>'.$arg.'</td><td>Vacio</td></tr>';
  }
}
$tbHtml.='</table>';

foreach ($directorios as $valor){
  $fragHtml.='<a id="dir_lnk" href="'.$valor.'""><p>'.$valor.'</p></a>';
}
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Directorios</title>
    <style media="screen">
      *, ::after, ::before {
        margin: 0;
        padding: 0;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
      }
      header{
        position: absolute;
        display: block;
        top: 0;
        left: 0;
        right: 0;
        height: min-content;
        background-color: #252932;
        color: #fff;
        padding: 10px 5%;
      }
      .cont_pag{
        width: 100%;
        padding: 60px 5%;
      }
      .cont_lnks{
        width: max-content;
        padding: 1px 20px;
      }
      #cont_tb{
        display: none;
        width: 100%;
        padding: 5px 5px 5px 30px;
        background-color: #f0eff9;
        text-align: left;
      }
      #mas_tb{
        text-decoration: none;
        cursor: pointer;
      }
      #mas_tb:hover{
        text-decoration: underline;
      }
      #dir_lnk{
        text-decoration: none;
        color: #252932;
        font-weight: 600;
        display: block;
        width: 100%;
        transition: 400ms;
        padding: 8px 0;
        border: 2px solid transparent;
      }
      #dir_lnk:hover{
        padding: 8px 20px;
        border: 2px solid #f0c0b0;
        text-decoration: underline;
      }
      table{
        border-collapse: collapse;
        width: 100%;
      }
      th, td{
        padding: 10px;
        border-bottom: 1px solid gray;
      }
      .dirs_list{
        width: 100%;
        padding: 20px 0;
        border-top: 2px solid gray;
        border-bottom: 2px solid gray;
      }
    </style>
    <script type="text/javascript">
      var m_inf = true;
      function mostrarOps(){
        if(m_inf){
          document.getElementById('cont_tb').style.display = 'block';
          document.getElementById('mas_tb').innerHTML = '- Ocultar';
        } else {
          document.getElementById('cont_tb').style.display = 'none';
          document.getElementById('mas_tb').innerHTML = '+ Mostrar';
        }
        m_inf = !m_inf;
      }
    </script>
  </head>
  <body>
    <header>
      <p class="title_pag"><?=$_SERVER['HTTP_HOST']; ?></p>
    </header>
    <div class="cont_pag">
      <p>Servidor: <?=$_SERVER['SERVER_ADDR']; ?></p>
      <p>Visitante: <?=$_SERVER['REMOTE_ADDR']; ?></p>
      <br>
      <div class="dirs_list">
        <h3>Los proyectos encontrados son:</h3>
        <div class="cont_lnks"> <?=$fragHtml; ?> </div>
      </div>
      <br>
      <h3>Información del servidor</h3>
      <br>
      <a id="mas_tb" onclick="mostrarOps()">+ Mostrar</a>
      <div id="cont_tb"> <?=$tbHtml; ?> </div>
      <div id="cont_dir"> <?=print_r(dirToArray("./")); ?> </div>
    </div>
  </body>
</html>
