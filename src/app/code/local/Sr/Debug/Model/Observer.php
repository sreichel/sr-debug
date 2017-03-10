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
    const LOG_MODEL = 'model';
    const LOG_COLLECTION = 'collection';
    const LOG_ADMINBLOCK = 'adminblock';

    /**
     * Tracked classes for PR
     *
     * @var array $new
     */
    private static $model = array(
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
        'Mage_Catalog_Model_Product_Flat_Flag',
        'Mage_Catalog_Model_Product_Option',
        'Mage_Catalog_Model_Product_Option_Value',
        'Mage_Catalog_Model_Product_Type_Configurable_Attribute',
        'Mage_CatalogRule_Model_Flag',
        'Mage_Checkout_Model_Agreement',
        'Mage_Cms_Model_Block',
        'Mage_Core_Model_Design',
        'Mage_Core_Model_Flag',
        'Mage_Core_Model_File_Storage_Flag',
        'Mage_Core_Model_Email_Queue',
        'Mage_Core_Model_Url_Rewrite',
        'Mage_Core_Model_Variable',
        'Mage_Customer_Model_Flowpassword',
        'Mage_Dataflow_Model_Profile',
        'Mage_Dataflow_Model_Profile_History',
        'Mage_Directory_Model_Country',
        'Mage_Directory_Model_Region',
        'Mage_Downloadable_Model_Link',
        'Mage_Downloadable_Model_Link_Purchased',
        'Mage_Downloadable_Model_Link_Purchased_Item',
        'Mage_Eav_Model_Entity_Attribute_Group',
        'Mage_Eav_Model_Entity_Store',
        'Mage_GiftMessage_Model_Message',
        'Mage_Index_Model_Event',
        'Mage_Index_Model_Process',
        'Mage_Log_Model_Customer',
        'Mage_Log_Model_Visitor',
        'Mage_Oauth_Model_Consumer',
        'Mage_Poll_Model_Poll',
        'Mage_Poll_Model_Poll_Answer',
        'Mage_Poll_Model_Poll_Vote',
        'Mage_Reports_Model_Event',
        'Mage_Reports_Model_Flag',
        'Mage_Reports_Model_Product_Index_Compared',
        'Mage_Reports_Model_Product_Index_Viewed',
        'Mage_Review_Model_Review_Summary',
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
        'Mage_Wishlist_Model_Wishlist',
    );

    private static $collection = array(
        'Mage_Catalog_Model_Resource_Collection_Abstract',
        'Mage_Customer_Model_Resource_Address_Collection',
        'Mage_Customer_Model_Resource_Customer_Collection',
        'Mage_Customer_Model_Resource_Wishlist_Collection',
        'Mage_Eav_Model_Entity_Collection',
        'Mage_Sales_Model_Entity_Order_Collection',
        'Mage_Sales_Model_Entity_Order_Address_Collection',
        'Mage_Sales_Model_Entity_Order_Creditmemo_Collection',
        'Mage_Sales_Model_Entity_Order_Creditmemo_Comment_Collection',
        'Mage_Sales_Model_Entity_Order_Creditmemo_Item_Collection',
        'Mage_Sales_Model_Entity_Order_Invoice_Collection',
        'Mage_Sales_Model_Entity_Order_Invoice_Comment_Collection',
        'Mage_Sales_Model_Entity_Order_Invoice_Item_Collection',
        'Mage_Sales_Model_Entity_Order_Item_Collection',
        'Mage_Sales_Model_Entity_Order_Payment_Collection',
        'Mage_Sales_Model_Entity_Order_Shipment_Collection',
        'Mage_Sales_Model_Entity_Order_Shipment_Comment_Collection',
        'Mage_Sales_Model_Entity_Order_Shipment_Item_Collection',
        'Mage_Sales_Model_Entity_Order_Shipment_Track_Collection',
        'Mage_Sales_Model_Entity_Order_Status_History_Collection',
        'Mage_Sales_Model_Entity_Quote_Collection',
        'Mage_Sales_Model_Entity_Quote_Address_Collection',
        'Mage_Sales_Model_Entity_Quote_Address_Item_Collection',
        'Mage_Sales_Model_Entity_Quote_Address_Rate_Collection',
        'Mage_Sales_Model_Entity_Quote_Item_Collection',
        'Mage_Sales_Model_Entity_Quote_Payment_Collection',
    );

    private static $adminblock = array(
    );

    /**
     * Log model classes WITHOUT $_event-prefix
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function logEventPrefix(Varien_Event_Observer $observer)
    {
        $object = $observer->getEvent()->getObject();
        $this->_log(get_class($object), self::LOG_MODEL);
    }

    /**
     * Log eav collection classes WITHOUT $_event-prefix
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function logEventPrefixCollection(Varien_Event_Observer $observer)
    {
        $object = $observer->getEvent()->getCollection();
        $this->_log(get_class($object), self::LOG_COLLECTION);
    }

    /**
     * Log adminhtml block classes WITHOUT $_event-prefix
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function logEventPrefixBlock(Varien_Event_Observer $observer)
    {
        $object = $observer->getEvent()->getBlock();
        $this->_log(get_class($object), self::LOG_ADMINBLOCK);
    }

    /**
     * Write logfile
     *
     * @param string $class
     * @param string $type
     */
    private function _log($class, $type)
    {
        if (Mage::getStoreConfigFlag('dev/event_prefix_log_' . $type . '/active')) {
            if (!in_array($class, self::$$type)) {
                if (substr($class, 0, 5) === 'Mage_') {
                    Mage::log($class, null, "event-prefix-{$type}.log", true);
                }
            }
        }
    }
}
