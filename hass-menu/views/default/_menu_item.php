<div class="categorydiv">
<?php foreach ($tree as $node):?>
    <div class="checkbox">
    <?php echo $this->render("_menu_item_child",["node"=>$node])?>
    </div>
<?php endforeach;?>
</div>