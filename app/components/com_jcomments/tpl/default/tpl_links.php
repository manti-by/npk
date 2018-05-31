<?php
// ensure this file is being included by a parent file
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');
/*
*
* Template for links (Readmore and Add comment) attached to content items 
* on fronpage, blog-section or blog-category. Used from content mambot called jcomments.content plugin
*
* ������ ��� ����������� ������ ��������� � �������� ����������� � ����-�������� � ����-����������
* ������������ �� ������� jcomments.content
*
*/
class jtt_tpl_links extends JoomlaTuneTemplate
{
	/*
	*
	* Main template function
	*
	* ��������: ���� ������� render �������, ������ ���������� ��������!
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
	* ���������� ������ "���������" (���� ��� ������ �������������� � ������ ������)
	* ���� � ���������� ������ "���������" ���������, �� ��� ��� ���� ���������� �� �����.
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
	* ����������:
	* - ������ ���� "�������� �����������" ���� ������������ ��� ��� � �������� �������� ������������
	* - ������ ���� "����������� (1)" ���� ������������� ����� ������ � �������� �������� ������������
	* - ����� "����������� (1)" ���� ������������� ����� ������, �� �������� ���������� ������������
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