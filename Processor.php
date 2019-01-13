<?php
namespace Inkifi\Consolidation;
use Inkifi\Mediaclip\API\Facade\User as fUser;
use Magento\Sales\Model\Order as O;
// 2019-01-12
final class Processor {
	/**
	 * 2019-01-12
	 * @used-by \Inkifi\Consolidation\Controller\Adminhtml\Index\Index::execute()
	 */
	function consolidate() {
		$this->f()->consolidate($this->mcid());
		$this->updateDb();
	}

	/**
	 * 2019-01-12
	 * @used-by \Inkifi\Consolidation\Controller\Adminhtml\Index\Index::execute()
	 * @used-by \Inkifi\Consolidation\Plugin\Backend\Block\Widget\Button\Toolbar::beforePushButtons()
	 * @return bool
	 */
	function eligible() {
		$r = false; /** @var bool $r */
		// 2019-01-11 A string like «5e2d6cd7-f32c-4c89-97a4-4acda92811fb».
		// 2019-01-11
		// It could be a string like «f6549c2f-9230-f8e8-f1e4-625c7ac4f2f1»
		// or a Magento customer ID like «65963».
		if (df_is_guid($mcid = $this->mcid())) { /** @var string $mcid */
			if (!in_array($this->pid(), $this->f()->projects())) {
				$r = true;
			}
			else {
				// 2018-01-12
				// The user has been consolidated manually before the module's installation.
				// We need to update his ID in Magento.
				$this->updateDb();
			}
		}
		return $r;
	}

	/**
	 * 2019-01-12
	 * @used-by s()
	 * @param O $o
	 */
	private function __construct(O $o) {$this->_o = $o;}

	/**
	 * 2019-01-12
	 * @used-by f()
	 * @used-by updateDb()
	 * @return int
	 */
	private function cid() {return (int)$this->_o->getCustomerId();}

	/**
	 * 2019-01-12
	 * @used-by consolidate()
	 * @return fUser
	 */
	private function f() {return dfc($this, function() {return new fUser(
		$this->cid(), $this->_o->getStore()
	);});}

	/**
	 * 2019-01-12
	 * @used-by consolidate()
	 * @return string
	 */
	private function mcid() {return dfc($this, function() {return df_fetch_one(
		'mediaclip', 'user_id', ['project_id' => $this->pid()]
	);});}

	/**
	 * 2019-01-12
	 * @used-by eligible()
	 * @used-by mcid()
	 * @used-by updateDb()
	 * @return string
	 */
	private function pid() {return dfc($this, function() {return
		df_first(df_oqi_leafs($this->_o))['mediaclip_project_id']
	;});}

	/**
	 * 2019-01-14
	 * @used-by consolidate()
	 * @used-by eligible()
	 */
	private function updateDb() {df_conn()->update(
		'mediaclip', ['user_id' => $this->cid()], ['? = project_id' => $this->pid()]
	);}

	/**
	 * 2019-01-12
	 * @used-by pid()
	 * @var O
	 */
	private $_o;

	/**
	 * 2019-01-12
	 * @used-by \Inkifi\Consolidation\Controller\Adminhtml\Index\Index::execute()
	 * @used-by \Inkifi\Consolidation\Plugin\Backend\Block\Widget\Button\Toolbar::beforePushButtons()
	 * @param int|null $oid [optional]
	 * @return self
	 */
	static function s($oid = null) {return dfcf(function($oid) {return
		new self(df_order($oid))
	;}, [intval($oid ?: df_request('order_id'))]);}
}