<?php
/***************************************************\
**   True gallery - A Joomla! Gallery Component    **
**   Copyright (C) 2008  by JoomlaForum **
**   Version    : 2.0                              **
**   Homepage   : http://true.palpalych.ru              **
**   License    : Copyright, don't distribute      **
**   Based on   : AkoGallery -> PonyGallery -> DatsoGallery Datso gallery 1.6**
\***************************************************/
defined('_VALID_MOS') or defined('_JEXEC') or die('Direct Access to this location is not allowed.');
class HTML_true
	{
	function showPictures($option, &$rows, &$clist, &$slist, &$search, &$pageNav)
		{
			global $database, $mosConfig_live_site, $mosConfig_absolute_path, $ad_thumbwidth, $ad_thumbheight;
			require_once ($mosConfig_absolute_path . "/administrator/components/com_true/config.true.php");
		?>
			<form action="index2.php" method="post" name="adminForm">
				<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminheading">
					<tr>
						<th class="mediamanager"><?php echo JText::_('TG_PICS_MANAGER_TITLE'); ?></th>
						<td nowrap="nowrap">
							<?php echo JText::_('TG_DISPLAY'); ?>
							<br/>
							<?php echo $pageNav->writeLimitBox(); ?>
						</td>
						<td>
							<?php echo JText::_('TG_SEAR'); ?>
							<br/>
							<input type="text" name="search" value="<?php echo $search; ?>" class="inputbox" onchange="document.adminForm.submit();" />
						</td>
						<td>
							<?php echo JText::_('TG_SORT_BY_CAT'); ?>
							<br/>
							<?php echo $clist; ?>
						</td>
						<td>
							<?php echo JText::_('TG_SORT_BY_TYPE'); ?>
							<br/>
							<?php echo $slist; ?>
						</td>
					</tr>
				</table>
				<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
					<tr>
						<th align="center">#ID</th>
						<th><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
						<th class="title" ><?php echo JText::_('TG_TITLE'); ?></th>
						<th align="left"><?php echo JText::_('TG_CATEGORY'); ?></th>
						<th><?php echo JText::_('TG_HITS'); ?></th>
						<th align="left"><?php echo JText::_('TG_RATING'); ?></th>
						<th><span align="center"><?php echo JText::_('TG_ORDER'); ?></span></th>
						<th>
							<span align="center"><a href="javascript: saveorder( <?php echo count($rows) - 1; ?> )">
							<img src="images/filesave.png" border="0" width="16" title="<?php echo JText::_('TG_SAVEORDER_PICS'); ?>" alt="" /></a></span>
						</th>
						<th width="4%"><?php echo JText::_('TG_PUBLISHED'); ?></th>
						<th width="4%"><?php echo JText::_('TG_APPROWED'); ?></th>
						<th width="10%"><?php echo JText::_('TG_AUTHOR_OWNER'); ?></th>
						<th width="4%"><?php echo JText::_('TG_TYPE'); ?></th>
						<th width="10%"><?php echo JText::_('TG_DATE_ADD'); ?></th>
						<th nowrap="nowrap"><?php echo JText::_('TG_METADESC'); ?></th>
						<th nowrap="nowrap"><?php echo JText::_('TG_METAKEY'); ?></th>
					</tr>
						<?php
				mosCommonHTML::loadOverlib();
				$k = 0;
				for ($i = 0, $n = count($rows); $i < $n; $i++) {
					$row = &$rows[$i];
					if($row->imgvotes > 0) {
						$fimgvotesum = number_format($row->imgvotesum / $row->imgvotes, 2, ",", ".");
						$frating = "$fimgvotesum / $row->imgvotes";
					} else {
						$frating = JText::_('TG_NO_VOTES');
					}
					$taska = $row->approved ? 'rejectpic' : 'approvepic';
					$imga = $row->approved ? 'tick.png' : 'publish_x.png';
					$task = $row->published ? 'unpublish' : 'publish';
					$img = $row->published ? 'tick.png' : 'publish_x.png';
					$database->setQuery("select id from #__users where username='$row->owner'");
					$userid = $database->loadResult();
					$imgprev = $mosConfig_live_site . $ad_path."/thumbs" . "/$row->catid/$row->imgthumbname";
					//$row->imgtitle = ereg_replace('"', '', $row->imgtitle);
					$info = getimagesize($mosConfig_absolute_path . $ad_path."/originals" . "/$row->catid/$row->imgoriginalname");
					$size = filesize($mosConfig_absolute_path . $ad_path."/originals" . "/$row->catid/$row->imgoriginalname");
					$type = array(1 => 'GIF', 2 => 'JPG', 3 => 'PNG');
					$info[2] = $type[$info[2]];
					$fsize = format_filesize($size);
					$overlib = '<table><tr><td>';
					$overlib .= JText::_('TG_ORG_WIDTH');
					$overlib .= '</td><td>: ';
					$overlib .= $info[0] . ' ' . JText::_('TG_PIXELS');
					$overlib .= '</td></tr><tr><td>';
					$overlib .= JText::_('TG_ORG_HEIGHT');
					$overlib .= '</td><td>: ';
					$overlib .= $info[1] . ' ' . JText::_('TG_PIXELS');
					$overlib .= '</td></tr><tr><td>';
					$overlib .= JText::_('TG_ORG_TYPE');
					$overlib .= '</td><td>: ';
					$overlib .= $info[2];
					$overlib .= '</td></tr><tr><td>';
					$overlib .= JText::_('TG_FILESIZE');
					$overlib .= '</td><td>: ';
					$overlib .= $fsize;
					$overlib .= '</td></tr></table>';
		?>
			<script type="text/javascript">
			<!--
			function showInfo(title, name, dimensions) {
			html = '<div style="width:100%;text-align:center;vertical-align:middle;"><img style="border:1px solid #fff;margin:20px" src='+name+' name="imagelib" alt="No Pics" /><div style="font-family:Tahoma,sans-serif;font-size:10px;text-align:left">'+dimensions+'</div></div>';
			return overlib(html, CAPTION, title, dimensions)
			}
			function editEntry(number) {
			var elm = document.getElementById('cb'+number);
			if (elm) {
			elm.checked = true;
			}
			}
			-->
			</script>
			<tr class="row<?php echo $k; ?>">
				<td><?php echo $row->id; ?></td>
				<td><input type="checkbox" id="cb<?php echo $i; ?>" name="id[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
				<td><a href="javascript:editEntry(<?php echo $i; ?>); submitform('edit');"
					onmouseover="showInfo('<?php echo jsspecialchars($row->imgtitle); ?>', '<?php echo $imgprev; ?>', '<?php echo $overlib; ?>')" onmouseout="return nd();"><b><?php echo $row->imgtitle; ?></b></a></td>
				<td><?php echo ShowCategoryPath($row->catid); ?></td>
				<td align="center"><?php echo $row->imgcounter; ?></td>
		    		<td><?php echo $frating; ?></td>
				<td align="center">
					<?php echo $pageNav->orderUpIcon($i, ($row->catid == @$rows[$i - 1]->catid)); ?>&nbsp;&nbsp;
					<?php echo $pageNav->orderDownIcon($i, $n, ($row->catid == @$rows[$i + 1]->catid)); ?>
				</td>
				<td align="center">
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align:center" />
		    	</td>
			    <td align="center">
			    	<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>','<?php echo $task; ?>')">
			    	<img src="images/<?php echo $img; ?>" border="0" alt="" /></a>
			    </td>
			    <td align="center">
			    	<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $taska; ?>')">
			    	<img src="images/<?php echo $imga; ?>" border="0" alt="" /></a></td>
				<td align="center"><b><?php echo $row->owner; ?></b></td>
				<td align="center">
					<?php if($row->useruploaded) { ?>
					<img src="../includes/js/ThemeOffice/users.png" title="<?php echo JText::_('TG_USER_UPLOAD'); ?>">
					<?php } else { ?>
					<img src="../includes/js/ThemeOffice/credits.png" title="<?php echo JText::_('TG_ADMIN_UPLOAD'); ?>">
					<?php } ?>
				</td>
				<td width="10%" align="center"><?php echo strftime("%d.%m.%Y %H:%M", $row->imgdate); ?></td>
				<?php
			    if ($row->metadesc == '') {
			    	$overlibmetadescimg = '<table><tr><td>NULL</td></tr></table>';
			    	$cmetadesc = '<img src="'.$mosConfig_live_site.'/components/com_true/images/no_download.png" alt="" onmouseover="return overlib('.$overlibmetadescimg.', BELOW, RIGHT);" onmouseout="return nd();" />';

			    } else {
			    	$overlibmetadesc = '<table><tr><td>'.$row->metadesc.'</td></tr></table>';
			    	$cmetadesc = '<img src="'.$mosConfig_live_site.'/components/com_true/images/tick.png" onmouseover="return overlib('.$overlibmetadesc.', BELOW, RIGHT);" onmouseout="return nd();" />';
			    }
			    if ($row->metakey == '') {
			    	$overlibmetakey = '<table><tr><td>NULL</td></tr></table>';
			    	$cmetakey = '<img src="'.$mosConfig_live_site.'/components/com_true/images/no_download.png" alt="" onmouseover="return overlib('.$overlibmetakey.', BELOW, RIGHT);" onmouseout="return nd();" />';

			    } else {
			    	$overlibmetakey = '<table><tr><td>'.$row->metakey.'</td></tr></table>';
			    	$cmetakey = '<img src="'.$mosConfig_live_site.'/components/com_true/images/tick.png" onmouseover="return overlib('.$overlibmetakey.', BELOW, RIGHT);" onmouseout="return nd();" />';
			    }
			    ?>
			    <td align="center"><?php echo $cmetadesc; ?></td>
			    <td align="center"><?php echo $cmetakey; ?></td>
				<?php
					$k = 1 - $k;
					echo "</tr>";
				}
				?>
		    <th align="center" colspan="15"> <?php echo $pageNav->writePagesLinks(); ?></th>
			</tr>
			<tr>
			<td align="center" colspan="15"> <?php echo $pageNav->writePagesCounter(); ?></td>
			</tr>
			</table>
			<input type="hidden" name="option" value="<?php echo $option; ?>" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			</form>
			<?php
		}
		function movePic($id, &$Lists, &$rows)
			{
				global $ad_path, $mosConfig_absolute_path, $mosConfig_live_site, $database;
				require ($mosConfig_absolute_path . '/administrator/components/com_true/config.true.php');
				?>
			    <script type="text/javascript">
			    <!--
			    function showInfo(title, name, dimensions) {
			    html = '<div style="width:100%;text-align:center;vertical-align:middle;"><img style="border:1px solid #fff;margin:20px" src='+name+' name="imagelib" alt="No Pics" /></div>';
			    return overlib(html, CAPTION, title)
			    }
			    function editEntry(number) {
			    var elm = document.getElementById('cb'+number);
			    if (elm) {
			    elm.checked = true;
			    }
			    }
			    -->
			    </script>
			    <form action="index2.php" method="post" name="adminForm" >
			    <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminheading">
				    <tr>
				    	<th class="mediamanager"><?php echo JText::_('TG_MASS_MOVING_OF_PICS'); ?></th>
				    	<td></td>
				    </tr>
				</table>
				<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
					<tr>
				 		<th width="4%">#ID</th>
				 		<th class="title" width="20%"><?php echo JText::_('TG_PICS_TO_MOVING'); ?></th>
				 		<th width="26%"><div align="left"><?php echo JText::_('TG_CURRENT_CATEGORY'); ?></div></th>
				 		<th width="50%" align="left"><?php echo JText::_('TG_ALLOWED_CAT'); ?></td>
			  		</tr>
					    <?php
						foreach ($rows as $row) {
						$imgprev = $mosConfig_live_site . $ad_path."/thumbs" . "/$row->catid/$row->imgthumbname";
						?>
			   		<tr>
						<td align="center" width="2%" style="padding:7px"><?php echo $row->id; ?>
						<td align="left" width="20%">
							<a href="javascript:void(0);"<b><?php echo $row->imgtitle; ?></b></a>
							<img src="<?php echo $imgprev; ?>" width="30%" align="left" alt="" />
						</td>
			    		<td><div align="left" width="75%"><?php echo ShowCategoryPath($row->catid); ?></div></td>
			    		<td valign="top">
                         <?php echo $Lists['catgs'] ?>
                         &nbsp;&nbsp;<?php echo mosToolTip(JText::_('TG_MOVE_TO_CATEGORY')); ?>
			    		</td>
			    	</tr>
			    		<?php } ?>
			   		<tr>
			    		<th align="center" colspan="4"></th>
			   		</tr>
				</table>
			    <input type="hidden" name="option" value="com_true" />
			    <input type="hidden" name="task" value="movepicres" />
			    <input type="hidden" name="boxchecked" value="1" />
			    <?php
					foreach ($id as $ids) {
						echo "<input type='hidden' name='id[]' value='$ids' />";
					}
					?>
			    </form>
			    <?php
			}
		function editPicture($option, &$row, &$clist, &$originallist, &$imagelist, &$thumblist,
		$ad_pathoriginals, $ad_pathimages, $ad_paththumbs, $ad_path, $ad_thumbwidth, $ad_thumbheight, $ad_imgstyle)
			{
				global $my, $mosConfig_absolute_path;
				?>
				<script type="text/javascript">
			    function submitbutton(pressbutton) {
			    var form = document.adminForm;
			    if (pressbutton == 'cancel') {
			    submitform( pressbutton );
			    return;
			    }
			    if (form.imgtitle.value == ""){
			    alert( "<?php echo JText::_('TG_PIC_ENTER_TITLE'); ?>" );
			    } else if (form.catid.value == "0"){
			    alert( "<?php echo JText::_('TG_SELECT_CAT'); ?>" );
			    } else if (form.imgoriginalname.value == ""){
			    alert( "<?php echo JText::_('TG_SELECT_ORG_PIC'); ?>" );
			    } else if (form.imgfilename.value == ""){
			    alert( "<?php echo JText::_('TG_SELECT_MED_PIC'); ?>" );
			    } else if (form.imgthumbname.value == ""){
			    alert( "<?php echo JText::_('TG_SELECT_THUMB_PIC'); ?>" );
			    } else {
			    submitform( pressbutton );
			    }
			    }
			    </script>
			    <?php global $mosConfig_live_site; ?>
					<link rel="stylesheet" type="text/css" media="all" href="<?php echo $mosConfig_live_site; ?>/includes/js/calendar/calendar-mos.css" title="green" />
					<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/includes/js/calendar/calendar.js"></script>
					<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/includes/js/calendar/lang/calendar-en.js"></script>
			    <table width="100%" border="0" cellspacing="0" cellpadding="6" class="adminform" style="table-layout: auto; white-space: nowrap;">
			    <tr>
			    <td width="50" align="left" valign="top">
				<form action="index2.php" method="post" name="adminForm" id="adminForm">
				<table cellpadding="4" cellspacing="1" border="0" width="100%">
			    <tr>
					<td width="20%"><b><?php echo JText::_('TG_TITLE'); ?>:</b></td>
					<td width="80%"><input class="inputbox" type="text" name="imgtitle" size="39" maxlength="100" value="<?php echo htmlspecialchars($row->imgtitle, ENT_QUOTES); ?>" /></td>
				</tr>
				<tr>
					<td valign="top"><b><?php echo JText::_('TG_CATEGORY'); ?>:</b></td>
					<td><?php echo $clist; ?></td>
				</tr>
				<tr>

					<td width="20%"><b><?php echo JText::_('TG_FIELD1'); ?>:</b></td>
					<td width="80%">
						<input class="inputbox" type="text" name="field1" id="field1" size="39" maxlength="100" value="<?php echo htmlspecialchars($row->field1, ENT_QUOTES); ?>" />
						<input type="reset" class="button" value="..." onClick="return showCalendar('field1', 'y-mm-dd');">
					</td>
				</tr>
				<tr>
					<td width="20%"><b><?php echo JText::_('TG_FIELD2'); ?>:</b></td>
					<td width="80%"><input class="inputbox" type="text" name="field2" size="39" maxlength="100" value="<?php echo htmlspecialchars($row->field2, ENT_QUOTES); ?>" /></td>
				</tr>
				<tr>
					<td width="20%"><b><?php echo JText::_('TG_FIELD3'); ?>:</b></td>
					<td width="80%"><input class="inputbox" type="text" name="field3" size="39" maxlength="100" value="<?php echo htmlspecialchars($row->field3, ENT_QUOTES); ?>" /></td>
				</tr>
				<tr>
					<td width="20%"><b><?php echo JText::_('TG_FIELD4'); ?>:</b></td>
					<td width="80%"><input class="inputbox" type="text" name="field4" size="39" maxlength="100" value="<?php echo htmlspecialchars($row->field4, ENT_QUOTES); ?>" /></td>
				</tr>
				<tr>
					<td width="20%"><b><?php echo JText::_('TG_FIELD5'); ?>:</b></td>
					<td width="80%"><input class="inputbox" type="text" name="field5" size="39" maxlength="100" value="<?php echo htmlspecialchars($row->field5, ENT_QUOTES); ?>" /></td>
				</tr>
				<!-- -->
				<tr>
					<td valign="top" align="right"><b><?php echo JText::_('TG_DESCRIPTION'); ?>:</b></td>
					<td>
					<?php editorArea('editor1', str_replace('&', '&amp;', $row->imgtext), 'imgtext', '500', '200', '70', '10'); ?>	</td>
				</tr>
				<tr>
					<td valign="top"><b><?php echo JText::_('TG_AUTHOR_OWNER'); ?>:</b></td>
					<td><input class="inputbox" type="text" name="imgauthor" value="<?php echo $row->imgauthor; ?>" size="39" maxlength="100" /></td>
				</tr>
				<tr>
					<td valign="top"><b><?php echo JText::_('TG_METADESC'); ?>:</b></td>
					<td><input class="inputbox" type="text" name="metadesc" value="<?php echo $row->metadesc; ?>" size="100" maxlength="200" /></td>
				</tr>
				<tr>
					<td valign="top"><b><?php echo JText::_('TG_METAKEY'); ?>:</b></td>
					<td><input class="inputbox" type="text" name="metakey" value="<?php echo $row->metakey; ?>" size="100" maxlength="200" /></td>
				</tr>
				<tr>
					<td valign="top"><b><?php echo JText::_('TG_TAGS'); ?>:</b></td>
					<td><input class="inputbox" type="text" name="tags" value="<?php echo $row->tags; ?>" size="100" maxlength="200" /></td>
				</tr>
				</table>
				<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
			    <input type='hidden' name="imgoriginalname" value="<?php echo $row->imgoriginalname; ?>" />
			    <input type='hidden' name="imgfilename" value="<?php echo $row->imgfilename; ?>" />
			    <input type='hidden' name="imgthumbname" value="<?php echo $row->imgthumbname; ?>" />
				<input type="hidden" name="option" value="<?php echo $option; ?>" />
				<input type="hidden" name="oldcatid" value="<?php echo $row->catid; ?>" />
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="owner" value="<?php if($row->owner) {
						echo $row->owner;
					} else {
						echo $my->username;
					} ?>" />
				<input type="hidden" name="approved" value="<?php if($row->approved == "") {
						echo "1";
					} else {
						echo $row->approved;
					} ?>" />
				</form>	</td>
			    <td width="50" align="left" valign="top">
			    <?php
					$info = getimagesize($mosConfig_absolute_path . $ad_path."/originals" . "/$row->catid/$row->imgoriginalname");
					$size = filesize($mosConfig_absolute_path . $ad_path."/originals" . "/$row->catid/$row->imgoriginalname");
					$type = array(1 => 'GIF', 2 => 'JPG', 3 => 'PNG');
					$info[2] = $type[$info[2]];
					$fsize = format_filesize($size);
					$orginfo = '<table>';
					$orginfo .= '<tr>';
					$orginfo .= '<td>';
					$orginfo .= JText::_('TG_ORG_WIDTH');
					$orginfo .= '</td>';
					$orginfo .= '<td>: ';
					$orginfo .= $info[0] . ' ' . JText::_('TG_PIXELS');
					$orginfo .= '</td>';
					$orginfo .= '</tr>';
					$orginfo .= '<tr>';
					$orginfo .= '<td>';
					$orginfo .= JText::_('TG_ORG_HEIGHT');
					$orginfo .= '</td>';
					$orginfo .= '<td>: ';
					$orginfo .= $info[1] . ' ' . JText::_('TG_PIXELS');
					$orginfo .= '</td>';
					$orginfo .= '</tr>';
					$orginfo .= '<tr>';
					$orginfo .= '<td>';
					$orginfo .= JText::_('TG_ORG_TYPE');
					$orginfo .= '</td>';
					$orginfo .= '<td>: ';
					$orginfo .= $info[2];
					$orginfo .= '</td>';
					$orginfo .= '</tr>';
					$orginfo .= '<tr>';
					$orginfo .= '<td>';
					$orginfo .= JText::_('TG_FILESIZE');
					$orginfo .= '</td>';
					$orginfo .= '<td>: ';
					$orginfo .= $fsize;
					$orginfo .= '</td>';
					$orginfo .= '</tr>';
					$orginfo .= '</table>';
					$imgthumb = $ad_path.'/thumbs/'.$row->catid.'/'.$row->imgthumbname;
					echo $ad_path;
			?>
			    <table width="50%" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			    <td align="center"><fieldset><legend>&nbsp;<?php echo JText::_('TG_ORG_PIC_INFO'); ?>&nbsp;</legend>
			    <img src="<?php echo $imgthumb; ?>" style="<?php echo $ad_imgstyle; ?>" title="<?php echo _DG_THUMB_PIC_PREVIEW; ?>" /><br /><br /><?php echo $orginfo; ?>
				</fieldset></td>
			    </tr>
			    </table>
			    </td>
			    </tr>
			    </table>
				<?php
			}
	//==============================================================================
	// by Yunoshev Victor
	//==============================================================================
		function showCatsRecursive(&$r, $parent, $pp, $level)
			{
				global $database;
				$level++;
				$query = "SELECT c.*, g.name AS groupname FROM #__true_catg c"
					. " LEFT JOIN #__groups g ON g.id = c.access WHERE c.parent = '".$parent."'"
					. " ORDER BY  c.ordering ASC ";
		  		$database->setQuery($query);
		 		$cats= $database->loadObjectList();
				$c = 0;
				$count = count($cats);
				foreach($cats as $cat){
					$up = 1;
					$down = 1;
					if ($c == 0) $up = 0;
					if ($c+1 == $count) $down = 0;
		 			$entries = true_get_count_entries($cat->cid, null);
					HTML_true::showCatItem($r,$cat,$entries,$up,$down,$pp,$level, $count);
					$r++;
					$c++;
					HTML_true::showCatsRecursive($r, $cat->cid, $pp==0?$pp:$cat->published, $level);
				}
			}
		function showCatItem($r, $cat, $entries, $up, $down, $pp, $level, $count)
			{
				global $mosConfig_live_site, $my, $mainframe;
				$access1 = mosCommonHTML::AccessProcessing( $cat, $r );
				?>
				<tr>
			  	<td><?php echo $r +1 ;?></td>
			  	<td><input type="checkbox" id="cb<?php echo $r; ?>" name="cid[]" value="<?php echo $cat->cid; ?>" onClick="isChecked(this.checked);" /></td>
				<td width="5%"><?php echo $cat->cid; ?></td>
			    <td align="justify">
					<?php
					for ($j=0;$j<(($level-1)*2);$j++) echo "&nbsp;&nbsp;&nbsp;";
					if ($level > 1) echo "<sup>L</sup>";
						$catname = $cat->name;
					if ($cat->published == 0) {
						$catname = "<strong style=\"color:#999999\">". $cat->name. '</strong>';
					if ($entries > 0)
						$entries = "<strong style=\"color:#FF0000;text-decoration:blink;\">". $entries. '</strong>';
					}
					elseif ($pp == 0) {
						$catname = "<strong style=\"color:#FF0000;text-decoration:blink;\">". $cat->name. '</strong>';
					if ($entries > 0)
						$entries = "<strong style=\"color:#FF0000;text-decoration:blink;\">". $entries. '</strong>';
					}
					?>
					<a href="#edit" onclick="return listItemTask('cb<?php echo $r; ?>','editcatg')"><b><?php echo $catname; ?></b></a>
			    </td>
				<td>
					<?php
					  $cat->description = htmlspecialchars($cat->description, ENT_QUOTES);
					?>
					<img src="<?php echo $mainframe->getCfg('live site'); ?>/components/com_true/images/about.png" width="16" height="16" border="0" alt="Description" onmouseover="return overlib('<?php echo htmlspecialchars(preg_replace("#(\n|\r?)#is", '', $cat->description)); ?>', CAPTION, '<?php echo $cat->name; ?>', BELOW, RIGHT);" onmouseout="return nd();" />
				</td>
				<td style="text-align:center"><?php echo $entries;?></td>
					<?php
					$task = $cat->published ? 'unpublishcatg' : 'publishcatg';
			   		$img = $cat->published ? 'publish_g.png' : 'publish_x.png'; # not Published
					?>
				<td align="center"><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $r;?>','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="" /></a></td>
				<td align="center"><?php echo $access1;?></td>
				<td style="text-align:center">
					<?php
					if($up==1) {
						echo "<a href='#reorder' onClick='return listItemTask(\"cb".$r."\",\"orderupcatg\")' title=''>";
						echo "<img src='images/uparrow.png' width='12' height='12' border='0' alt='Up'></a>&nbsp;";
					}
					if($down==1) {
						echo "<a href='#reorder' onClick='return listItemTask(\"cb".$r."\",\"orderdowncatg\")' title=''>";
						echo "<img src='images/downarrow.png' width='12' height='12' border='0' alt='Down'></a>";
					}
					?>
			    </td>
				    <?php
				    if ($cat->cmetadesc == '') {
				    	$overlibmetadesc = '<table><tr><td>NULL</td></tr></table>';
				    	$cmetadesc = '<img src="'.$mainframe->getCfg('live site').'/components/com_true/images/no_download.png" alt="" onmouseover="return overlib('.$overlibmetadesc.', BELOW, RIGHT);" onmouseout="return nd();" />';

				    } else {
				    	$overlibmetadesc = '<table><tr><td>'.$cat->cmetadesc.'</td></tr></table>';
				    	$cmetadesc = '<img src="'.$mainframe->getCfg('live site').'/components/com_true/images/tick.png" onmouseover="return overlib('.$overlibmetadesc.', BELOW, RIGHT);" onmouseout="return nd();" />';
				    }
				    if ($cat->cmetakey == '') {
				    	$overlibmetakey = '<table><tr><td>NULL</td></tr></table>';
				    	$cmetakey = '<img src="'.$mainframe->getCfg('live site').'/components/com_true/images/no_download.png" alt="" onmouseover="return overlib('.$overlibmetakey.', BELOW, RIGHT);" onmouseout="return nd();" />';

				    } else {
				    	$overlibmetakey = '<table><tr><td>'.$cat->cmetakey.'</td></tr></table>';
				    	$cmetakey = '<img src="'.$mainframe->getCfg('live site').'/components/com_true/images/tick.png" onmouseover="return overlib('.$overlibmetakey.', BELOW, RIGHT);" onmouseout="return nd();" />';
				    }
				    ?>
			    <td align="center"><?php echo $cmetadesc; ?></td>
			    <td align="center"><?php echo $cmetakey; ?></td>
				</tr>
			  <?php
			}
		function showCatOverview($option,  $total, $catid, $lists, $pageNav, $search)
			{
				global $mosConfig_absolute_path;
			    require_once($mosConfig_absolute_path."/administrator/components/com_true/true.utils.php");
			    ?>
				<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
			    <script type="text/javascript" src="../includes/js/overlib_mini.js"></script>
				<form action="index2.php" method="post" name="adminForm">
				<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminheading">
					<tr>
				    	<th class="categories"><?php echo JText::_('TG_CAT_MANAGER');
				    	echo ($catid) ? " :: ".true_get_cat_path($catid): ""; ?></th>
				    	<td width="100%"></td>
						<td nowrap><?php echo JText::_('TG_DISPLAY'); ?></td>
						<td><?php echo $pageNav->writeLimitBox(); ?> </td>
						<td width="center">
							<?php
							//echo $lists['cats'];
							?>
						 </td>
						<td><?php echo JText::_('TG_SEAR'); ?>:</td>
						<td><input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onchange="document.adminForm.submit();" /></td>
				</tr>
				<tr>
					<td width="100%"></td>
				</tr>
				</table>
				<table width="100%" border="0" cellpadding="4" cellspacing="0"  class="adminlist">
					<tr>
				    	<th width="24px">#</th>
						<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $total; ?>);" /></th>
						<th class="title" width="5%">ID</th>
						<th class="title" nowrap="nowrap"><?php echo JText::_('TG_CATEGORY'); ?></th>
						<th align="left"><?php echo JText::_('TG_DESCRIPTION'); ?></th>
					  	<th nowrap="nowrap"><?php echo JText::_('TG_FILES_IN_CATEGORY'); ?></th>
						<th nowrap="nowrap"><?php echo JText::_('TG_PUBLISHED'); ?></th>
						<th nowrap="nowrap"><?php echo JText::_('TG_ACCESS'); ?></th>
						<th nowrap="nowrap"><div align="center"><?php echo JText::_('TG_REORDER'); ?></div></th>
						<th nowrap="nowrap"><?php echo JText::_('TG_METADESC'); ?></th>
						<th nowrap="nowrap"><?php echo JText::_('TG_METAKEY'); ?></th>
					</tr>
						<?php
			    		$x=0; $r=0;
							if ($total) {
								HTML_true::showCatsRecursive($r, $catid, 1, 0);
							}
						?>
				</tr>
				<tr>
					<th align="center" colspan="11"> <?php echo $pageNav->writePagesLinks(); ?></th>
				</tr>
				<tr>
					<td align="center" colspan="11"> <?php echo $pageNav->writePagesCounter(); ?></td>
				</tr>
				</table>
				<input type="hidden" name="option" value="<?php echo $option; ?>">
				<input type="hidden" name="task" value="showcatg">
				<input type="hidden" name="boxchecked" value="0">
				</form>
				<?php
			}
		function showCatgs(&$rows, $search, $pageNav, $option)
			{
				?>
				<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
			    <script type="text/javascript" src="../includes/js/overlib_mini.js"></script>
				<form action="index2.php" method="post" name="adminForm">
				<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminheading">
				<tr>
			    <th class="categories"><?php echo JText::_('TG_CAT_MANAGER'); ?></th>
				<td nowrap><?php echo JText::_('TG_DISPLAY'); ?></td>
				<td> <?php echo $pageNav->writeLimitBox(); ?> </td>
				<td><?php echo JText::_('TG_SEAR'); ?>:</td>
				<td>
				<input type="text" name="search" value="<?php echo $search; ?>" class="inputbox" onchange="document.adminForm.submit();" />
				</td>
				</tr>
				<tr>
				<td width="100%"> </td>
				</tr>
				</table>
				<table width="100%" border="0" cellpadding="4" cellspacing="0"  class="adminlist">
				<tr>
			    <th width="20">#ID</th>
				<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
				</th>
				<th class="title" nowrap="nowrap"><?php echo JText::_('TG_CATEGORY'); ?></th>
				<th align="left"><?php echo JText::_('TG_PARENT_CAT'); ?></th>
			    <th nowrap="nowrap"><?php echo JText::_('TG_FILES_IN_CATEGORY'); ?></th>
				<th nowrap="nowrap"><?php echo JText::_('TG_PUBLISHED'); ?></th>
				<th nowrap="nowrap"><?php echo JText::_('TG_ACCESS'); ?></th>
				<th colspan="2" nowrap="nowrap">
				<div align="center"><?php echo JText::_('TG_REORDER'); ?></div>
				</th>
				</tr>
				<?php
					$k = 0;
					$i = 0;
					for ($i = 0, $n = count($rows); $i < $n; $i++) {
						$row = &$rows[$i];
				?>
				<tr class="row<?php echo $k; ?>">
			    <td align="center"><?php echo $row->cid; ?></td>
				<td width="20">
				<input type="checkbox" id="cb<?php echo $i; ?>" name="cid[]" value="<?php echo $row->cid; ?>" onclick="isChecked(this.checked);">
				</td>
				<td align="left" width="25%"><a href="#edit" onclick="return listItemTask('cb<?php echo $i; ?>','editcatg')"><?php echo $row->name; ?></a></td>
				<td align="left" width="55%"><?php echo ShowCategoryPath($row->parent); ?></td>
			    <td align="center" width="5%"><?php echo GetNumberOfLinks($row->cid); ?></td>
				<?php
						$task = $row->published ? 'unpublishcatg' : 'publishcatg';
						$img = $row->published ? 'tick.png' : 'publish_x.png';
				?>
				<td width="10%" align="center" nowrap><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $task; ?>')"><img src="images/<?php echo $img; ?>" border="0" alt="" /></a></td>
				<td width="10%" align="center" nowrap><?php echo $row->groupname; ?></td>
				<td>
				<?php if($i > 0 || ($i + $pageNav->limitstart > 0)) { ?>
				<div align="center"><a href="#reorder" onclick="return listItemTask('cb<?php echo $i; ?>','orderupcatg')">
			    <img src="images/uparrow.png" border="0" title="<?php echo JText::_('TG_UP'); ?>"></a>
				<?php } else {
							echo "&nbsp;";
						} ?>
				</div>
				</td>
				<td>
				<?php if($i < $n - 1 || $i + $pageNav->limitstart < $pageNav->total - 1) { ?>
				<div align="center"><a href="#reorder" onclick="return listItemTask('cb<?php echo $i; ?>','orderdowncatg')">
			    <img src="images/downarrow.png" border="0" title="<?php echo JText::_('TG_DOWN'); ?>"></a>
				<?php } else {
					echo "&nbsp;";
					}
				?>
				</div>
				</td>
				<?php $k = 1 - $k;
					} ?>
				</tr>
				<tr>
					<th align="center" colspan="11"> <?php echo $pageNav->writePagesLinks(); ?></th>
				</tr>
				<tr>
					<td align="center" colspan="11"> <?php echo $pageNav->writePagesCounter(); ?></td>
				</tr>
				</table>
				<input type="hidden" name="option" value="<?php echo $option; ?>">
				<input type="hidden" name="task" value="showcatg">
				<input type="hidden" name="boxchecked" value="0">
				</form>
				<?php
			}

		function editCatg(&$row, &$publist, &$menulink, $option, $glist, $Lists, $mgroups, $orderlist)
			{
				global $mainframe;
				//mosMakeHtmlSafe($row, ENT_QUOTES, 'description');
				?>
				<script type="text/javascript">
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'cancelcatg') {
						submitform( pressbutton );
					return;
				}
				try {
				document.adminForm.onsubmit();
				}
				catch(e){}
				if (form.name.value == ""){
					alert( "<?php echo JText::_('TG_CAT_TITLE'); ?>" );
				} else {
				<?php getEditorContents('editor1', 'description'); ?>
					submitform( pressbutton );
				}
				}
				</script>
				<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminheading">
				<tr>
			    <th class="categories"><?php echo $row->cid ? JText::_('TG_EDIT_CAT').' '.JText::_('TG_CATEGORY1').' "'.$row->name.'"' : JText::_('TG_ADD_CAT').JText::_('TG_CATEGORY1'); ?> </th>
				</tr>
				</table>
				<form action="index2.php" method="post" name="adminForm">
				<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
				<tr>
					<td width="200"><b><?php echo JText::_('TG_TITLE'); ?>:</b></td>
					<td><input class="inputbox" type="text" name="name" size="60" value="<?php echo $row->name; ?>"></td>
				</tr>
				<tr>
					<td valign="top" ><b><?php echo JText::_('TG_PUBLISHED'); ?>:</b></td>
					<td nowrap ><?php echo $publist; ?></td>
				</tr>
				<tr>
					<td valign="top" ><b><?php echo JText::_('TG_MENULINK'); ?>:</b></td>
					<td nowrap ><?php echo $menulink; ?></td>
				</tr>
				<tr>
					<td valign="top" ><b><?php echo JText::_('TG_MENULINK_TYPE'); ?>:</b></td>
					<td nowrap ><?php echo $mgroups; ?></td>
				</tr>
				<tr>
					<td valign="top" ><b><?php echo JText::_('TG_PARENT_CAT'); ?>:</b></td>
					<td nowrap ><?php echo $Lists["catgs"]; ?></td>
				</tr>
				<tr>
					<td valign="top" ><b><?php echo JText::_('TG_ACCESS'); ?>:</b></td>
					<td nowrap ><?php echo $glist; ?></td>
				</tr>
				<tr>
					<td valign="top" ><b><?php echo JText::_('TG_ORDER'); ?>:</b></td>
					<td nowrap ><?php echo $orderlist; ?></td>
				</tr>
				<tr>
					<td width="200"><b><?php echo JText::_('TG_CATIMG'); ?>:</b></td>
					<td><input class="inputbox" type="text" name="catimg" size="60" value="<?php echo $row->catimg; ?>"></td>
				</tr>
			    <tr>
					<td valign="top"><b><?php echo JText::_('TG_DESCRIPTION_INTRO'); ?>:</b></td>
					<td><?php editorArea('editor1', $row->description, 'description', '500', '200', '70', '10'); ?></td>
				</tr>
				<tr>
					<td valign="top"><b><?php echo JText::_('TG_DESCRIPTION_FULL'); ?>:</b></td>
					<td><?php editorArea('editor1', $row->desc_full, 'desc_full', '500', '200', '70', '10'); ?></td>
				</tr>
				<tr>
					<td valign="top"><b><?php echo JText::_('TG_METADESC'); ?>:</b></td>
					<td><input class="inputbox" type="text" name="cmetadesc" value="<?php echo $row->cmetadesc; ?>" size="100" maxlength="200" /></td>
				</tr>
				<tr>
					<td valign="top"><b><?php echo JText::_('TG_METAKEY'); ?>:</b></td>
					<td><input class="inputbox" type="text" name="cmetakey" value="<?php echo $row->cmetakey; ?>" size="100" maxlength="200" /></td>
				</tr>
				</table>
				</div>
				<input type="hidden" name="cid" value="<?php echo $row->cid; ?>">
				<input type="hidden" name="task" value="">
				<input type="hidden" name="option" value="<?php echo $option; ?>">
				</form>
				<?php
			}
	}
?>
