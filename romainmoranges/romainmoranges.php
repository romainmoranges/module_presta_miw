<?php

class RomainMoranges extends Module
{
    public function __construct()
    {
        $this->author  = 'Romain Moranges';
        $this->name    = 'romainmoranges';
        $this->version = '1.0.0';
        $this->bootstrap = 'true';
        
        $this->displayName = "Romain Moranges";

        parent::__construct();
    }

    public function install()
    {
        return parent::install() && 
        $this->registerHook('displayAdminProductsMainStepLeftColumnMiddle') &&
        $this->registerHook('actionProductUpdate') &&
        $this->registerHook('displayAfterProductThumbs') &&
        $this->registerHook('displayLeftColumn') &&
        $this->dbInstall();   
    }

    public function uninstall()
    {
        return $this->dbUninstall() && parent::uninstall();
        
    }

    public function dbInstall()
    {
        return Db::getInstance()->execute('ALTER TABLE `ps_product` ADD `description2` TEXT NOT NULL AFTER `state`;');
    }

    public function dbUninstall()
    {
        return Db::getInstance()->execute('ALTER TABLE `ps_product` DROP `description2`');
    }

    public function getContent()
    {
        $output = null;
        if (Tools::isSubmit('submit' . $this->name)) {
            $myModuleName = strval(Tools::getValue('ROMAINMORANGES_NAME'));
            if (!$myModuleName || empty($myModuleName) || !Validate::isGenericName($myModuleName)) {
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            } else {
                $output .= $this->displayConfirmation($this->l('Settings updated'));
                Configuration::updateValue('ROMAINMORANGES_NAME', strval(Tools::getValue('ROMAINMORANGES_NAME')));
                Configuration::updateValue('ROMAINMORANGES_FB', strval(Tools::getValue('ROMAINMORANGES_FB')));
                Configuration::updateValue('ROMAINMORANGES_TWITTER', strval(Tools::getValue('ROMAINMORANGES_TWITTER')));
            }
        }
        return $output.$this->displayForm();
    }

    public function displayForm()
    {
        // Get default language
        $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');
    
        // Init Fields form array
        $fieldsForm[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Nom'),
                    'name' => 'ROMAINMORANGES_NAME',
                    'size' => 25,
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Facebook'),
                    'name' => 'ROMAINMORANGES_FB',
                    'size' => 25,
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Twitter'),
                    'name' => 'ROMAINMORANGES_TWITTER',
                    'size' => 25,
                    'required' => true
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            ]
        ];
    
        $helper = new HelperForm();
    
        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
    
        // Language
        $helper->default_form_language = $defaultLang;
        $helper->allow_employee_form_lang = $defaultLang;
    
        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                '&token='.Tools::getAdminTokenLite('AdminModules'),
            ],
            'back' => [
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ]
        ];
    
        // Load current value
        $helper->fields_value['ROMAINMORANGES_NAME'] = Configuration::get('ROMAINMORANGES_NAME');
        $helper->fields_value['ROMAINMORANGES_FB'] = Configuration::get('ROMAINMORANGES_FB');
        $helper->fields_value['ROMAINMORANGES_TWITTER'] = Configuration::get('ROMAINMORANGES_TWITTER');
    
        return $helper->generateForm($fieldsForm);
    }

    public function hookdisplayAdminProductsMainStepLeftColumnMiddle($params = [])
    {
        $query = 'Select `description2` from `ps_product` where `id_product` =' . $params['id_product'];
        $description2 = Db::getInstance()->getRow($query);

        if (isset($description2['description2'])) {
            $this->context->smarty->assign([
                'description2' => $description2['description2']
                ]);
        } else {
            $this->context->smarty->assign([
                'description2' => "Veuillez rentrer une description..."
                ]);
        }
        
        return $this->display(__FILE__, 'romainmoranges.tpl');
    }

    public function hookactionProductUpdate($params = [])
    {
        $table = 'product';
        $values = Tools::getValue('description2');
        $where = '`id_product`=' . $params['id_product'];
        
        return Db::getInstance()->update($table, ['description2' => $values], $where);
    }

    public function hookdisplayAfterProductThumbs($params = [])
    {
        $id = Tools::getValue('id_product');
        $query = 'Select `description2` from `ps_product` where `id_product` =' . $id;
        $description2 = Db::getInstance()->getRow($query);
        if (isset($description2['description2'])) {
            $this->context->smarty->assign([
                'description2' => $description2['description2']
                ]);
        }
        
        return $this->display(__FILE__, 'description.tpl');
    }

    /* Reseaux */

    public function hookdisplayLeftColumn($params = [])
    {
        $rs['facebook'] = Configuration::get('ROMAINMORANGES_FB');
        $rs['twitter'] = Configuration::get('ROMAINMORANGES_TWITTER');
        $this->context->smarty->assign([
            'facebook' => $rs['facebook'],
            'twitter' => $rs['twitter'],
            ]);
        return $this->display(__FILE__, 'displayLeftColumn.tpl');

    }

}
