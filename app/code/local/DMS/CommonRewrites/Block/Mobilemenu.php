<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dilhan
 * Date: 3/15/14
 * Time: 12:24 AM
 * To change this template use File | Settings | File Templates.
 */
class DMS_CommonRewrites_Block_Mobilemenu extends Mage_Page_Block_Html_Topmenu
{
    protected function _getHtml(Varien_Data_Tree_Node $menuTree, $childrenWrapClass)
    {
        $html = '';

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = is_null($parentLevel) ? 0 : $parentLevel + 1;

        $counter = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        foreach ($children as $child) {

            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel == 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $child->setClass($outermostClass);
            }

            $html .= '<li>';
            $html .= '<a href="' . $child->getUrl() . '" >'. $this->escapeHtml($child->getName()) . '</a>';

            if ($child->hasChildren()) {
                if (!empty($childrenWrapClass)) {
                    //$html .= '<div class="' . $childrenWrapClass . '">';
                }
                $html .= '<ul class="'.$childrenWrapClass.'">';
                $html .= $this->_getHtml($child, $childrenWrapClass);
                $html .= '</ul>';

                if (!empty($childrenWrapClass)) {
                    //$html .= '</div>';
                }
            }
            $html .= '</li>';

            $counter++;
        }

        return $html;
    }

}


