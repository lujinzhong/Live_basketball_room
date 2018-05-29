<?php

	$table=new swoole_table(1024);
    //create the column
	$table->column('id',swoole_table::TYPE_INT);
	$table->column('name',swoole_table::TYPE_STRING,4);
	$table->column('tel',swoole_table::TYPE_INT);

	//create memory table
	$table->create();

	//set the value
	$table->set('xiaolu',
		[
		  'id'=>1,
		  'name'=>'luxiaolu',
		  'tel'=>13692584578
		]);
	//get the value
	print_r($table->get('xiaolu')).PHP_EOL;
	//incr the num
	$table->incr('xiaolu','id',2);
	print_r($table->get('xiaolu')).PHP_EOL;
	//decr the num
	$table->decr('xiaolu','id',1);
	print_r($table->get('xiaolu')).PHP_EOL;
	//key is exist?
	var_dump($table->exist('xiaolu')).PHP_EOL;
	//get the tables nums
	$table_nums=$table->count();
	var_dump($table_nums);


