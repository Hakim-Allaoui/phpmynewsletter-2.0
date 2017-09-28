<?php
if(!sizeof($list)){
    $l='c';
}
switch($l){
    case 'l':
        if($page != "config"){
            echo '<header><h4>'.tr("LIST_OF_LISTS").'</h4></header>';
            echo '<form action="" method="post">';
            echo '<table  cellpadding="0" cellspacing="0" border="0" class="display" id="datatable"> 
                <thead> 
                    <tr> 
                        <!--<th style="text-align:center">'.tr("LIST_NUMBER").'</th>-->
                        <th style="text-align:center">'.tr("LIST_NAME").'</th>
                        <th style="text-align:center">'.tr("LIST_COUNT_SUSCRIBERS").'</th>
                        <th style="text-align:center">'.tr("LIST_COUNT_ERRORS_ON_SUBSCRIBERS").'</th>
                        <th style="text-align:center">'.tr("LIST_LAST_CAMPAIGN").'</th>
                        <th style="text-align:center">'.tr("SEND_IN_PROCESS").'</th>';
                    if(($_SESSION['dr_listes']=='Y'&&$_SESSION['dr_liste']=='')||$_SESSION['dr_is_admin']==true) {
                        echo '<th style="text-align:center">Dupliquer</th>
                        <th style="text-align:center">'.tr("LIST_MIX_TITLE").'</th>
                        <th style="text-align:center">Vider</th>
                        <th style="text-align:center">Gérer</th>
                        <th style="text-align:center">'.tr("DELETE").'</th> ';
                    }
                    echo '</tr>
                    </tr> 
                </thead>
                <tfoot> 
                    <tr> 
                        <!--<th style="text-align:center">'.tr("LIST_NUMBER").'</th>-->
                        <th style="text-align:center">'.tr("LIST_NAME").'</th>
                        <th style="text-align:center">'.tr("LIST_COUNT_SUSCRIBERS").'</th>
                        <th style="text-align:center">'.tr("LIST_COUNT_ERRORS_ON_SUBSCRIBERS").'</th>
                        <th style="text-align:center">'.tr("LIST_LAST_CAMPAIGN").'</th>
                        <th style="text-align:center">'.tr("SEND_IN_PROCESS").'</th>';
                    if(($_SESSION['dr_listes']=='Y'&&$_SESSION['dr_liste']=='')||$_SESSION['dr_is_admin']==true) {
                        echo '<th style="text-align:center">Dupliquer</th>
                        <th style="text-align:center">'.tr("LIST_MIX_TITLE").'</th>
                        <th style="text-align:center">Vider</th>
                        <th style="text-align:center">Gérer</th>
                        <th style="text-align:center">'.tr("DELETE").'</th> ';
                    }
                    echo '</tr> 
                </tfoot> 
                <tbody>';
	            foreach  ($list as $item){
	                if($_SESSION['dr_log']=='Y'&&$item['list_id']==$list_id&&$_SESSION['dr_is_user']) {
		            echo loggit($_SESSION['dr_id_user'].'.log', $_SESSION['dr_id_user'] . ' a sélectionné la liste : "'.$item['newsletter_name'].'"');
                        }
	            	if(($_SESSION['dr_listes']=='Y'&&$_SESSION['dr_liste']=='')||$_SESSION['dr_is_admin']==true) {
		                echo '<tr>';
		                //echo '<td style="text-align:center;padding:14px;">'. ($item['list_id']==$list_id?"<b>$list_id</b>":$item['list_id']) .'</td>';
		                echo ($item['list_id']==$list_id?
		                    '<td style="text-align:center;background-color:rgb(22,167,101);padding:14px;"><a href="?list_id='.$item['list_id'].'&token='.$token.'" style="color:rgb(255,255,255);font:12px arial,sans-serif;margin-top:15px" data-toggle="tooltip" title="'.tr("LIST_SELECTED").'"
		                    >'.$item['newsletter_name'].'</a></td>':
		                    '<td style="text-align:center;padding:14px;"><a href="?list_id='.$item['list_id'].'&token='.$token.'" data-toggle="tooltip" title="'.tr("CHOOSE_THIS_LIST").'">'.$item['newsletter_name'].'</a></td>');
		                echo '<td style="text-align:center;padding:14px;">'. $TrueSub=getSubscribersNumbers($cnx,$row_config_globale['table_email'],$item['list_id']).'</td>';
		                echo '<td style="text-align:center;padding:14px;">'. getSubscribersNumbers($cnx,$row_config_globale['table_email_deleted'],$item['list_id']).'</td>';
		                $lnl = list_newsletter_last_id_send($cnx,$row_config_globale['table_send'],$item['list_id'],$row_config_globale['table_archives']);
		                if (count($lnl)>0) {
		                	echo '<td style="text-align:center;padding:14px;"><a data-toggle="tooltip" title="' . $lnl[0]['subject'] . '">' . $lnl[0]['id_mail'] . '</a></td>';
		               	} else {
		               		echo '<td></td>';
		               	}
		                echo '<td style="text-align:center;padding:8px;">';
		                if( is_file ( "logs/__SEND_PROCESS__" . $item['list_id'] . ".pid" ) ) {
		                    echo '<a href="?page=listes&l=l&action=stopsend&list_id='.$item['list_id'].'&token='.$token.'" data-toggle="tooltip" title="' .tr("CLICK_STOP_SEND").' ?" onclick="return confirm(\'' .tr("WARNING_STOP_SEND").' ?\')">';
		                    echo '<span class="glyphicon glyphicon-remove-sign" style="font-size:24px;color:red;"></span>';
		                    echo '</a>';
		                }
		                echo '</td>';
		                echo '<td style="text-align:center;"><a href="?page=listes&l=l&action=duplicate&list_id='.$item['list_id'].'&token='.$token.'" data-toggle="tooltip" title="'.tr("LIST_DUPLICATE").' ?" onclick="return confirm(\''.tr("LIST_DUPLICATE").' ?\')"><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-copy"></span></button></td>';
		                echo '<td style="text-align:center;"><input type="checkbox" data-toggle="tooltip" class="mx" title="'.tr("LIST_MIX_DETAIL").'" name="mix_list_id[]" value="'.$item['list_id'].'" /></td>';
		                echo '<td style="text-align:center;"><a href="?page=listes&l=l&action=empty&list_id='.$item['list_id'].'&token='.$token.'" data-toggle="tooltip" title="Vider cette liste ?" onclick="return confirm(\'' .tr("WARNING_EMPTY_LIST").' ?\')"><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-erase"></span></button></a></td>';
		                echo '<td style="text-align:center;"><a href="?page=newsletterconf&list_id='.$item['list_id'].'&token='.$token.'" data-toggle="tooltip" title="' . tr("NEWSLETTER_CONFIGURATION") . '"><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-cog"></span></button></a></td>';
		                echo '<td style="text-align:center;"><a href="?page=listes&l=l&action=delete&list_id='.$item['list_id'].'&token='.$token.'" data-toggle="tooltip" title="'.tr("DELETE_THIS_LIST").' ?" onclick="return confirm(\''.tr("WARNING_DELETE_LIST").' ?\')"><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-trash"></span></button></a></td>';
		                echo '</tr>';
		    	} elseif(($_SESSION['dr_listes']=='N'||$_SESSION['dr_is_user']==true)&&$_SESSION['dr_liste']==$item['list_id']) {
		    		echo '<tr>';
		                //echo '<td style="text-align:center;padding:14px;">'. ($item['list_id']==$list_id?"<b>$list_id</b>":$item['list_id']) .'</td>';
		                echo ($item['list_id']==$list_id?
		                    '<td style="text-align:center;background-color:rgb(22,167,101);padding:14px;"><a href="?list_id='.$item['list_id'].'&token='.$token.'" style="color:rgb(255,255,255);font:12px arial,sans-serif;margin-top:15px" data-toggle="tooltip" title="'.tr("LIST_SELECTED").'"
		                    >'.$item['newsletter_name'].'</a></td>':
		                    '<td style="text-align:center;padding:14px;"><a href="?list_id='.$item['list_id'].'&token='.$token.'" data-toggle="tooltip" title="'.tr("CHOOSE_THIS_LIST").'">'.$item['newsletter_name'].'</a></td>');
		                echo '<td style="text-align:center;padding:14px;">'. $TrueSub=getSubscribersNumbers($cnx,$row_config_globale['table_email'],$item['list_id']).'</td>';
		                echo '<td style="text-align:center;padding:14px;">'. getSubscribersNumbers($cnx,$row_config_globale['table_email_deleted'],$item['list_id']).'</td>';
		                $lnl = list_newsletter_last_id_send($cnx,$row_config_globale['table_send'],$item['list_id'],$row_config_globale['table_archives']);
		                echo '<td style="text-align:center;padding:14px;"><a data-toggle="tooltip" title="'.$lnl[0]['subject'].'">'. $lnl[0]['LAST_CAMPAIGN_ID'] .'</a></td>';
		                echo '<td style="text-align:center;padding:8px;">';
		                if( is_file ( "logs/__SEND_PROCESS__" . $item['list_id'] . ".pid" ) ) {
		                    echo '<a href="?page=listes&l=l&action=stopsend&list_id='.$item['list_id'].'&token='.$token.'" data-toggle="tooltip" title="' .tr("CLICK_STOP_SEND").' ?" onclick="return confirm(\'' .tr("WARNING_STOP_SEND").' ?\')">';
		                    echo '<span class="glyphicon glyphicon-remove-sign" style="font-size:24px;color:red;"></span>';
		                    echo '</a>';
		                } else {
		                	echo 'Pas d\'envoi en cours';
		                }
		                echo '</td>';
		                echo '<td></td>';
		                echo '</tr>';
	                } elseif(($_SESSION['dr_listes']=='N'||$_SESSION['dr_is_user']==true)&&$_SESSION['dr_liste']=='') {
		    		echo '<tr>';
		                //echo '<td style="text-align:center;padding:14px;">'. ($item['list_id']==$list_id?"<b>$list_id</b>":$item['list_id']) .'</td>';
		                echo ($item['list_id']==$list_id?
		                    '<td style="text-align:center;background-color:rgb(22,167,101);padding:14px;"><a href="?list_id='.$item['list_id'].'&token='.$token.'" style="color:rgb(255,255,255);font:12px arial,sans-serif;margin-top:15px" data-toggle="tooltip" title="'.tr("LIST_SELECTED").'"
		                    >'.$item['newsletter_name'].'</a></td>':
		                    '<td style="text-align:center;padding:14px;"><a href="?list_id='.$item['list_id'].'&token='.$token.'" data-toggle="tooltip" title="'.tr("CHOOSE_THIS_LIST").'">'.$item['newsletter_name'].'</a></td>');
		                echo '<td style="text-align:center;padding:14px;">'. $TrueSub=getSubscribersNumbers($cnx,$row_config_globale['table_email'],$item['list_id']).'</td>';
		                echo '<td style="text-align:center;padding:14px;">'. getSubscribersNumbers($cnx,$row_config_globale['table_email_deleted'],$item['list_id']).'</td>';
		                $lnl = list_newsletter_last_id_send($cnx,$row_config_globale['table_send'],$item['list_id'],$row_config_globale['table_archives']);
		                echo '<td style="text-align:center;padding:14px;"><a data-toggle="tooltip" title="'.@$lnl[0]['subject'].'">'. @$lnl[0]['LAST_CAMPAIGN_ID'] .'</a></td>';
		                echo '<td style="text-align:center;padding:8px;">';
		                if( is_file ( "logs/__SEND_PROCESS__" . $item['list_id'] . ".pid" ) ) {
		                    echo '<a href="?page=listes&l=l&action=stopsend&list_id='.$item['list_id'].'&token='.$token.'" data-toggle="tooltip" title="' .tr("CLICK_STOP_SEND").' ?" onclick="return confirm(\'' .tr("WARNING_STOP_SEND").' ?\')">';
		                    echo '<span class="glyphicon glyphicon-remove-sign" style="font-size:24px;color:red;"></span>';
		                    echo '</a>';
		                } else {
		                	echo 'Pas d\'envoi en cours';
		                }
		                echo '</td>';
		                echo '<td></td>';
		                echo '</tr>';
	                }
	            }
            echo '</table>';
            echo '<div id="submitMix" style="display:none;margin-bottom:10px;margin-top:10px;" align="center">';
            echo '<input type="submit" class="btn btn-primary" id="sbmix" value="'.tr("LIST_MIX_TITLE").'" disabled>';
            echo '<input type="hidden" name="action" value="mix">';
            echo '<input type="hidden" name="l" value="l">';
            echo '<input type="hidden" name="page" value="listes">';
            echo '<input type="hidden" name="token" value="'.$token.'">';
            echo '</div></form>';
        } elseif($list_name == -1) {
            $error_list = true;
        } elseif(empty($list) && $page != "newsletterconf" && $page != "config") {
            echo "<div align='center' class='tooltip critical'>".tr("ERROR_NO_NEWSLETTER_CREATE_ONE")."</div>";
            $error_list = true;
            exit();
        } else {
            // dummy !
        }
    break;
    case 'c':
        echo "<form action='' method='post'>";
        echo '<div class="row">';
        echo '<div class="col-md-10">';
        echo "<header><h4>".tr("NEWSLETTER_CREATE")."</h4></header>
        <input type='hidden' name='op' value='createConfig' />
        <input type='hidden' name='token' value='$token' />
        <div class='form-group'><label>".tr("NEWSLETTER_NAME")." : </label>
        <input type='text' name='newsletter_name' value='' class='form-control'/></div>
        <div class='form-group'><label>".tr("NEWSLETTER_FROM_NAME")." : </label>
        <input type='text' name='from_name' value='".htmlspecialchars($row_config_globale['admin_name'])."' class='form-control' /></div>
        <div class='form-group'><label>".tr("NEWSLETTER_FROM_ADDR")." : </label>
        <input type='text' name='from' value='".$row_config_globale['admin_email']."' class='form-control' /></div>
        <div class='form-group'><label>Adresse électronique pour preview : </label>
        <input type='text' name='preview_addr' value='".$row_config_globale['admin_email']."' class='form-control' /></div>
        <div class='form-group'><label>".tr("NEWSLETTER_SUBJECT")." : </label>
        <input type='text' name='subject' value='' class='form-control' /></div>
        <div class='form-group'><label>".tr("NEWSLETTER_HEADER")." : </label>
        <textarea class='editme' name='header' rows='15' id='NEWSLETTER_DEFAULT_HEADER'>".tr("NEWSLETTER_DEFAULT_HEADER")."</textarea></div>
        <div class='form-group'><label>".tr("NEWSLETTER_FOOTER")." : </label>
        <textarea class='editme' name='footer' rows='15' id='NEWSLETTER_DEFAULT_FOOTER'>".tr("NEWSLETTER_DEFAULT_FOOTER")."</textarea></div>
        <div class='form-group'><label>".tr("NEWSLETTER_SUB_MSG_SUBJECT")." : </label>
        <input type='text' name='subscription_subject' value='".htmlspecialchars(tr("NEWSLETTER_SUB_DEFAULT_SUBJECT"))."' /></div>
        <div class='form-group'><label>".tr("NEWSLETTER_SUB_MSG_BODY")." : </label>
        <textarea class='editme' name='subscription_body' rows='15' id='NEWSLETTER_SUB_DEFAULT_BODY'>".tr("NEWSLETTER_SUB_DEFAULT_BODY")."</textarea></div>
        <div class='form-group'><label>".tr("NEWSLETTER_WELCOME_MSG_SUBJECT")." : </label>
        <input type='text' name=' welcome_subject' value='".htmlspecialchars(tr("NEWSLETTER_WELCOME_DEFAULT_SUBJECT")) ."' /></div>
        <div class='form-group'><label>".tr("NEWSLETTER_WELCOME_MSG_BODY")." : </label>
        <textarea class='editme' name='welcome_body' rows='15' id='NEWSLETTER_WELCOME_DEFAULT_BODY'>".tr("NEWSLETTER_WELCOME_DEFAULT_BODY"). "</textarea></div>
        <div class='form-group'><label>".tr("NEWSLETTER_UNSUB_MSG_SUBJECT")." : </label>
        <input type='text' name=' quit_subject' value='".htmlspecialchars(tr("NEWSLETTER_UNSUB_DEFAULT_SUBJECT"))."' /></div>
        <div class='form-group'><label>".tr("NEWSLETTER_UNSUB_MSG_BODY")." : </label>
        <textarea class='editme' name='quit_body' rows='15' id='NEWSLETTER_UNSUB_DEFAULT_BODY'>".tr("NEWSLETTER_UNSUB_DEFAULT_BODY")."</textarea></div>
        <script>tinymce.init({
            selector: 'textarea.editme',
            skin : 'pmnl',
            plugins: [
                'fullscreen fullpage visualblocks, preview searchreplace print insertdatetime hr',
                'charmap  anchor code link image paste pagebreak table contextmenu',
                'filemanager table code media autoresize textcolor emoticons template'
            ],
            toolbar1 : 'newdocument,template,print,bold,italic,underline,alignleft, aligncenter, alignright, alignjustify,strikethrough,superscript,subscript,forecolor,backcolor,bullist,numlist,outdent,indent,visualchars,visualblocks,charmap,hr,',
            toolbar2 : 'table,cut,copy,paste,searchreplace,blockquote,undo,redo,link,unlink,anchor,image,emoticons,media,inserttime,preview,fullscreen,code,',
            toolbar3 : 'styleselect,formatselect,fontselect,fontsizeselect,',
            style_formats: [
                {title: 'Open Sans', inline: 'span', styles: { 'font-family':'Open Sans'}},
                {title: 'Arial', inline: 'span', styles: { 'font-family':'arial'}},
                {title: 'Book Antiqua', inline: 'span', styles: { 'font-family':'book antiqua'}},
                {title: 'Comic Sans MS', inline: 'span', styles: { 'font-family':'comic sans ms,sans-serif'}},
                {title: 'Courier New', inline: 'span', styles: { 'font-family':'courier new,courier'}},
                {title: 'Georgia', inline: 'span', styles: { 'font-family':'georgia,palatino'}},
                {title: 'Helvetica', inline: 'span', styles: { 'font-family':'helvetica'}},
                {title: 'Impact', inline: 'span', styles: { 'font-family':'impact,chicago'}},
                {title: 'Symbol', inline: 'span', styles: { 'font-family':'symbol'}},
                {title: 'Tahoma', inline: 'span', styles: { 'font-family':'tahoma'}},
                {title: 'Terminal', inline: 'span', styles: { 'font-family':'terminal,monaco'}},
                {title: 'Times New Roman', inline: 'span', styles: { 'font-family':'times new roman,times'}},
                {title: 'Verdana', inline: 'span', styles: { 'font-family':'Verdana'}}
            ],                        
            templates : [ ";
            $tPath = ($row_config_globale['path']=='/'?$row_config_globale['path']:'/'.$row_config_globale['path']) . "js/tinymce/templates/";
            echo "
                {title: 'Simple Responsive Theme PhpMyNewsLetter',url: '"    . $tPath . "pmnl/simple.html',description: 'A very simple and responsive theme'},
                {title: 'Cerberus Template Fluid',url: '"    . $tPath . "cerberus/cerberus-fluid.html',description: 'Cerberus : http://tedgoas.github.io/Cerberus/#fluid'},
                {title: 'Cerberus Template Responsive',url: '" . $tPath . "cerberus/cerberus-responsive.html',description: 'Cerberus : http://tedgoas.github.io/Cerberus/#responsive'},
                {title: 'Cerberus Template Hybrid',url: '"     . $tPath . "cerberus/cerberus-hybrid.html',description: 'Cerberus : http://tedgoas.github.io/Cerberus/#hybrid'},
                {title: 'Antwort Single-column',url: '"        . $tPath . "antwort/single-column.html',description: 'Antwort, Responsive Layouts for Email : https://github.com/InterNations/antwort'},
                {title: 'Antwort Two Cols Simple',url: '"      . $tPath . "antwort/two-cols-simple.html',description: 'Antwort, Responsive Layouts for Email : https://github.com/InterNations/antwort'},
                {title: 'Antwort Three Cols Image',url: '"     . $tPath . "antwort/three-cols-images.html',description: 'Antwort, Responsive Layouts for Email : https://github.com/InterNations/antwort'},
                {title: 'Lee Munroe Simple Email',url: '"      . $tPath . "leemunroe/really-simple-responsive-email-template.html', description: 'Really Simple Responsive HTML Email Template : https://github.com/leemunroe'},
            ],
            cleanup : true,
            cleanup_on_startup : true,
            convert_urls : true,
            custom_undo_redo_levels : 20,
            doctype : '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">',
            entity_encoding : 'named',
            external_filemanager_path:'".($row_config_globale['path']=='/'?$row_config_globale['path']:'/'.$row_config_globale['path'])."js/tinymce/plugins/filemanager/',
            external_plugins: { 'filemanager' : '".($row_config_globale['path']=='/'?$row_config_globale['path']:'/'.$row_config_globale['path'])."js/tinymce/plugins/filemanager/plugin.min.js'},
            extended_valid_elements: 'pre[*],style[*]',
            filemanager_title:'Responsive Filemanager' ,
            fontsize_formats : '8px 9px 10px 11px 12px 13px 14px 18px 24px',
            forced_root_block : false,
            force_br_newlines : true,
            force_p_newlines : false,
            height : '350',
            autoresize_max_height: 800,
            image_advtab: true ,
            inline_styles : true,
            language : '".tr("TINYMCE_LANGUAGE")."',
            relative_urls: false,
            remove_script_host : false,
            theme: 'modern',
            valid_children : '+body[style|section|title],pre[section|div|p|br|span|img|style|h1|h2|h3|h4|h5],+*[*]',
            valid_elements : '+*[*]',
            verify_html : false,
            menu: {
                edit: {title: 'Edit', items: 'undo redo | cut copy paste | selectall'},
                insert: {title: 'Insert', items: 'media image link | pagebreak'},
                view: {title: 'View', items: 'visualaid'},
                format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
                table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
                tools: {title: 'Tools', items: 'code'}
            }
        });
        </script>";
        echo '</div>';
	echo '<div class="col-md-2">';
	echo '<div class="content-box fixed">';
        echo '<header><h4>Actions :</h4></header>';
        echo "<input type='submit' value=\"".tr("NEWSLETTER_SAVE_NEW")."\"  class='btn btn-success' />";
        echo "<input type='hidden' name='page' value='listes' />";
        echo "<input type='hidden' name='token' value='$token' />";
        echo '</form>';
        echo '</div>';
	echo '</div>';
    break;
}



