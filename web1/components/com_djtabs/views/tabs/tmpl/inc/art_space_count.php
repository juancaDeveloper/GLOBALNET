<?php 
	$art_i = 0;
	$art_per_row = $tab->params->get('articles_per_row','1');
	$art_per_row = (is_numeric($art_per_row) && $art_per_row !='0') ? $art_per_row : '1';
	if ($art_per_row!='1' && $art_display=='3'){
		$art_space = $tab->params->get('articles_space','0');
		$art_space = is_numeric($art_space) ? $art_space : '0';	
		$art_width = (100-(($art_per_row-1) * $art_space))/$art_per_row;
		$art_width = "width:".$art_width."%;";
		$art_space = "margin-right:".$art_space."%;";
	}
	else {
		$art_width = "";
		$art_space = "";
	}
?>