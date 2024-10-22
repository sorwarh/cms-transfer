<?php

declare(strict_types=1);

namespace Sh\CmsTransfer\Controller\Adminhtml\Export;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\LocalizedException;

class Index extends Action
{
    protected $blockFactory;
    protected $pageFactory;
    protected $rawFactory;
    protected $jsonFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        $type = $this->getRequest()->getParam('type');
        $id = $this->getRequest()->getParam('id');
        // if ($type == 'block') {
        //     $cmsEntity = $this->blockFactory->create()->load($id);
        // } elseif ($type == 'page') {
        //     $cmsEntity = $this->pageFactory->create()->load($id);
        // } else {
        //     throw new LocalizedException(__('Invalid CMS type specified.'));
        // }
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->prepend(__('Export CMS ' . strtoupper($type) . ' #' . $id));
        return $page;
    }
}
