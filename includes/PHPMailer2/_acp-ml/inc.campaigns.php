<?php
/*~ _acp-ml/inc.campaigns.php
.---------------------------------------------------------------------------.
|  Software: PHPMailer-ML - PHP mailing list                                |
|   Version: 1.7.1                                                          |
|   Contact: via sourceforge.net support pages (also www.codeworxtech.com)  |
|      Info: http://phpmailer.sourceforge.net                               |
|   Support: http://sourceforge.net/projects/phpmailer/                     |
| ------------------------------------------------------------------------- |
|    Author: Andy Prevost (project admininistrator)                         |
| Copyright (c) 2004-2009, Andy Prevost. All Rights Reserved.               |
| ------------------------------------------------------------------------- |
|   License: Distributed under the General Public License (GPL)             |
|            (http://www.gnu.org/licenses/gpl.html)                         |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
| ------------------------------------------------------------------------- |
| We offer a number of paid services (www.codeworxtech.com):                |
| - Web Hosting on highly optimized fast and secure servers                 |
| - Technology Consulting                                                   |
| - Oursourcing (highly qualified programmers and graphic designers)        |
'---------------------------------------------------------------------------'

/**
 * PHPMailer-ML - PHP mailing list manager
 * @package PHPMailer-ML
 * @author Andy Prevost
 * @copyright 2004 - 2009 Andy Prevost. All Rights Reserved.
 */

defined('_WRX') or die( _errorMsg('Restricted access') );

echo '<div align="center">';
echo '<br />';

if ($_POST['frmWhichList']) {
  $def_list = $_POST['frmWhichList'];
  $_SESSION['def_list'] = $def_list;
}

if ($_GET['proc'] == "del") {
  foreach ($_POST['frmDelete'] as $key => $value) {
    $query = "DELETE FROM " . $phpml['dbMsgs'] . "
                WHERE msgid = $key";
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    echo $PHPML_LANG["campaign"] . " ID " . $key  . " " .$PHPML_LANG["deleted"] . "<br>";
  }
  echo '<meta http-equiv="refresh" content="3;url=index.php?pg=campaigns" />';
} elseif ($_POST['sendemail'] || $_POST['savenosend']) {
  if ($_POST['sendemail']) {
    $query  = "SELECT *
                 FROM " . $phpml['dbLists'] . "
                WHERE listid    = " . $_SESSION['def_list'];
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    $row = mysql_fetch_assoc($result);
    $phpml['FromName'] = $row['listowner'];
    $phpml['FromAddy'] = $row['listemail'];
    _load_PHPMailer();
    $mail = new MyMailer;
    $mail->Subject = stripslashes($_POST['emailtitle']);
    $message_org   = stripslashes(stripslashes($_POST['frmEditor'])) . "</div>";
    $query  = "SELECT *
                 FROM " . $phpml['dbMembers'] . "
                WHERE listid = '" . $_SESSION['def_list'] . "'
                  AND confirmed = '1'
                  AND deleted   = '0'";
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    $num    = mysql_num_rows($result);

    $x_ok                = 0;     // current count of sent in emails processed
    $x_errors            = 0;     // current count of errors in emails processed
    $xi                  = 0;     // current count of emails processed
    $width               = 0;     //  the starting width of the progress bar
    $percentage          = 0;     //  the starting percentage (should always be zero)
    $total_iterations    = $num;  //  the number of emails to sent (total)
    $width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration, based on width of progress bar div
    ?>
    <style>
    .progress_wrapper {
      width:300px;
      border:1px solid #000;
      position:absolute;
      top:20px;
      left:20px;
      height:20px;
    }
    .progress {
      height:20px;
      background: #fff url('appimgs/progress.gif');
      color:#000;
      text-align:center;
      font: 11px/20px Arial, Helvetica, sans-serif;
    }
    </style>
    <?php
    ob_start();

    while ( $row = mysql_fetch_assoc($result) ) {
      $fullName = '';
      if ( $row['firstname'] ) {
        $fullName .= " " . $row['firstname'];
      }
      if ( $row['lastname'] ) {
        $fullName .= " " . $row['lastname'];
      }
      $fullName = trim($fullName);
      if ($phpml['useBcc']) {
        $mail->AddBcc($row['email']);
      } else {
        if ( $fullName ) {
          $mail->AddAddress($row['email'], $fullName);
        } else {
          $mail->AddAddress($row['email']);
        }
      }
      // build and personalize the message
      $message         = $message_org;
      $unsubscribeLink = $phpml['url_root'] . '/index.php?pg=d&action=unsubscribe&mid=' . $row['memberid'] . '&nid=' . md5($row['email']);
      $message         = preg_replace('/{unsubscribe}/i', $unsubscribeLink, $message);
      $message         = preg_replace('/%7Bunsubscribe%7D/i', $unsubscribeLink, $message);
      $message         = preg_replace('/%%unsubscribe%%/i', $unsubscribeLink, $message);
      $message         = preg_replace('/{firstname}/i',  $row['firstname'], $message);
      $message         = preg_replace('/%7Bfirstname%7D/i', $row['firstname'], $message);
      $message         = preg_replace('/%%firstname%%/i', $row['firstname'], $message);
      $message         = preg_replace('/{lastname}/i', $row['lastname'],  $message);
      $message         = preg_replace('/%7Blastname%7D/i', $row['lastname'], $message);
      $message         = preg_replace('/%%lastname%%/i', $row['lastname'], $message);
      $message         = preg_replace('/{ip}/i', $row['IP'], $message);
      $message         = preg_replace('/%7Bip%7D/i', $row['IP'], $message);
      $message         = preg_replace('/%%ip%%/i', $row['IP'], $message);
      $message         = preg_replace('/{remote_host}/i', $row['RH'], $message);
      $message         = preg_replace('/%7Bremote_host%7D/i', $row['RH'], $message);
      $message         = preg_replace('/%%remote_host%%/i', $row['RH'], $message);
      $message         = preg_replace('/{reg_date}/i', date("F j, Y, g:i a", $row['regdate']), $message);
      $message         = preg_replace('/%7Breg_date%7D/i', date("F j, Y, g:i a", $row['regdate']), $message);
      $message         = preg_replace('/%%reg_date%%/i', date("F j, Y, g:i a", $row['regdate']), $message);

      $h2t     =& new html2text($message);
      $textmsg = $h2t->get_text();

      if ($_POST['frmFormat'] == 'textonly') {
        $mail->Body      = $textmsg;
      } else {
        $mail->MsgHTML($message);
        $mail->AltBody    = $textmsg; //"To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
      }

      // now send it
      if(!$mail->Send()) {
        $x_errors++;
        echo $PHPML_LANG["error_sending"] . " to:" . $row['email'] . "<br /><br /><b>" . $mail->ErrorInfo . "<br /><br /></b>";
      } else {
        $x_ok++;
      }
      if ($num > 1) {
        $mail->ClearAddresses();
        $mail->ClearCCs();
        $mail->ClearBCCs();
        $mail->ClearReplyTos();
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
        $mail->ClearCustomHeaders();
      }
      $xi++;
      if ( isset($phpml['progressmin']) ) {
        $minProgressDisplay = $phpml['progressmin'];
      } else {
        $minProgressDisplay = 25;
      }
      if ($num > $minProgressDisplay) {
        $width += $width_per_iteration;
        // update progress bar
        $thisPercentage = ($width/300)*100;
        echo '<div class="progress_wrapper">';
        echo '<div class="progress" style="width:' . $width . 'px;">' .
          sprintf("%01.0f", $thisPercentage) .
          '%</div>';
        echo '</div>';
        ob_flush();
        flush();
        // END - update progress bar
      }
    }
    echo "<br /><br />Done ... redirecting<br />";
    sleep(3);
    // progress bar finished, now reload the page
    ?>
    <form name="formprogress" method="post">
    <input type="hidden" name="total_emails_processed" value="<?php echo $xi; ?>">
    <input type="hidden" name="total_emails_sent" value="<?php echo $x_ok; ?>">
    <input type="hidden" name="total_errors" value="<?php echo $x_errors; ?>">
    </form>
    <SCRIPT language="JavaScript">
    document.formprogress.submit();
    </SCRIPT>
    <?php
    /*
    echo "<br /><br />done<br />";
    echo 'total_emails_processed: ' . $xi . '<br />';
    echo 'total_emails_sent: ' . $x_ok . '<br />';
    echo 'total_errors: ' . $x_errors . '<br />';
    die();
    */
  }
  if ($_POST['frmFormat'] == 'textonly') {
    $tformat = 'T';
  } else {
    $tformat = 'H';
  }
  if ($_POST['frmMsgId'] != '') {
    $message = str_replace('&gt;','>',$_POST['frmEditor']);
    $message = str_replace('&lt;'.'<',$message);
    $query = "UPDATE " . $phpml['dbMsgs'] . "
                 SET subject = '" . addslashes($_POST['emailtitle']) . "',
                     body    = '" . addslashes($message) . "',
                     format  = '" . $tformat . "',
                     sent    = '" . time() . "',
                     listid  = '" . $_POST['frmWhichList'] . "'
               WHERE msgid   = " . $_POST['frmMsgId'];
  } else {
    $query = "INSERT INTO " . $phpml['dbMsgs'] . "
                (subject,body,
                 format,sent,
                 listid)
              VALUES
                ('" . addslashes($_POST['emailtitle']) . "','" . addslashes($message) . "',
                 '" . $tformat . "','" . time() . "',
                 '" . $_POST['frmWhichList'] . "')";
  }
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  if ($_POST['sendemail']) {
    echo $PHPML_LANG["sent"] . " (" . $xi . ") ... ";
  }
  echo "<a href=\"index.php?pg=campaigns\">" . $PHPML_LANG["click_continue"] . "</a><br />";
} elseif ( $_GET['proc'] == "add" ) {
  $path        = $phpml['path_admin'] . '/rsrcs/tpl';
  $pathPreview = 'rsrcs/tpl';
  $dir_handle = @opendir($path) or die("Unable to open template directory<br />");
  echo "Select the template you wish to use<br /><br />";
  while ( $file = readdir($dir_handle) ) {
    if ( $file != "." && $file != ".." ) {
      $dirArray[] = $file;
    }
  }
  asort($dirArray);
  closedir($dir_handle);

  echo '<table border="0" cellspacing="1" cellpadding="0" id="table1">';
  echo '<tr>';
  echo '<td valign="top">';
  $noPreview = $pathPreview . '/nopreview.jpg';
  foreach ($dirArray as $key => $value) {
    if ( is_dir($pathPreview . '/' . $value) ) {
      $previewImg = $pathPreview . '/' . $value . '/preview.jpg';
      $previewDef = $pathPreview . '/preview.jpg';
      if ( file_exists($previewImg) ) {
        $imgPreview = $previewImg;
      } else {
        $imgPreview = $previewDef;
      }
      echo '<a style="text-decoration:underline;" href="index.php?pg=campaigns&proc=edit&tid=' . $value . '" onMouseOver="document.tplImage.src=\'' . $imgPreview . '\';" onMouseOut="document.tplImage.src=\'' . $noPreview . '\';">';
      echo $value . "</a><br />\n";
    }
  }
  echo '</td>';
  echo '<td><div style="width:20px;"></div></td>';
  echo '<td width="250" valign="top"><img src="' . $noPreview . '" name="tplImage"></td>';
  echo '</tr>';
  echo '</table>';
} elseif ( $_GET['proc'] == "edit" ) { // section to exit existing campaign
  if ( $_GET['tid'] ) {
    // copy the image to the SPAW upload directory
    $fromDir = $phpml['path_admin'] . '/rsrcs/tpl/' . $_GET['tid'];
    // get a list of all images and copy them
    $dir_handle = @opendir($fromDir) or die("Unable to open template directory<br />");
    while ( $file = readdir($dir_handle) ) {
      if ( $file != "." && $file != ".." ) {
        $extArry  = split('\.',$file);
        $extCount = count($extArry) - 1;
        if ( $extArry[$extCount] == 'png' || $extArry[$extCount] == 'jpg' || $extArry[$extCount] == 'jpeg' || $extArry[$extCount] == 'gif' ) {
          if ( $extArry[0] != 'preview' ) {
            // copy image to $phpml['userdir'], excluding the preview
            copy($fromDir . '/' . $file, $phpml['userdir'] . '/' . $file);
          }
        }
        if ( $extArry[$extCount] == 'htm' || $extArry[$extCount] == 'html' ) {
          if ( $extArry[0] == 'index' ) {
            // read file and get contents, then add to database as a new campaign
            $body    = addslashes(file_get_contents($fromDir . '/' . $file));
            if ( $_GET['tid'] == 'newsletter' ) {
              $body = str_replace('newsletter.png',$phpml['userURL'].'/newsletter.png',$body);
            }
            $subject = $_GET['tid'] . ' copy';
            $format  = 'H';
            $listid  = '1';
            $sql = "INSERT INTO " . $phpml['dbMsgs'] . "
                      (subject, body, format,listid)
                    VALUES
                      ('" . $subject . "','" . $body . "','" . $format . "','" . $listid . "')";
            $result = mysql_query($sql);
            $_GET['id'] = mysql_insert_id();
          }
        }
      }
    }
    closedir($dir_handle);
  }
  if ($_GET['id'] != '') {
    $query  = "SELECT *
                 FROM " . $phpml['dbMsgs'] . "
                WHERE msgid    = " . $_GET['id'];
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    $row    = mysql_fetch_assoc($result);
    $dbMsgID      = $row['msgid'];
    $dbSubject    = $row['subject'];
    $dbMessage    = $row['body'];
    $dbFormat     = $row['format'];
    if ($dbFormat == "T") {
      $dbFormat = "Text Only";
    } else {
      $dbFormat = "HTML and Text";
    }
    $dbSent       = $row['sent'];
    $dbListID     = $row['listid'];
  }
  ?>
  <div class="tpl_table">
    <table class="tpl_listing tpl_form" width="98%" cellpadding="0" cellspacing="0">
      <tr><form action="index.php?pg=campaigns" method="post">
        <?php
        if ($dbListID != '') {
          echo '<input type="hidden" name="frmMsgId" value="' . $dbMsgID . '">';
        }
        ?>
        <th class="full" colspan="2"><?php echo $PHPML_LANG["compose_message"]; ?></th>
      </tr>
      <?php
      $sEditSubject = $dbSubject;
      if (isset($sEditSubject)) {
        $subject = $sEditSubject;
      } else {
        $subject = $PHPML_LANG["subject"];
      }
      $sEditMessage = $dbMessage;
      if (isset($sEditMessage)) {
        $message = $sEditMessage;
      } else {
        if (file_exists($phpml['path_root'] . "/" . $_SESSION['acp'] . "/defemail.html")) {
          $message = file_get_contents($phpml['path_root'] . "/" . $_SESSION['acp'] . "/defemail.html");
          $message = str_replace('newsletter.png', $phpml['url_admin'] . '/newsletter.png', $message);
        } else {
          $message = "Dear {firstname} {lastname},\n\nMy message to you is ...\n\n-------------------------------------\n<a href=\"{unsubscribe}\">Unsubscribe</a>\nYou registered on {reg_date} using IP address {ip} from remote host {remote_host}.";
        }
      }
      if ($phpml['path_base'] != '') {
        $defEdPath = '/' . $phpml['path_base'];
      } else {
        $defEdPath = '';
      }

      if ( $phpml['editorincl'] != '' ) {
        include($phpml['editorincl']);
      }
      echo "<tr>";
      echo "<td class=\"first\" valign=\"top\">" . $PHPML_LANG["which_list"] . "</td>\n";
      echo "<td class=\"last\">";
      $whichList = _getList($dbListID);
      echo $whichList;
      echo "</td>\n";
      echo "</tr>";

      echo "<tr>";
      echo "<td class=\"first\">" . $PHPML_LANG["subject"] . "</td>\n";
      echo "<td class=\"last\">";
      echo "<input style=\"width:98%;\" type=\"text\" name=\"emailtitle\" size=\"80\" value=\"" . htmlspecialchars(stripslashes($subject)) . "\"></input>";
      echo "</td>\n";
      echo "</tr>";

      echo "<tr>";
      echo "<td colspan=\"2\" class=\"last\">";
      echo $phpml['editor'] . '<br />';
      if ( $phpml['editor'] == 'spaw2' ) {
        $spaw = new SpawEditor("frmEditor", stripslashes($message));
        $spaw->show();
      } elseif ( $phpml['editor'] == 'ckeditor' ) {
        echo $phpml['editorinit'];
        echo '<textarea name="frmEditor" id="frmEditor" style="width: 100%; height: 200px; overflow: scroll;" rows="10" cols="10">' . stripslashes($message) . '</textarea>' . "\n";
        //echo '<textarea name="frmEditor" id="frmEditor" style="width: 100%; height: 200px; overflow: scroll;" rows="10" cols="10"></textarea>' . "\n";
        echo '<script type="text/javascript">' . "\n";
        echo '//<![CDATA[' . "\n";
        if ( $phpml['filemgr'] == 'kfm' ) {
          echo '  CKEDITOR.replace(\'frmEditor\',{' . "\n";
          echo '    filebrowserBrowseUrl: "' . $phpml['kfmpath'] . '",' . "\n";
          echo "    toolbar:[";
          echo "['NewPage','Preview'],['Cut','Copy','Paste','PasteText','PasteFromWord'],['Undo','Redo','-','SelectAll','RemoveFormat'],['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],['Image'],'/',";
          echo "['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['Link','Unlink','Anchor'],['Table','HorizontalRule','SpecialChar'],'/',";
          echo "['Styles','Format','Font','FontSize'],['TextColor','BGColor'],['ShowBlocks','-','Source','-','Maximize']";
          echo "]\n";
          echo '  });' . "\n";
        } else {
          echo '  CKEDITOR.replace(\'frmEditor\',{' . "\n";
          echo "    toolbar:[";
          echo "['NewPage','Preview'],['Cut','Copy','Paste','PasteText','PasteFromWord'],['Undo','Redo','-','SelectAll','RemoveFormat'],['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],['Image'],'/',";
          echo "['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['Link','Unlink','Anchor'],['Table','HorizontalRule','SpecialChar'],'/',";
          echo "['Styles','Format','Font','FontSize'],['TextColor','BGColor'],['ShowBlocks','-','Source','-','Maximize']";
          echo "]\n";
          echo '  });' . "\n";
        }
        echo '//]]>' . "\n";
        echo '</script>' . "\n";
      } elseif ( $phpml['editor'] == 'none' ) {
        $message = str_replace('>','&gt;',$message);
        $message = str_replace('<','&lt;',$message);
        echo '<textarea name="frmEditor" id="frmEditor" style="width: 100%; height: 200px; overflow: scroll;" rows="10" cols="10">' . stripslashes($message) . '</textarea>';
      }
      echo "</td>\n";
      echo "</tr>";

      echo "<tr>";
      echo "<td class=\"first\" valign=\"top\">" . $PHPML_LANG["email_format"] . "</td>\n";
      echo "<td class=\"last\">";
      echo '<select name="frmFormat">';
      echo '<option selected value="htmltext">' . $PHPML_LANG["email_htmltext"] . '</option>';
      echo '<option value="textonly">' . $PHPML_LANG["email_textonly"] . '</option>';
      echo '</select>';
      echo "</td>\n";
      echo "</tr>";

      echo "<tr class=\"bg\">";
      echo "<td colspan=\"2\" align=\"center\">";
      echo "<input type=\"submit\" name=\"savenosend\" value=\"" . $PHPML_LANG["save"] . "\">&nbsp;&nbsp;&nbsp;";
      echo "<input type=\"submit\" name=\"sendemail\" value=\"" . $PHPML_LANG["save"] . " &amp; " . $PHPML_LANG["send"] . "\">";
      echo "</td>";
      echo "</tr>";
    echo "</form></table>";
  echo "</div>";
} else {
  if ( isset($_POST['total_emails_processed']) ) {
    echo 'Emails processed: ' . $_POST['total_emails_processed'] . "<br />";
    echo 'Emails sent: ' . $_POST['total_emails_sent'] . "<br />";
    echo 'Errors: '  . $_POST['x_errors'] . "<br /><br />";
  }
  $query  = "SELECT *
               FROM " . $phpml['dbMsgs'] . "
              WHERE 1 = 1
           ORDER BY msgid DESC";
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $num    = mysql_num_rows($result);
  if ($num) {
    ?>
    <div class="tpl_table">
      <table class="tpl_listing tpl_form" width="100%" cellpadding="0" cellspacing="0">
        <tr><form action="index.php?pg=campaigns&proc=del" method="post">
          <th class="first">ID</th>
          <th><?php echo $PHPML_LANG["subject"]; ?></th>
          <th>Format</th>
          <th>Sent</th>
          <th>List</th>
          <th class="last" colspan="2">Action</th>
        </tr>
        <?php
        $intNumber = 1;
        while ( $row    = mysql_fetch_assoc($result) ) {
          $dbMsgID      = $row['msgid'];
          $dbSubject    = $row['subject'];
          $dbFormat     = $row['format'];
          if ($dbFormat == "T") {
            $dbFormat = "Text Only";
          } else {
            $dbFormat = "HTML and Text";
          }
          $dbSent       = $row['sent'];
          $dbListID     = $row['listid'];
          // get list name
          $queryl  = "SELECT *
                        FROM " . $phpml['dbLists'] . "
                       WHERE listid    = " . $dbListID;
          $resultl = mysql_query($queryl) or die($PHPML_LANG["error_query"] . mysql_error());
          $rowl = mysql_fetch_assoc($resultl);
          $rowTitle = $rowl['title'];
          echo "<tr";
          echo ($intNumber % 2 == 0 ) ? ' class="bg"' : '';
          echo ">\n";
          echo "<td class=\"first\">" . $dbMsgID;
          echo "</td>\n";
          echo "<td>" . $dbSubject . "</td>\n";
          echo "<td align=\"center\">" . $dbFormat . "</td>\n";
          echo "<td align=\"center\">";
          echo date("F j, Y", $dbSent);
          echo "</td>\n";
          echo "<td align=\"center\">";
          echo $rowTitle;
          echo "</td>\n";
          echo "<td class=\"last\" style=\"text-align:center;\"><input name=\"frmDelete[" . $dbMsgID . "]\" type=\"checkbox\" value=\"ON\"";
          echo "/></td>\n";
          echo "<td>";
          echo "<a href=\"index.php?pg=campaigns&proc=edit&id=$dbMsgID\"><img border=\"0\" src=\"appimgs/page_edit.png\"></a>";
          echo "</td>\n";
          echo "</tr>\n";
          $intNumber++;
        }
        echo "<tr";
        echo ($intNumber % 2 == 0 ) ? ' class="bg"' : '';
        echo ">\n";
        echo "<td colspan=\"9\" align=\"center\"><input type=\"submit\" name=\"redo\" value=\"" . $PHPML_LANG["deleteselected"] . "\"></td>";
        echo "</tr>";
        echo "</form></table>";
    echo "</div>";
  }
}
echo '</div>';

$pgArr['button']   = '<a href="index.php?pg=campaigns&proc=add" class="button"><img border="0" src="appimgs/add.png" title="' . $PHPML_LANG["add_new_list"] . '"></a>';
$pgArr['caption']  = $PHPML_LANG["campaigns"];
$pgArr['contents'] = ob_get_contents();
$pgArr['help']     = "{firstname}<br />
  {lastname}<br />
  {unsubscribe}<br />
  {reg_date}<br />
  {ip}<br />
  {remote_host}<br />
  are variables that will get substituted with the subscriber&#039;s data at time of sending.<br />";
ob_end_clean();
echo getSkin ($pgArr);

?>
