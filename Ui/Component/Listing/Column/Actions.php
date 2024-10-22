<?php

declare(strict_types=1);

namespace Sh\CmsTransfer\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\ImportExport\Controller\Adminhtml\Export\File\Download;
use Magento\ImportExport\Controller\Adminhtml\Export\File\Delete;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * ExportGridActions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }
        foreach ($dataSource['data']['items'] as &$item) {
            if (!isset($item['block_id'])) {
                continue;
            }

            $item[$this->getData('name')] = [
                'import' => [
                    'href' => $this->urlBuilder->getUrl('sh_cmstransfer/import/index', [
                        'id' => $item['block_id'],
                        'type' => 'block',
                    ]),
                    'ariaLabel' => __('Import') . $item['title'],
                    'label' => __('Import'),
                ],

                'export' => [
                    'href' => $this->urlBuilder->getUrl('sh_cmstransfer/export/index', [
                        'id' => $item['block_id'],
                        'type' => 'block',
                    ]),
                    'ariaLabel' => __('Export') . $item['title'],
                    'label' => __('Export'),
                    'hidden' => false,
                ],

            ];
        }
        return $dataSource;
    }
}
