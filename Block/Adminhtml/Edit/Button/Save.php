<?php

declare(strict_types=1);

namespace Sh\CmsTransfer\Block\Adminhtml\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Save implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Update'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'update'],
                ],
            ],
        ];
    }
}
