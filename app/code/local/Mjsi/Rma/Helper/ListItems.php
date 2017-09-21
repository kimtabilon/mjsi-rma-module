<?php
class Mjsi_Rma_Helper_ListItems extends Mage_Core_Helper_Abstract
{
    public function renderSample() 
	{
		echo "sample";
	}
	
	public function listRmaItems(Mjsi_Rma_Model_Mysql4_Rma_Items_Collection $items, $orderid )
	{
		ob_start();
		?>
        <table cellspacing="0" class="data-table" id="my-orders-table">
        	<thead>
            	<tr>
                    <th><?php echo $this->__('Product Details');?></th>
                    <th class="a-center"><?php echo $this->__('Qty');?></th>
                    <th><?php echo $this->__('Type of Return');?></th>
                    <th><?php echo $this->__('Status'); ?></th>
                </tr>
            </thead>
            <tbody>
            	<?php
					foreach( $items as $item )
					{
						//$product_id = $item->getOrderItem()->getProductId();
						$product_id = $item->getItemId();
						$product = false;
						$product = Mage::getModel( 'catalog/product' )->load( $product_id );
						$order = Mage::getModel('sales/order')->load($orderid);
						
						$items2 = $order->getAllItems();
						foreach ($items2 as $itemId2 => $item2)
						{
							if ($item2->getProductId() == $product_id ) {
								$product = $item2;
							}
						}
						?>
						<tr>
							<td>
								<strong><?php echo htmlentities( $product->getName() )?></strong>
								<br />
								<?php if (strlen(trim($item->getSerialNumber())) > 0): ?>
									<?php echo $this->__('Serial: ');?> <?php echo $item->getSerialNumber() ?>
									<br/>
								<?php endif; ?>
								<?php echo $this->__('SKU: ');?> <?php echo htmlentities( $product->getSku() )?>
							</td>
		
							<td class="a-center">
								<?php echo $item->getQty()?>
							</td>
							<td>
								<?php echo $item->getType()?>
							</td>
							<td><?php echo $item->getStatus()?></td>
						</tr>
						<?php
					}
					?>
            </tbody>
        </table>
        <script type="text/javascript">decorateTable('my-orders-table', {'tbody' : ['odd', 'even'], 'tbody tr' : ['first', 'last']})</script>
        <?php
		 return ob_get_clean();
	}
	
}
