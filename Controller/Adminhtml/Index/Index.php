<?php
namespace Inkifi\Consolidation\Controller\Adminhtml\Index;
use Inkifi\Consolidation\Processor as P;
// 2019-01-11
class Index extends \Magento\Backend\App\Action {
	/**
	 * 2019-01-11
	 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
	 * @override
	 * @see \Magento\Framework\App\ActionInterface::execute()
	 * @used-by \Magento\Framework\App\Action\Action::dispatch():
	 * 		$result = $this->execute();
	 * https://github.com/magento/magento2/blob/2.2.1/lib/internal/Magento/Framework/App/Action/Action.php#L84-L125
	 */
	function execute() {
		if (!P::s()->eligible()) {
			$this->messageManager->addWarning('The customer is not eligible for consolidation.');
		}
		else {
			P::s()->consolidate();
			$this->messageManager->addSuccess('The customer has been consilidated.');
		}
		return $this->_redirect('sales/order/view', ['order_id' => df_request('order_id')]);
	}
}