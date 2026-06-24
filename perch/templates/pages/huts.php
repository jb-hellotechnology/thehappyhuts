<?php perch_layout('header'); ?>
<?php 
	if(perch_get('hut')){
		perch_collection('Huts', [
	        'template'   => 'hut.html',
	        'filter' => 'slug',
	        'match'  => 'eq',
	        'value'  => perch_get('hut'),
	    ]);
	}else{
		perch_content('Page Content');
		echo '<div class="text booking"><div class="restrict"><h2>Dog Friendly</h2></div></div>';
		perch_collection('Huts', [
	        'template'   => 'hut-list.html',
	        'sort'       => 'name',
	        'sort-order' => 'ASC',
	        'filter' => 'dog',
	        'match'  => 'eq',
	        'value'  => 'yes',
	    ]);
	    echo '<div class="text booking"><div class="restrict"><h2>No Dogs</h2></div></div>';
		perch_collection('Huts', [
	        'template'   => 'hut-list.html',
	        'sort'       => 'name',
	        'sort-order' => 'ASC',
	        'filter' => 'dog',
	        'match'  => 'eq',
	        'value'  => 'no',
	    ]);
    }
?>
<?php perch_layout('footer'); ?>