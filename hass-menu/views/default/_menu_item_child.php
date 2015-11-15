<?php $id = $node['id'];?>
<label>
<input value='<?php echo $node['id']?>' type='checkbox' name="menu-item[<?php echo $id?>][original]">
<input value='<?php echo $node['name']?>'  type='hidden' name="menu-item[<?php echo $id?>][name]">
<input value='<?php echo isset($parent)?$parent:0;?>'  type='hidden' name="menu-item[<?php echo $id?>][parent]">
<?php echo $node['name']?>
</label>
<?php if (count($node['children']) > 0) : ?>
<ul>
<?php foreach ($node['children'] as $item):?>
<li>
    <?php echo $this->render("_menu_item_child",['node'=>$item,"parent"=>$id])?>
</li>
<?php endforeach;?>
</ul>
<?php endif;?>
