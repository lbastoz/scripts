<?php

/******************************************
 * OBTIENE EL BACKUP DE LA BASE DE DATOS
 * DE PRODUCCION DIARIAMENTE
 * @author Bernardo Zerda
 * @version 1.0 Mar 2017
 *******************************************/

// Archivo de funciones
include (getcwd() . "/funciones.php");

// Verifica la existencia de la carpeta de backups DESTINO_BACKUP_BD
if (! is_dir(DESTINO_BACKUP_BD)) {
    mensajeLog("No existe la carpeta " . DESTINO_BACKUP_BD);
} else {
    
    // Genera el backup directo de produccion
    $txtSalida = "";
    mensajeLog("Inicia el backup de " . NOMBRE_BD);
    $txtArchivo = date("Ymd") . "-sdht_subsidios.sql";
    $txtComando = "mysqldump -u" . USUARIO_BD . " -p" . CLAVE_BD . " -h" . SERVIDOR_PRODUCCION . " " . NOMBRE_BD . " > " . DESTINO_BACKUP_BD . "/" . $txtArchivo;
    // $txtSalida = shell_exec($txtComando);
    mensajeLog("Termina el backup de " . NOMBRE_BD);
    
    // Comprime el backup generado
    $txtSalida = "";
    mensajeLog("Inicia compresion del backup " . $txtArchivo);
    $txtComando = "tar -zcvf " . DESTINO_BACKUP_BD . "/" . substr($txtArchivo, 0, strlen($txtArchivo) - 4) . ".tar.gz " . DESTINO_BACKUP_BD . "/" . $txtArchivo;
    // $txtSalida = shell_exec($txtComando);
    $txtComando = "rm -f " . DESTINO_BACKUP_BD . "/" . $txtArchivo;
    // $txtSalida = shell_exec($txtComando);
    mensajeLog("Termina compresion del backup " . $txtArchivo);
    
    // Limpia los backups de antes de DIAS_RETENCION dias (configurado en funciones.php)
    mensajeLog("Inicia limpieza de archivos anteriores a " . DIAS_RETENCION . " dias");
    $txtArchivo = "";
    if ($aptDirectorio = opendir(DESTINO_BACKUP_BD)) {
        while (($txtArchivo = readdir($aptDirectorio)) !== false) {
            if($txtArchivo != "." and $txtArchivo != ".."){
                echo "nombre archivo: $txtArchivo \r\n";
            }
        }
        closedir($aptDirectorio);
    }
    mensajeLog("Inicia limpieza de archivos anteriores a " . DIAS_RETENCION . " dias");
}

?>