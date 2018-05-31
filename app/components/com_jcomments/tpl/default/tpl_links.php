<?php
// ensure this file is being included by a parent file
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');
/*
*
* Template for links (Readmore and Add comment) attached to content items 
* on fronpage, blog-section or blog-category. Used from content mambot called jcomments.content plugin
*
* Шаблон для отображения ссылок Подробнее и Добавить комментарий в блог-разделах и блог-категориях
* Используется из мамбота jcomments.content
*
*/
class jtt_tpl_links extends JoomlaTuneTemplate
{
	/*
	*
	* Main template function
	*
	* Внимание: если функцию render удалить, шаблон перестанет работать!
	* 
	*/
	function render() 
	{
?>
<div class="small" align="left" style="margin-top: 10px; clear:both;">
<?php echo $this->getReadmoreLink(); ?> <?php echo $this->getCommentsLink(); ?>
</div>
<?php
	}

	/*
	*
	* Display Readmore link
	*
	* Отображает ссылку "Подробнее" (если она должна присутствовать в данной статье)
	* Если в настройках ссылка "Подробнее" отключена, то тут она тоже выводиться не будет.
	*
	*/
	function getReadmoreLink() 
	{
		if ($this->getVar('readmore_link_hidden', 0) == 1) {
			return '';
		}

		$link = $this->getVar('link-readmore');
		$text = $this->getVar('link-readmore-text');
		return '<a class="readmore-link" href="'. $link .'">' . $text . '</a>';
	}

	/*
	*
	* Display Comments or Add comments link
	*
	* Отображает:
	* - ссылку вида "Добавить комментарий" если комментариев еще нет и материал доступен пользователю
	* - ссылку вида "Комментарии (1)" если комментарииев более одного и материал доступен пользователю
	* - текст "Комментарии (1)" если комментарииев более одного, но материал недоступен пользователю
	*
	*/
	function getCommentsLink()
	{
		if ($this->getVar('comments_link_hidden') == 1) {
			return '';
		}

		$style = $this->getVar('comments_link_style');
		$count = $this->getVar('comments-count');
		$link  = $this->getVar('link-comment');

		switch($style) {
			case -1:
				return '<span class="comment-link">'.JText::_('COUNT').' ('.$count.')</span>';
				break;
			case 0: 
				return '<a href="'.$link.'#addcomments" class="comment-link">'.JText::_('WRITE').'</a>';
				break;
			default:
				return '<a href="'.$link.'#comments" class="comment-link">'.JText::_('COUNT').' ('.$count .')</a>';
				break;
		}
	}
}
?>