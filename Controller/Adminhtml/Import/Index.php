<?php

declare(strict_types=1);

namespace Sh\CmsTransfer\Controller\Adminhtml\Import;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Cms\Model\BlockFactory;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;

class Index extends Action
{
    protected $blockFactory;
    protected $pageFactory;
    protected $rawFactory;
    protected $jsonFactory;

    public function __construct(
        Context $context,
        BlockFactory $blockFactory,
        PageFactory $pageFactory,
        RawFactory $rawFactory,
        JsonFactory $jsonFactory,
    ) {
        parent::__construct($context);
        $this->blockFactory = $blockFactory;
        $this->pageFactory = $pageFactory;
        $this->rawFactory = $rawFactory;
        $this->jsonFactory = $jsonFactory;
    }

    public function execute()
    {
        $resultRaw = $this->rawFactory->create();
        $resultJson = $this->jsonFactory->create();

        try {
            $type = $this->getRequest()->getParam('type');
            $id = $this->getRequest()->getParam('id');

            if ($type == 'block') {
                $cmsEntity = $this->blockFactory->create()->load($id);
            } elseif ($type == 'page') {
                $cmsEntity = $this->pageFactory->create()->load($id);
            } else {
                throw new LocalizedException(__('Invalid CMS type specified.'));
            }

            if (!$cmsEntity->getId()) {
                throw new LocalizedException(__('Entity ID #%1 does not exist', $id));
            }
            $env_name = 'env_name';

            $jsonContent = json_encode($cmsEntity->getData(), JSON_PRETTY_PRINT);
            $timestamp = date('Ymd_His');
            $fileName = $env_name.'_cms_' . $type . '_' . $id . '_' . $timestamp . '.json';

            $resultRaw->setHeader('Content-Type', 'application/json', true);
            $resultRaw->setHeader('Content-Disposition', 'attachment; filename=' . $fileName, true);
            $resultRaw->setContents($jsonContent);

            return $resultRaw;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error exporting: %1', $e->getMessage()));
            return $resultJson->setData(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
