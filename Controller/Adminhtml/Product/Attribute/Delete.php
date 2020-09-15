<?php
namespace Magepow\ProductAttributesMassAction\Controller\Adminhtml\Product\Attribute;

class Delete extends \Magento\Backend\App\Action{
    public function execute()
    {
        $attributeCodesToDelete = $this->getRequest()->getParam('attribute_codes');

        $resultRedirect = $this->resultRedirectFactory->create();

        $successfullyDeletedCodes = [];
        $errorDeletedCodes = [];
        $lastErrorMessage = "";

        foreach($attributeCodesToDelete as $attributeCodeToDelete){
            $model = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Eav\Attribute');
            $model->load($attributeCodeToDelete, 'attribute_code');
            if($model && $model->getId()){
                try {
                    $model->delete();
                    $successfullyDeletedCodes[] = $attributeCodeToDelete;
                } catch (\Exception $e) {
                    $errorDeletedCodes[] = $attributeCodeToDelete;
                    $lastErrorMessage = $e->getMessage();
                }
            }
        }

        if(count($errorDeletedCodes) > 0){
            $errorMessage = sprintf(
                "Failed to delete the following attributes: %s. Last error message: %s. Succeeded to delete the following attributes: %s.",
                implode(",",$errorDeletedCodes),
                $lastErrorMessage,
                implode(",",$successfullyDeletedCodes)
            );
            $this->messageManager->addErrorMessage($errorMessage);
        }else{
            $successMessage = sprintf(
                "You successfully deleted the following %s attributes: %s.",
                count($successfullyDeletedCodes),
                implode(",",$successfullyDeletedCodes)
            );
            $this->messageManager->addSuccessMessage($successMessage);
        }

        return $resultRedirect->setPath('catalog/*/');
    }
}