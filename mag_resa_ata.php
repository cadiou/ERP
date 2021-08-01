<?php

/*
 * 210504
 * timeticket / mag_resa_print.php
 * Baptiste Cadiou
 *
 */

include("HTML.class.php");
include("LOCAL.class.php");
$html = new LOCAL("R&Eacute;SA",-1);
$id=(isset($_POST['id'])?$_POST['id']:(isset($_GET['id'])?$_GET['id']:0));
header("Content-Type: text/csv; charset=UTF-8");
header("Content-Type: text/csv");
header("Content-disposition: filename=resa".$id.".csv");
if ($id>0) {
	$sql = 'SELECT `mag_brand`.`name`,
            `mag_model`.`reference`,
			`mag_model`.`description`,
			a.tag,
			a.`serial`,
            `mag_model`.`poids`,
            `mag_model`.`prix`,
			`mag_model`.`origine`
            FROM `mag_inventaire` AS a,`mag_model`,`mag_brand`,mag_resa_item,mag_class ';
    $sql.= 'WHERE `mag_model`.`id`=a.`model_id` and
            `mag_brand`.`id`=`mag_model`.`brand_id` and mag_class.id = a.class_id and ';
	$sql.= ' a.id = mag_resa_item.item_id AND mag_resa_item.resa_id='.$id;
	# $sql.= ' GROUP BY `mag_brand`.`name`,`mag_model`.`reference`,`mag_model`.`description`, a.`tag`, a.`serial`, a.`refMoscou`, a.`model_id`, mag_class.name';
	# $sql.= ' GROUP BY a.`serial`';
	$sql.= "  ORDER BY mag_brand.name,mag_model.reference";
	$result = $html->query($sql);
	if (mysqli_num_rows($result)!=0) {
		$i = 1;
		$formulaire=   utf8_decode('NOMBRE DE PIÈCES;CONTENANT;DÉSIGNATION;POIDS;UNITÉ POIDS;VALEUR HT;PAYS D\'ORIGINE').PHP_EOL;
		while ($item = mysqli_fetch_array($result)) {
			$formulaire .= "1;Marchandise ".$i++.";"
				.utf8_decode($item[0])." ".utf8_decode($item[1]).' '.utf8_decode($item[2])." ".($item[3]!=""?"(".utf8_decode($item[3]).") ":"")
				.($item[4]!=""?utf8_decode($item[4]):"N/C").';'.utf8_decode($item[5]).';kg;'
				.utf8_decode($item[6]).';'.utf8_decode($item[7]).PHP_EOL;
		}
	}
}
echo $formulaire; ?>
