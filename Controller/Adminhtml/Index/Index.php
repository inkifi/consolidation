<?php
namespace Inkifi\Consolidation\Controller\Adminhtml\Index;
use Magento\Sales\Model\Order as O;
use Magento\Sales\Model\Order\Item as OI;
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
		$o = df_order($oid = (int)df_request('order_id')); /** @var int $oid */ /** @var O $o */
		if ((int)$cid = $o->getCustomerId()) { /** @var int|null $cid */
			$oi = df_first(df_oqi_leafs($o)); /** @var OI $oi */
			// 2019-01-11 A string like «5e2d6cd7-f32c-4c89-97a4-4acda92811fb».
			$pid = $oi['mediaclip_project_id']; /** @var string $pid */
			// 2019-01-11
			// It could be a string like «f6549c2f-9230-f8e8-f1e4-625c7ac4f2f1»
			// or a Magento customer ID like «65963».
			$mcid = df_fetch_one('mediaclip', 'user_id', ['project_id' => $pid]);
			if (df_is_guid($mcid)) {
				$this->messageManager->addSuccess($mcid);
			}
		}
		return df_redirect('sales/order/view', ['order_id' => $oid]);
	}
}