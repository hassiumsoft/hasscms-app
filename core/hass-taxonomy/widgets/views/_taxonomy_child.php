<label>


<input value='<?php echo $node['taxonomy_id']?>' type='checkbox' name='<?php echo $name?>[]' <?php echo $node['checked']?"checked":""?>>
<?php echo $node['name']?>
</label>

<?php if (count($node['children']) > 0) : ?>
<ul>
<?php foreach ($node['children'] as $item):?>
<li>
    <?php echo $this->render("_taxonomy_child",['node'=>$item,'name'=>$name])?>
</li>
<?php endforeach;?>
</ul>
<?php endif;?>
