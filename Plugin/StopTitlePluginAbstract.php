<?php
namespace Simple\Brands\Plugin;

class StopTitlePluginAbstract
{

    /**
     * Add Brand Label to Product Page
     *
     * @param \Magento\Theme\Block\Html\Title $original
     * @param $html
     * @return string
     */
    public function afterToHtml(\Magento\Theme\Block\Html\Title $original, $html) 
    {
        // Sorry. Shitty amasty. 
        $html = explode('<div class="amshopby-option-link">', $html);
        if(count($html) > 1){
        return $html[0] . '</div>';
        } else {
            return $html[0];
        }
    }
        
}