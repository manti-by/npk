<?php
/**
 * JoomlaTuneLanguage
 *
 * @package JoomlaTune.Framework
 * @subpackage Language
 * @author Dmitry M. Litvinov
 * @copyright 2008
 * @version $Id$
 * @access public
 */
if (!defined('JOOMLATUNE_LANGUAGE')) {

    define('JOOMLATUNE_LANGUAGE', 1);

	class JoomlaTuneLanguage
	{
		var $currentLanguage = null;
		var $root = null;
		var $languages = null;

		/**
     * A hack to support __construct() on PHP 4
     *
     * @access	public
     * @return	Object
     */
		function JoomlaTuneLanguage()
		{
			$args = func_get_args();
			call_user_func_array( array(&$this, '__construct'), $args );
		}

		/**
     * Class constructor, overridden in descendant classes.
     *
     * @access	protected
     */
		function __construct()
		{
			$this->root = dirname( __file__ );
			$this->languages = array( array() );
		}

		/**
     * Returns a reference to the global JoomlaTuneLanguage object, only creating it
     * if it doesn't already exist.
     *
     * This method must be invoked as:
     * 		<pre>  $lang =& JoomlaTuneLanguage::getInstance();</pre>
     *
     * @param string $language
     * @return JoomlaTuneLanguage $instance
     */
		function &getInstance( $language = null )
		{
			static $instance;
			if ( !is_object($instance) )
			{
				$instance = new JoomlaTuneLanguage();
			}

			if ( isset($language) )
			{
				$instance->load( $language, '' );
				$instance->setLanguage( $language );
			}
			return $instance;
		}

		/**
     * Return current language
     *
     * @access public
     * @return string
     */
		function getLanguage()
		{
			return $this->currentLanguage;
		}

		/**
     * Set current language
     *
     * @param string $language
     * @access public
     * @return void
     */
		function setLanguage( $language )
		{
			$this->currentLanguage = JoomlaTuneString::trim( $language );
		}

		/**
     * Return root path to language files
     *
     * @access public
     * @return string
     */
		function getRoot()
		{
			return $this->root;
		}

		/**
     * Sets root path to language files
     *
     * @param string $directory
     * @access public
     * @return void
     */
		function setRoot( $directory )
		{
			$this->root = JoomlaTuneString::trim( $directory );
		}

		/**
     * Unload language variables for given language
     *
     * @param string $language
     * @access public
     * @return void
     */
		function unload( $language )
		{
			$this->languages[$language] = array();
		}

		/**
     * Load all languages files from languages' root directory
     *
     * @param string $language
     * @access public
     * @return void
     */
		function loadAll( $language )
		{
			$fileNames = glob( $this->getRoot . "*.ini" );
			foreach ( $fileNames as $fileName )
			{
				if ( preg_match('/' . $language . '/', $fileName) )
				{
					$this->load( $fileName );
				}
			}
		}


		/**
     * Translates a string into the current language
     *
     * @access	public
     * @param	string $string The string to translate
     * @param	boolean	$jsSafe		Make the result javascript safe
     * @return string
     */
		function _( $string, $jsSafe = false )
		{

			if (isset($this->languages[$this->currentLanguage])) {
				$key = JoomlaTuneString::trim( $string );
				$key = JoomlaTuneString::strtoupper($key);

				if (isset($this->languages[$this->currentLanguage][$key])) {
					$string = $this->languages[$this->currentLanguage][$key];
				}
			}

			if ($jsSafe) {
				$string = addslashes($string);
			}

			return $string;
		}

		/**
     * Loads a single language file and appends the results to the existing strings
     *
     * @param string $language The language to load
     * @param string $section The language file name suffix
     * @access public
     * @return void
     */
		function load( $language, $section = '' )
		{
			$fileName = $language . ( $section != '' ? '.' . $section : '' ) . '.ini';
			$pathFile = $this->root . DS . $fileName;

			if ( is_file($pathFile) )
			{

				if ( !isset($this->languages[$language]) )
				{
					$this->languages[$language] = array();
					$this->setLanguage($language);
				}

				$lines = file( $pathFile );
				foreach ( $lines as $line )
				{
					if ( !preg_match('/^(#|;)/', $line) )
					{
						$s = JoomlaTuneString::split( '=', $line, 2 );
						if ( count($s) >= 2 )
						{
							$this->languages[$language][JoomlaTuneString::strtoupper(JoomlaTuneString::trim( $s[0] ))] = JoomlaTuneString::trim( $s[1] );
						}
					}
				}
				unset( $lines );
			}
			else
			{
				echo 'File "' . $fileName . '" not found in "' . $this->root . '"';
			}
		}
	}
}
?>