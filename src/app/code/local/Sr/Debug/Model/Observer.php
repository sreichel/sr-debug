<?php
/**
 * SR-Module
 *
 * @author      Sven Reichel <github-sr@hotmail.com>
 * @category    Mx
 * @package     Sr_Debug
 */

/**
 * Observer Model
 */
class Sr_Debug_Model_Observer extends Mage_Core_Model_Observer
{
    /**
     * Classes WITH existing $_eventPrefix
     *
     * @var array $existing
     */
    private static $existing = array(
        'Mage_Admin_Model_Roles',
        'Mage_Admin_Model_User',
        'Mage_Api_Model_User',
        'Mage_Catalog_Model_Product_Compare_Item',
        'Mage_CatalogSearch_Model_Query',
        'Mage_Core_Model_Config_Data',
        'Mage_Core_Model_Store',
        'Mage_Core_Model_Store_Group',
        'Mage_Core_Model_Website',
        'Mage_Cms_Model_Page',
        'Mage_Catalog_Model_Category',
        'Mage_Catalog_Model_Product',
        'Mage_Catalog_Model_Resource_Eav_Attribute',
        'Mage_CatalogRule_Model_Rule',
        'Mage_Customer_Model_Address',
        'Mage_Customer_Model_Customer',
        'Mage_Customer_Model_Group',
        'Mage_Eav_Model_Entity_Attribute',
        'Mage_Eav_Model_Entity_Attribute_Set',
        'Mage_Newsletter_Model_Subscriber',
        'Mage_Review_Model_Review',
        'Mage_Sales_Model_Order_Creditmemo',
        'Mage_Sales_Model_Order_Creditmemo_Item',
        'Mage_Sales_Model_Order',
        'Mage_Sales_Model_Order_Address',
        'Mage_Sales_Model_Order_Invoice',
        'Mage_Sales_Model_Order_Invoice_Item',
        'Mage_Sales_Model_Order_Item',
        'Mage_Sales_Model_Order_Payment',
        'Mage_Sales_Model_Order_Shipment',
        'Mage_Sales_Model_Order_Shipment_Item',
        'Mage_Sales_Model_Order_Shipment_Track',
        'Mage_Sales_Model_Order_Status_History',
        'Mage_Sales_Model_Quote',
        'Mage_Sales_Model_Quote_Address',
        'Mage_Sales_Model_Quote_Item',
        'Mage_Sales_Model_Quote_Payment',
        'Mage_SalesRule_Model_Rule',
        'Mage_Tag_Model_Tag',
        'Mage_Widget_Model_Widget_Instance',
        'Mage_Wishlist_Model_Item',
        'Mage_Wishlist_Model_Item_Option',
        'Mage_Wishlist_Model_Wishlist',
    );

    /**
     * Classes WITHOUT existing $_eventPrefix
     *
     * @var array $new
     */
    private static $new = array(
        'Mage_Admin_Model_Block',
        'Mage_Admin_Model_Variable',
        'Mage_Adminhtml_Model_Email_Template',
        'Mage_AdminNotification_Model_Inbox',
        'Mage_Api_Model_Roles',
        'Mage_Api2_Model_Acl_Filter_Attribute',
        'Mage_Api2_Model_Acl_Global_Role',
        'Mage_Api2_Model_Acl_Global_Rule',
        'Mage_Bundle_Model_Option',
        'Mage_Bundle_Model_Selection',
        'Mage_Catalog_Model_Product_Option',
        'Mage_Catalog_Model_Product_Option_Value',
        'Mage_Catalog_Model_Product_Type_Configurable_Attribute',
        'Mage_CatalogRule_Model_Flag',
        'Mage_Checkout_Model_Agreement',
        'Mage_Cms_Model_Block',
        'Mage_Core_Model_Design',
        'Mage_Core_Model_Email_Queue',
        'Mage_Core_Model_Url_Rewrite',
        'Mage_Core_Model_Variable',
        'Mage_Customer_Model_Flowpassword',
        'Mage_Dataflow_Model_Profile',
        'Mage_Dataflow_Model_Profile_History',
        'Mage_Downloadable_Model_Link',
        'Mage_Eav_Model_Entity_Attribute_Group',
        'Mage_Eav_Model_Entity_Store',
        'Mage_GiftMessage_Model_Message',
        'Mage_Index_Model_Event',
        'Mage_Index_Model_Process',
        'Mage_Log_Model_Visitor',
        'Mage_Oauth_Model_Consumer',
        'Mage_Poll_Model_Poll',
        'Mage_Poll_Model_Poll_Answer',
        'Mage_Poll_Model_Poll_Vote',
        'Mage_Reports_Model_Event',
        'Mage_Reports_Model_Flag',
        'Mage_Reports_Model_Product_Index_Compared',
        'Mage_Reports_Model_Product_Index_Viewed',
        'Mage_Sales_Model_Order_Creditmemo_Comment',
        'Mage_Sales_Model_Order_Invoice_Comment',
        'Mage_Sales_Model_Order_Shipment_Comment',
        'Mage_Sales_Model_Order_Status',
        'Mage_Sales_Model_Quote_Address_Rate',
        'Mage_Sales_Model_Quote_Item_Option',
        'Mage_SalesRule_Model_Coupon',
        'Mage_SalesRule_Model_Rule_Customer',
        'Mage_Sitemap_Model_Sitemap',
        'Mage_Tag_Model_Tag_Relation',
        'Mage_Tax_Model_Class',
        'Mage_Tax_Model_Calculation',
        'Mage_Tax_Model_Calculation_Rate',
        'Mage_Tax_Model_Calculation_Rule',
        'Mage_Wishlist_Model_Item_Option',
    );

    /**
     * Log $_event-prefix
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function logEventPrefix(Varien_Event_Observer $observer)
    {
        $object = $observer->getEvent()->getObject();
        $class = get_class($object);

        $exclude = array_merge(self::$existing, self::$new);
        if (!in_array($class, $exclude)) {
            $reflection = new ReflectionClass($object);
            $prefix = $reflection->getProperty('_eventPrefix');
            $prefix->setAccessible(true);
            $value = $prefix->getValue($object);

            $logFile = ($value == 'core_abstract') ? 'event-prefix_NEW.log' : 'event-prefix_CORE.log';
            Mage::log($class, null, $logFile);
        }
    }
}
