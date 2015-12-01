<div class="categorydiv">
<?php foreach ($tree as $node):?>
    <div class="checkbox">
    <?php echo $this->render("_taxonomy_child",['node'=>$node,'name'=>$name])?>
    </div>
<?php endforeach;?>
</div>