<?php

namespace Cx\Core\PageTree;

/**
 * Base class for all kinds of trees such as Sitemaps and Navigation.
 *
 * @author Michael Ritter <michael.ritter@comvation.com>
 */
abstract class PageTree {
    protected static $virtualPagesAdded = false;
    protected $lang = null;
    protected $rootNode = null;
    protected $depth = null;
    protected $em = null;
    protected $currentPage = null;
    protected $currentPageOnRootNode = false;
    protected $currentPagePath = null;
    protected $pageRepo = null;
    
    /**
     * @param $entityManager the doctrine em
     * @param int $maxDepth maximum depth to fetch, 0 means everything
     * @param \Cx\Model\ContentManager\Node $rootNode node to use as root
     * @param int $lang the language
     * @param \Cx\Model\ContentManager\Node $currentPage if set, renderElement() will receive a correctly set $current flag.
     */
    public function __construct($entityManager, $maxDepth = 0, $rootNode = null, $lang = null, $currentPage = null) {
        $this->lang = $lang;
        $this->depth = $maxDepth;
        $this->em = $entityManager;
        $this->rootNode = $rootNode;
        $this->currentPage = $currentPage;
        $this->startLevel = 1;
        $this->startPath = '';
        $this->pageRepo = $this->em->getRepository('Cx\Model\ContentManager\Page');
        $this->nodeRepo = $this->em->getRepository('Cx\Model\ContentManager\Node');
        if (!$this->rootNode) {
            $this->rootNode = $this->nodeRepo->getRoot();
        }
        $this->init();
    }

    /**
     * returns the string representation of the tree.
     *
     * @return string
     */
    public function render() {
        $content = $this->preRender($this->lang);
        $content .= $this->renderHeader($this->lang);
$this->bytes = memory_get_peak_usage();
        $content .= $this->internalRender($this->rootNode, $this->currentPageOnRootNode);
//echo 'PageTree2(' . get_class($this) . '): ' . formatBytes(memory_get_peak_usage()-$this->bytes) . '<br />';
        $content .= $this->renderFooter($this->lang);
        $content .= $this->postRender($this->lang);
        return $content;
    }
    
    /**
     * @todo Virtual pages!
     * @param type $nodes
     * @param type $level
     * @param type $dontDescend 
     */
    private function internalRender($node, $dontDescend = false) {
        $content = '';
        $nodeStack = array();
        array_push($nodeStack, $node);
        while (count($nodeStack)) {
            $node = array_pop($nodeStack);
            $children = $node->getChildren();
            
            $children2 = array();
            foreach ($children as $child) {
                $children2[$child->getLft()] = $child;
            }
            ksort($children2);
            $children = $children2;
            unset($children2);
            
            $hasChilds = count($children) > 0;
            if ($hasChilds && !$dontDescend) {
                $children = array_reverse($children, true);
                foreach ($children as $child) {
                    array_push($nodeStack, $child);
                }
            }

            $page = $node->getPage($this->lang);
            if (!$page) {
                continue;
            }
            if (!$page->isActive() || !$page->isVisible()) {
                continue;
            }
            // prepare data for element
            $current = false;
            if ($this->currentPage) {
                $current = $this->currentPage->getId() == $page->getId();
            }
            
            $href = $page->getPath();
            if (isset($_GET['pagePreview']) && $_GET['pagePreview'] == 1) {
                $href .= '?pagePreview=1';
            }
            
            $bytes = memory_get_peak_usage();
            $content .= $this->preRenderElement($node->getLvl(), $hasChilds, $this->lang, $page);
            $content .= $this->renderElement($page->getTitle(), $node->getLvl(), $hasChilds, $this->lang, $href, $current, $page);
            $content .= $this->postRenderElement($node->getLvl(), $hasChilds, $this->lang, $page);
            $bytes = memory_get_peak_usage()-$bytes;
            $this->bytes = $this->bytes + $bytes;
        }
        return $content;
    }
    
    /**
     * Tells wheter $pathToPage is in the active branch
     * @param String $pathToPage
     * @return boolean True if active, false otherwise
     */
    public function isPagePathActive($pathToPage) {
        if ($pathToPage == '') {
            return false;
        }
        
        $pathToPage = str_replace('//', '/', $pathToPage . '/');
        return substr($this->currentPagePath . '/', 0, strlen($pathToPage)) == $pathToPage;
    }

    public function setVirtualLanguageDirectory($dir) {
        $this->virtualLanguageDirectory = $dir;
    }
    
    protected abstract function preRenderElement($level, $hasChilds, $lang, $page);
    /**
     * Override this to do your representation of the tree.
     *
     * @param string $title
     * @param int $level 0-based level of the element
     * @param boolean $hasChilds are there children of this element? if yes, they will be processed in the subsequent calls.
     * @param int $lang language id
     * @param string $path path to this element, e.g. '/CatA/CatB'
     * @param boolean $current if a $currentPage has been specified, this will be set to true if either a parent element of the current element or the current element itself is rendered.
     *
     * @return string your string representation of the element.
     */
    protected abstract function renderElement($title, $level, $hasChilds, $lang, $path, $current, $page);

    protected abstract function postRenderElement($level, $hasChilds, $lang, $page);
    
    protected abstract function renderHeader($lang);
    
    protected abstract function renderFooter($lang);
    
    protected abstract function preRender($lang);
    
    protected abstract function postRender($lang);
    
    /**
     * Called on construction. Override if you do not want to override the ctor.
     */
    protected abstract function init();
}
