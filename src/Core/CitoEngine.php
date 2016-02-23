<?php
/**
 * Namespace for all core functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core;

/**
 * Class CitoEngine
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core
 * @version 0.0.1-dev
 */
class CitoEngine
{
    /**
     * The state if the buffer could be init.
     * @since 0.0.1-dev
     * @var bool
     */
    private $bufferState = false;

    /**
     * The instance of the CitoEngine.
     * @since 0.0.1-dev
     * @var CitoEngine|null
     */
    private static $instance = null;

    /**
     * The buffer which contains the site content.
     * @since 0.0.1-dev
     * @var string
     */
    private $siteBuffer = '';

    /**
     * The array with all values for the tags.
     * @since 0.0.1-dev
     * @var array
     */
    private $tagValues = [];

    /**
     * The state which compression will be used.
     * @since 0.0.1-dev
     * @var string
     */
    private $usedCompression = '';

    /**
     * Private constructor to prevent creating a new instance.
     * @since 0.0.1-dev
     */
    private function __construct()
    {

    }

    /**
     * Private clone method to prevent cloning of the instance.
     * @since 0.0.1-dev
     */
    private function __clone()
    {

    }

    /**
     * Method to execute the CitoEngine.
     * @since 0.0.1-dev
     */
    public function execute()
    {
        //check if the output buffering was started.
        if ($this->bufferState === true) {
            $this->siteBuffer = ob_get_contents();

            //check if the output buffering was successfull.
            if ($this->siteBuffer !== false) {
                ob_end_clean();
                $this->render();
            }
        }
    }

    /**
     * Method to execute the deflate compression.
     * @since 0.0.1-dev
     */
    private function executeDeflate()
    {
        //check if the deflate compression should be used.
        if ($this->usedCompression === 'deflate') {
            $this->siteBuffer = gzdeflate($this->siteBuffer, 9);
            header('Content-Encoding: deflate');
        }
    }

    /**
     * Method to execute the gzip compression.
     * @since 0.0.1-dev
     */
    private function executeGzip()
    {
        //check if the gzip compression should be used.
        if ($this->usedCompression === 'gzip') {
            $contentSize = strlen($this->siteBuffer);
            $contentChecksum = crc32($this->siteBuffer);

            //compress the site buffer.
            $this->siteBuffer = gzcompress($this->siteBuffer);
            $this->siteBuffer = substr($this->siteBuffer, 0, strlen($this->siteBuffer) - 4);

            //header and output.
            header('Content-Encoding: gzip');
            $this->siteBuffer = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
            $this->siteBuffer .= $this->siteBuffer.pack('V', $contentChecksum).pack('V', $contentSize);
        }
    }

    /**
     * Method to get the instance of the CitoEngine.
     * @return CitoEngine|null The instance of the CitoEngine.
     * @since 0.0.1-dev
     */
    public static function getInstance()
    {
        //check if a instance is available.
        if (self::$instance === null) {
            self::$instance = new self();
        }

        //return the instance.
        return self::$instance;
    }

    /**
     * Method to initialize the CitoEngine.
     * @since 0.0.1-dev
     */
    public function init()
    {
        $this->initCompression();
        $this->bufferState = ob_start();
    }

    /**
     * Method to initialize the compression.
     * @return bool The state if the compression was successfully initialized.
     * @since 0.0.1-dev
     */
    private function initCompression()
    {
        //check if the gzip compression is available.
        if (intval(ini_get('zlib.output_compression')) !== 1) {
            $encoding = filter_input(INPUT_SERVER, 'HTTP_ACCEPT_ENCODING');

            //check if a gecko browser is used.
            if (strpos(filter_input(INPUT_SERVER, 'HTTP_USER_AGENT'), 'Gecko') !== false) {
                if (strpos($encoding, 'deflate') !== false) {
                    $this->usedCompression = 'deflate';
                } elseif (strpos($encoding, 'gzip') !== false) {
                    $this->usedCompression = 'gzip';
                }
            } elseif ((version_compare(phpversion(), '4.0.5') >= 0) && (strpos($encoding, 'gzip') !== false)) {
                if (extension_loaded('zlib') === true) {
                    ob_start('ob_gzhandler');
                }
            }
        }
    }

    /**
     * Method to render the template.
     * @since 0.0.1-dev
     */
    public function render()
    {
        //check if the output buffering was successfull.
        if ($this->bufferState === true) {
            $this->siteBuffer = ob_get_contents();

            //check if the content is available.
            if ($this->siteBuffer !== false) {
                ob_end_clean();

                //render and output the buffer.
                $this->replaceTags();
                $this->executeDeflate();
                $this->executeGzip();
                echo $this->siteBuffer;
            }
        }
    }

    /**
     * Method to replace the tags of the template.
     * @since 0.0.1-dev
     */
    private function replaceTags()
    {
        //reset the tag content which will be created for replace.
        $tagContent = '';

        //get all tags on the site content.
        preg_match_all("/{{(.*)}}/", $this->siteBuffer, $tags);

        //run through all tags.
        for ($i = 0; $i < count($tags[1]); $i++) {
            $tag = $tags[1][$i];

            //check if a content is available.
            if (isset($this->tagValues[$tag])) {

                //run through all tag contents and create the whole content.
                foreach ($this->tagValues[$tag] as $content) {
                    $tagContent .= $content.(($content === '') ? '' : "\n");
                }

                //get all tags of the tag content and add to the tag array.
                preg_match_all("/{{(.*)}}/", $tagContent, $tagsContent);
                $tags[1] = array_merge($tags[1], $tagsContent[1]);
            }

            //replace the tag with tag content and clear the tag content.
            $this->siteBuffer = str_replace('{{'.$tag.'}}', $tagContent, $this->siteBuffer);
            $tagContent = '';
        }
    }

    /**
     * Method to add a value for a specified tag.
     * @param string $tag The name of the tag.
     * @param string $value The value which will be set on the tag.
     * @since 0.0.1-dev
     */
    public function setValue($tag, $value)
    {
        $this->tagValues[$tag][] = $value;
    }
}
