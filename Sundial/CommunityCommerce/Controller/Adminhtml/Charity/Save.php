<?php
namespace Sundial\CommunityCommerce\Controller\Adminhtml\Charity;
use Magento\Framework\App\Filesystem\DirectoryList;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
	 protected $_fileUploaderFactory;
	 protected $charityFactory;
	 public function __construct(
		\Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
		\Sundial\CommunityCommerce\Model\ResourceModel\Charity\CollectionFactory $charityCollectionFactory,
		\Magento\Backend\App\Action\Context $context     
	){
		$this->_fileUploaderFactory = $fileUploaderFactory;
		$this->charityFactory = $charityCollectionFactory;
		parent::__construct($context);
	}
	public function execute()
    {
	    $data = $this->getRequest()->getParams();
        if ($data) {
            $model = $this->_objectManager->create('Sundial\CommunityCommerce\Model\Charity');		
            if(isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != '') {
				try {
					    $uploader = $this->_fileUploaderFactory->create(['fileId' => 'logo']);
						$uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
						$uploader->setAllowRenameFiles(true);
						$uploader->setFilesDispersion(true);
						$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
							->getDirectoryRead(DirectoryList::MEDIA);
						$result = $uploader->save($mediaDirectory->getAbsolutePath('charity/'));
						unset($result['tmp_name']);
						unset($result['path']);
						$data['logo'] = $result['file'];
				} catch (Exception $e) {
					$data['logo'] = $_FILES['logo']['name'];
				}
			}
			
			$id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);				
            }
			if(!$id){
				$existingData = $this->charityFactory->create()
								  ->addFieldToFilter('charity_name', ['eq' => $data['charity_name']]);
				if(count($existingData) !=0){
					 $this->messageManager->addError(__('The Charity name already exists.'));
					 $this->_redirect('*/*/');
					 return;
				}				
			}
			
            $model->setData($data);
			
            try {
                $model->save();
                $this->messageManager->addSuccess(__('The Charity Has been Saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Charity.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            return;
        }
        $this->_redirect('*/*/');
    }
}
