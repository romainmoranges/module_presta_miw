<?php 

class RomainMorangesOverride extends RomainMoranges 
{
    public function hookdisplayLeftColumn($params = [])
    {
        $query = 'SELECT `id_product`, `price` FROM `ps_product` ORDER BY `ps_product`.`date_upd`  DESC LIMIT 3';
        $lastProducts = Db::getInstance()->executeS($query);
        $this->context->smarty->assign([
            'products' =>$lastProducts,
            ]);
        return $this->display(__FILE__, 'liste3produits.tpl');
    }
}