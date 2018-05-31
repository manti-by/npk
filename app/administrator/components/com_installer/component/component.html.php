<?php
/**
* @version $Id: component.html.php 10002 2008-02-08 10:56:57Z willebil $
* @package Joomla
* @subpackage Installer
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Доступ запрещен' );

/**
* @package Joomla
* @subpackage Installer
*/
class HTML_component {
/**
* @param array An array of records
* @param string The URL option
*/
	function showInstalledComponents( $rows, $option ) {
		if (count( $rows )) {
			?>
			<form action="index2.php" method="post" name="adminForm">
			<table class="adminheading">
			<tr>
				<th class="install">
				Установленные компоненты
				</th>
			</tr>
			</table>

			<table class="adminlist">
			<tr>
				<th width="20%" class="title">
				Установленные
				</th>
				<th width="20%" class="title">
				Ссылка для меню
				</th>
				<th width="10%" align="left">
				Автор
				</th>
				<th width="5%" align="center">
				Версия
				</th>
				<th width="10%" align="center">
				Дата
				</th>
				<th width="15%" align="left">
				Email автора
				</th>
				<th width="15%" align="left">
				URL автора
				</th>
			</tr>
			<?php
			$rc = 0;
			include_once ($GLOBALS['mosConfig_absolute_path'] .'/administrator/includes/andyr_lib.php');
			for ($i = 0, $n = count( $rows ); $i < $n; $i++) {
				$row =& $rows[$i];
				?>
				<tr class="<?php echo "row$rc"; ?>">
					<td align="left">
					<input type="radio" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);">
					<span class="bold">
					<?php echo normal ($row->name); ?>
					</span>
					</td>
					<td align="left">
					<?php echo @$row->link != "" ? $row->link : "&nbsp;"; ?>
					</td>
					<td align="left">
					<?php echo @$row->author != "" ? normal ($row->author) : "&nbsp;"; ?>
					</td>
					<td align="center">
					<?php echo @$row->version != "" ? normal ($row->version) : "&nbsp;"; ?>
					</td>
					<td align="center">
					<?php echo @$row->creationdate != "" ? normal ($row->creationdate) : "&nbsp;"; ?>
					</td>
					<td>
					<?php echo @$row->authorEmail != "" ? normal ($row->authorEmail) : "&nbsp;"; ?>
					</td>
					<td>
					<?php echo @$row->authorUrl != "" ? "<a href=\"" .(substr( $row->authorUrl, 0, 7) == 'http://' ? $row->authorUrl : 'http://'.$row->authorUrl). "\" target=\"_blank\">$row->authorUrl</a>" : "&nbsp;";?>
					</td>
				</tr>
				<?php
				$rc = 1 - $rc;
			}
		} else {
			?>
			<td class="small">
			Нет установленных пользовательских компонентов
			</td>
			<?php
		}
		?>
		</table>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="option" value="com_installer" />
		<input type="hidden" name="element" value="component" />
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<?php
	}
}
?>