<?php
namespace Inkifi\Consolidation\Plugin\Backend\Block\Widget\Button;
use Inkifi\Consolidation\Processor as P;
use Magento\Backend\Block\Widget\Button\ButtonList;
use Magento\Backend\Block\Widget\Button\Toolbar as Sb;
use Magento\Framework\View\Element\AbstractBlock;
// 2019-01-11
final class Toolbar {
	/**
	 * 2019-01-11
	 * The plugin's purpose is to add the «Fix the Customer» buttom to the backend order view.
	 * https://magento.stackexchange.com/a/91134
	 * @see \Magento\Backend\Block\Widget\Button\Toolbar::pushButtons()
	 *		foreach ($buttonList->getItems() as $buttons) {
	 *			foreach ($buttons as $item) {
	 *				$containerName = $context->getNameInLayout() . '-' . $item->getButtonKey();
	 *				$container = $this->createContainer($context->getLayout(), $containerName, $item);
	 *				if ($item->hasData('name')) {
	 *					$item->setData('element_name', $item->getName());
	 *				}
	 *				if ($container) {
	 *					$container->setContext($context);
	 *					$toolbar = $this->getToolbar($context, $item->getRegion());
	 *					$toolbar->setChild($item->getButtonKey(), $container);
	 *				}
	 *			}
	 *		}
	 * https://github.com/magento/magento2/blob/2.2.0/app/code/Magento/Backend/Block/Widget/Button/Toolbar.php#L16-L38
	 * @used-by \Magento\Backend\Block\Widget\Container::_prepareLayout()
	 *		$this->toolbar->pushButtons($this, $this->buttonList);
	 *		return parent::_prepareLayout();
	 * https://github.com/magento/magento2/blob/2.2.0/app/code/Magento/Backend/Block/Widget/Container.php#L117-L126
	 * @param Sb $sb
	 * @param AbstractBlock $b
	 * @param ButtonList $l
	 */
	function beforePushButtons(Sb $sb, AbstractBlock $b, ButtonList $l) {
		if (df_action_is('sales_order_view') && P::s()->eligible()) {
			$l->add('inkifi__fix_the_customer', [
				'class' => 'inkifi__fix_the_customer'
				,'label' => __('Consolidate')
				,'onclick' => "setLocation('{$b->getUrl('inkifi-consolidation')}')"
			], -1);
		}
	}
}