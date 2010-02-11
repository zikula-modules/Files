<?php
/**
 * Open a field form in order to choose the needed image file
 * @author:	Albert Pérez Monfort & Fèlix Casanellas
 * @return:	The list of files and folders
 */
function Files_external_getFormHook()
{
    $pnRender = pnRender::getInstance('Files', false);
    return $pnRender->fetch('Files_external_formHook.htm');
}