<?php
//  getDirs se encarga de obtener los directorios de manera recursiva
function getDirs($dir){
  $result = '';
  $cdir = scandir($dir);
  foreach ($cdir as $key => $value){
    if(!in_array($value,array(".",".."))){
      if(is_dir($dir.DIRECTORY_SEPARATOR.$value)){
        if($dir != '.\dashboard'){
          $result.=getDirs($dir.DIRECTORY_SEPARATOR.$value);
        } else {
          break;
        }
      } else {
        if($dir != '.' && ($value == 'index.php' || $value == 'index.html')){
          $result='<a id="dir_lnk" href="'.substr($dir, 2).DIRECTORY_SEPARATOR.'""><p>'.substr($dir, 2).DIRECTORY_SEPARATOR.'</p></a>';
          break;
        }
      }
    }
  }
  return $result;
}

//  Lista de detalles para mostrar sobre el servior
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
$tbHtml = '<table> <tr><th>Propiead</th><th>Valor</th></tr>';
foreach($indicesServer as $arg){
  if(isset($_SERVER[$arg])){
    if(strlen($_SERVER[$arg]) > 0){
      $tbHtml.='<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>';
    }/* else {
      $tbHtml.='<tr><td>'.$arg.'</td><td>-</td></tr>';
    }*/
  }/* else {
    $tbHtml.='<tr><td>'.$arg.'</td><td>-</td></tr>';
  }*/
}
$tbHtml.='</table>';
$directoriosObt = getDirs('.');
if(strlen($directoriosObt) == 0){
  $directoriosObt = '<em style="text-decoration: underline; display: list-item;">No se ha encontrado proyectos...</em>';
}
function directorioCont($dir){
  $result = '';
  $cdir = scandir($dir);
  foreach ($cdir as $key => $value){
    if(!in_array($value,array(".",".."))){
      if(is_dir($dir.DIRECTORY_SEPARATOR.$value)){
        if($dir != '.\dashboard'){
          $result.=directorioCont($dir.DIRECTORY_SEPARATOR.$value);
        } else {
          break;
        }
      } else {
        if($dir != '.' && $dir != '.\dashboard'){
          $result.='
          '.substr($dir, 2).DIRECTORY_SEPARATOR.$value;
        }
      }
    }
  }
  return $result;
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
        display: block;
        height: min-content;
        background-color: #252932;
        color: #fff;
        padding: 10px 5%;
      }
      body{
        background-color: aliceblue;
      }
      .cont_pag{
        width: 100%;
        padding: 50px 5%;
      }
      .cont_lnks{
        width: max-content;
        padding: 1px 35px;
      }
      #cont_tb{
        display: none;
        width: 100%;
        padding: 5px 5px 5px 30px;
        background-color: #eedbff;
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
        display: list-item;
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
      <p class="title_pag" title="<?=$_SERVER['SERVER_NAME']; ?>"><?=$_SERVER['HTTP_HOST']; ?></p>
    </header>
    <div class="cont_pag">
      <p>Servidor: <?=$_SERVER['SERVER_ADDR']; ?></p>
      <p>Visitante: <?=$_SERVER['REMOTE_ADDR']; ?></p>
      <br>
      <div class="dirs_list">
        <h3>Los proyectos encontrados son:</h3>
        <div class="cont_lnks">
          <?=$directoriosObt; ?>
        </div>
      </div>
      <br>
      <h3>Información del servidor</h3>
      <br>
      <a id="mas_tb" onclick="mostrarOps()">+ Mostrar</a>
      <div id="cont_tb">
        <?=$tbHtml; ?>
      </div>
    </div>
<!--
<?php echo directorioCont('.'); ?>

-->
  </body>
</html>
