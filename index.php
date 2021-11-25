<?php
/*
 * 211115 CADIOU.DEV
 * RT ERP / index.php
 *
 */

class HTML {
	public function __construct($concept,$list) {
		# CONFIG
		if (file_exists("CONFIG.class.php")) {
			$this->check_config = include_once("CONFIG.class.php");
		}elseif (file_exists("../CONFIG.class.php")) {
			$this->check_config = include_once("../CONFIG.class.php");
		}
		# DATABASE
		$this->mysqli = new mysqli( CONFIG::DB_SERVER,
			CONFIG::DB_USERNAME,
			CONFIG::DB_PASSWORD,
			CONFIG::DB_NAME);
		$this->mysqli->set_charset(CONFIG::DB_CHARSET);
		# COOKIE UID SETTING
		if (isset($_POST["scanner"]) and $_POST["scanner"]=="USER0") {
			$this->uid = -1;
			setcookie(CONFIG::COOKIE_UID, null, -1);
		}elseif (isset($_POST["scanner"]) and substr($_POST["scanner"],0,4)=="USER") {
			$this->uid = substr($_POST["scanner"],4);	
			SetCookie(CONFIG::COOKIE_UID,$this->uid, time()+CONFIG::COOKIE_SEC);
		}elseif ((isset($_POST["user_id"]) and $_POST["user_id"]==-1) ) {
			$this->uid = -1;
			setcookie(CONFIG::COOKIE_UID, null, -1);
		}elseif (isset($_POST["user_id"]) and $_POST["user_id"]>0) {
			$this->uid =  $_POST["user_id"];
			SetCookie(CONFIG::COOKIE_UID,$this->uid, time()+CONFIG::COOKIE_SEC);
		}else{
			if (isset($_COOKIE[CONFIG::COOKIE_UID])) {
				$this->uid = $_COOKIE[CONFIG::COOKIE_UID];
			}else{
				$this->uid = -1;
			}
		}
		# TERMINAL SETTING
		if (isset($_SERVER['REMOTE_HOST'])) {
			$this->terminal = $_SERVER['REMOTE_HOST'];
		}elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$this->terminal = $_SERVER['REMOTE_ADDR'];
		}else{
			$this->terminal = "LAZARUS";
		}
		# HEADER

		if (null !== CONFIG::HTML_HEADER) {
			$this->head= CONFIG::HTML_HEADER."\n";
		}else{
			$this->head="";
		}
		$this->head.= "<title>".(isset($_GET['concept'])?$_GET['concept']:'ERP').' '.$this->station(CONFIG::ID_STATION)."</title>\n";
		
		$this->head.=
		'<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n".
		'<link href="style.css" rel="stylesheet" media="all" type="text/css" />'."\n".
		'<meta Http-Equiv="Cache-Control" Content="no-cache">'."\n".
		'<meta Http-Equiv="Pragma" Content="no-cache">'."\n".
		'<meta Http-Equiv="Expires" Content="0">'."\n".
		'<meta Http-Equiv="Pragma-directive: no-cache">'."\n".
		'<meta Http-Equiv="Cache-directive: no-cache">'."\n";
		$this->head.=
			'<!--  ERP RT FRANCE  -->'."\n".
			'<!--  Baptiste CADIOU.DEV  -->'."\n".
			'<!--  https://github.com/cadiou/  -->'."\n";
		
		# FOOTER
		$this->foot = "<hr />\n";
		$this->foot .= $this->group(CONFIG::ID_GROUP)." / ".CONFIG::DB_NAME." / ".gethostname()."\n";
		

		# MENUBAR

		$this->menu='<table class="menubar"><tr><td>';
		if ($this->uid>0) {
			if ($concept<>"RESAS") {
				$this->menu.='<a href="?concept=RESAS" class="menubut">R&Eacute;SERVER</a> ';
			}else{
				$this->menu.='<a href="?concept=RESAS" class="menuact">R&Eacute;SERVER</a> ';
			}
		}
		if ($concept<>"PLANNING") {
			$this->menu.='<a href="?concept=PLANNING" class="menubut">PLANNING</a> ';
		}else{
			$this->menu.='<a href="?concept=PLANNING" class="menuact">PLANNING</a> ';
		}
		if ($concept<>"INVENTAIRE") {
			$this->menu.='<a href="?concept=INVENTAIRE" class="menubut">INVENTAIRE</a> ';
		}else{
			$this->menu.='<a href="?concept=INVENTAIRE" class="menuact">INVENTAIRE</a> ';
			if ($list<>"CLASS") {
				$this->menu.='<a href="?concept=INVENTAIRE&list=CLASS" class="menubut">CLASSE</a> ';
			}else{
				$this->menu.='<a href="?concept=INVENTAIRE&list=CLASS" class="menuact">CLASSE</a> ';
			}
			if ($list<>"BRAND") {
				$this->menu.='<a href="?concept=INVENTAIRE&list=BRAND" class="menubut">MARQUE</a> ';
			}else{
				$this->menu.='<a href="?concept=INVENTAIRE&list=BRAND" class="menuact">MARQUE</a> ';
			}
			if ($list<>"MODEL") {
				$this->menu.='<a href="?concept=INVENTAIRE&list=MODEL" class="menubut">MOD&Egrave;LE</a> ';
			}else{
				$this->menu.='<a href="?concept=INVENTAIRE&list=MODEL" class="menuact">MOD&Egrave;LE</a> ';
			}
			if ($list<>"CATEGORIE") {
				$this->menu.='<a href="?concept=INVENTAIRE&list=CATEGORIE" class="menubut">CAT&Eacute;GORIE</a> ';
			}else{
				$this->menu.='<a href="?concept=INVENTAIRE&list=CATEGORIE" class="menuact">CAT&Eacute;GORIE</a> ';
			}
			if ($list<>"AREA") {
				$this->menu.='<a href="?concept=INVENTAIRE&list=AREA" class="menubut">LIEU</a> ';
			}else{
				$this->menu.='<a href="?concept=INVENTAIRE&list=AREA" class="menuact">LIEU</a> ';
			}
			if ($list<>"SIM") {
				$this->menu.='<a href="?concept=INVENTAIRE&list=SIM" class="menubut">SIM</a> ';
			}else{
				$this->menu.='<a href="?concept=INVENTAIRE&list=SIM" class="menuact">SIM</a> ';
			}
		}
		if ($concept<>"HISTORIQUE") {
			$this->menu.='<a href="?concept=HISTORIQUE" class="menubut">HISTORIQUE</a> ';
		}else{
			$this->menu.='<a href="?concept=HISTORIQUE" class="menuact">HISTORIQUE</a> ';
		}
		if ($concept<>"CONTACTS") {
			$this->menu.='<a href="?concept=CONTACTS" class="menubut">CONTACTS</a> ';
		}else{
			$this->menu.='<a href="?concept=CONTACTS" class="menuact">CONTACTS</a> ';
		}
		if ($concept<>"HELP") {
			$this->menu.='<a href="?concept=HELP" class="menubut">AIDE</a> ';
		}else{
			$this->menu.='<a href="?concept=HELP" class="menuact">AIDE</a> ';
		}
		$this->menu.='</td><td class="menusel">';
		# LOGIN ET BARCODE
		$this->menu .= "<FORM method=\"POST\">";
		# BARCODE
		$this->menu .= '<input type="text" id="scanner" name="scanner" size="2" placeholder="SCAN" autofocus class="scanner">';
		$this->menu .= "</FORM>";
		$this->menu .= "<FORM method=\"POST\">";
		# UTILISATEUR
		$sql = "select `id`,`name` from user where name is not null and active = true and station_ID = ".CONFIG::ID_STATION." order by `name` asc";
		$result = $this->query($sql);
		$this->menu .= '<SELECT NAME="user_id" onchange="this.form.submit()">';
		$this->menu .= '<OPTION VALUE="-1">Identifiez-vous !</A>';
		while ($item = mysqli_fetch_array($result)) {
			$this->menu .= '<OPTION VALUE="'.$item['id'].'"';
			if (($this->uid == $item['id'])and($this->uid != "")) {
			$this->menu .= " SELECTED";
			}
			$this->menu .= '>'.$item['name'].'</OPTION>'."\n";
		}
		$this->menu .= '</SELECT>';
		$this->menu .= "</FORM>";
		$this->menu.='</td>';
		$this->menu.='</tr></table>';

		$this->body = "";

	}
	public function body($text) {
		$this->body .= "<p>".$text."</p>\n";
	}
	public function user($uid) {
		$query = "SELECT name ".
				" FROM `user`".
				" WHERE id = '".$uid."' and station_id = ".CONFIG::ID_STATION;
		$result = $this->query($query);
		if (mysqli_num_rows($result)>0) {
			$item = mysqli_fetch_array($result);
				return ($item[0]);
		}
	}
	public function initials($thread){
		$query = "SELECT username ".
				" FROM `user`".
				" WHERE id='".$thread."' and station_id = ".CONFIG::ID_STATION;
		$result = $this->query($query);
		if (mysqli_num_rows($result)>0) {
			$item = mysqli_fetch_array($result);
				return ($item[0]);
		}
	}
  	public function station($station_id) {
    		$query = "SELECT name ".
        		" FROM `station`".
        		" WHERE id='".$station_id."'";
    		$result = $this->query($query);
    		if (mysqli_num_rows($result)>0) {
      			$item = mysqli_fetch_array($result);
        		return ($item[0]);
    		}
  	}
  	public function group($group_id) {
		$query = "SELECT name ".
       		" FROM `group`".
       		" WHERE id='".$group_id."'";
   		$result = $this->query($query);
   		if (mysqli_num_rows($result)>0) {
   			$item = mysqli_fetch_array($result);
       		return ($item[0]);
   		}
  	}
	public function menuselect($table,$value,$option,$selected) {
		if ($table=="concept") {
			$inactivity = " AND active = 1";
		}else{
			$inactivity = "";
		}
		$sql = "select `".$value."`,`".$option."` from `".$table."` where `".$value."` is not null and station_id = ".CONFIG::ID_STATION.$inactivity." order by `".$option."` asc";
		$result = $this->query($sql);
		$out  = '<SELECT NAME="'.$table."_".$value.'" onchange="this.form.submit()">';
       	$out .= '<OPTION VALUE="-1">N/A</A>';
		while ($item = mysqli_fetch_array($result)) {
			$out .= '<OPTION VALUE="'.$item[$value].'"';
			if (($selected == $item[$value])and($selected != "")) {
				$out .= " SELECTED";
			}
			$out .= '>'.$item[$option].'</OPTION>'."\n";
		}
      	$out .= '</SELECT>';
       	return $out;
	}
	public function out() {

		if (isset($this->redirect)) {
			header("Location: ".$this->redirect);
		}
		echo "<html>\n";
		echo "<head>\n";
		echo $this->head;
		echo "</head>\n";
		echo "<body>\n";
		echo $this->menu;
		if (isset($this->info)) {
			echo '<p class="inforow" onload="beep()" >'.$this->info.'</p>';
			?>
			<script>
			function beep() {
			(new
			Audio(
			"data:audio/wav;base64,//uQRAAAAWMSLwUIYAAsYkXgoQwAEaYLWfkWgAI0wWs/ItAAAGDgYtAgAyN+QWaAAihwMWm4G8QQRDiMcCBcH3Cc+CDv/7xA4Tvh9Rz/y8QADBwMWgQAZG/ILNAARQ4GLTcDeIIIhxGOBAuD7hOfBB3/94gcJ3w+o5/5eIAIAAAVwWgQAVQ2ORaIQwEMAJiDg95G4nQL7mQVWI6GwRcfsZAcsKkJvxgxEjzFUgfHoSQ9Qq7KNwqHwuB13MA4a1q/DmBrHgPcmjiGoh//EwC5nGPEmS4RcfkVKOhJf+WOgoxJclFz3kgn//dBA+ya1GhurNn8zb//9NNutNuhz31f////9vt///z+IdAEAAAK4LQIAKobHItEIYCGAExBwe8jcToF9zIKrEdDYIuP2MgOWFSE34wYiR5iqQPj0JIeoVdlG4VD4XA67mAcNa1fhzA1jwHuTRxDUQ//iYBczjHiTJcIuPyKlHQkv/LHQUYkuSi57yQT//uggfZNajQ3Vmz+ Zt//+mm3Wm3Q576v////+32///5/EOgAAADVghQAAAAA//uQZAUAB1WI0PZugAAAAAoQwAAAEk3nRd2qAAAAACiDgAAAAAAABCqEEQRLCgwpBGMlJkIz8jKhGvj4k6jzRnqasNKIeoh5gI7BJaC1A1AoNBjJgbyApVS4IDlZgDU5WUAxEKDNmmALHzZp0Fkz1FMTmGFl1FMEyodIavcCAUHDWrKAIA4aa2oCgILEBupZgHvAhEBcZ6joQBxS76AgccrFlczBvKLC0QI2cBoCFvfTDAo7eoOQInqDPBtvrDEZBNYN5xwNwxQRfw8ZQ5wQVLvO8OYU+mHvFLlDh05Mdg7BT6YrRPpCBznMB2r//xKJjyyOh+cImr2/4doscwD6neZjuZR4AgAABYAAAABy1xcdQtxYBYYZdifkUDgzzXaXn98Z0oi9ILU5mBjFANmRwlVJ3/6jYDAmxaiDG3/6xjQQCCKkRb/6kg/wW+kSJ5//rLobkLSiKmqP/0ikJuDaSaSf/6JiLYLEYnW/+kXg1WRVJL/9EmQ1YZIsv/6Qzwy5qk7/+tEU0nkls3/zIUMPKNX/6yZLf+kFgAfgGyLFAUwY//uQZAUABcd5UiNPVXAAAApAAAAAE0VZQKw9ISAAACgAAAAAVQIygIElVrFkBS+Jhi+EAuu+lKAkYUEIsmEAEoMeDmCETMvfSHTGkF5RWH7kz/ESHWPAq/kcCRhqBtMdokPdM7vil7RG98A2sc7zO6ZvTdM7pmOUAZTnJW+NXxqmd41dqJ6mLTXxrPpnV8avaIf5SvL7pndPvPpndJR9Kuu8fePvuiuhorgWjp7Mf/PRjxcFCPDkW31srioCExivv9lcwKEaHsf/7ow2Fl1T/9RkXgEhYElAoCLFtMArxwivDJJ+bR1HTKJdlEoTELCIqgEwVGSQ+hIm0NbK8WXcTEI0UPoa2NbG4y2K00JEWbZavJXkYaqo9CRHS55FcZTjKEk3NKoCYUnSQ 0rWxrZbFKbKIhOKPZe1cJKzZSaQrIyULHDZmV5K4xySsDRKWOruanGtjLJXFEmwaIbDLX0hIPBUQPVFVkQkDoUNfSoDgQGKPekoxeGzA4DUvnn4bxzcZrtJyipKfPNy5w+9lnXwgqsiyHNeSVpemw4bWb9psYeq//uQZBoABQt4yMVxYAIAAAkQoAAAHvYpL5m6AAgAACXDAAAAD59jblTirQe9upFsmZbpMudy7Lz1X1DYsxOOSWpfPqNX2WqktK0DMvuGwlbNj44TleLPQ+Gsfb+GOWOKJoIrWb3cIMeeON6lz2umTqMXV8Mj30yWPpjoSa9ujK8SyeJP5y5mOW1D6hvLepeveEAEDo0mgCRClOEgANv3B9a6fikgUSu/DmAMATrGx7nng5p5iimPNZsfQLYB2sDLIkzRKZOHGAaUyDcpFBSLG9MCQALgAIgQs2YunOszLSAyQYPVC2YdGGeHD2dTdJk1pAHGAWDjnkcLKFymS3RQZTInzySoBwMG0QueC3gMsCEYxUqlrcxK6k1LQQcsmyYeQPdC2YfuGPASCBkcVMQQqpVJshui1tkXQJQV0OXGAZMXSOEEBRirXbVRQW7ugq7IM7rPWSZyDlM3IuNEkxzCOJ0ny2ThNkyRai1b6ev//3dzNGzNb//4uAvHT5sURcZCFcuKLhOFs8mLAAEAt4UWAAIABAAAAAB4qbHo0tIjVkUU//uQZAwABfSFz3ZqQAAAAAngwAAAE1HjMp2qAAAAACZDgAAAD5UkTE1UgZEUExqYynN1qZvqIOREEFmBcJQkwdxiFtw0qEOkGYfRDifBui9MQg4QAHAqWtAWHoCxu1Yf4VfWLPIM2mHDFsbQEVGwyqQoQcwnfHeIkNt9YnkiaS1oizycqJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7 FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb//////////////////////////// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU="
			)).play();
			}
			beep();
			</script>
			<?php
		}
		echo $this->body;
		echo $this->foot;
		echo "</body>\n";
		echo "</html>";
	}
	public function h2($header) {
		$this->body.="<h2>".$header."</h2>";
	}
	public function query($query) {
		$result = mysqli_query($this->mysqli,$query) or die($query." : ".mysqli_error($this->mysqli));
		return $result;
	}
	public function menuswitch($table,$value,$option,$selected) {
		$sql = "select `".$value."`,`".$option."` from `".$table."` where `".$value."` is not null and station_id = ".CONFIG::ID_STATION." order by `".$option."` asc";
        $result = $this->query($sql);
        $out  = '<SELECT NAME="'.$table."_".$value.'" onchange="this.form.submit()">';
        while ($item = mysqli_fetch_array($result)) {
            $out .= '<OPTION VALUE="'.$item[$value].'"';
            if (($selected == $item[$value])and($selected != "")) {
                $out .= " SELECTED";
            }
            $out .= '>'.$item[$option].'</OPTION>';
        }
        $out .= '</SELECT>';
        return $out;
    }
	public function mag_historique($order,$show_item) {
		# SELECTION
		# 0 `mag_item_log`.id
		# 1 `mag_item_log`.item_id
		# 2 `mag_item_log`.datetime
		# 3 `mag_item_log`.initials
		# 4 `mag_item_log`.body
		# 5 `mag_item_log`.level
		# 6 `mag_item_log`.snapshot
		# 7 `mag_item_log`.active
		# 8 `mag_item_log`.uid
		# 9 `mag_class`.name
		#10 `mag_brand`.name
		#11 `mag_model`.reference
		#12 `mag_inventaire`.tag
		$query = "SELECT `mag_item_log`.id,`mag_item_log`.item_id,".
			"`mag_item_log`.datetime,`mag_item_log`.initials,`mag_item_log`.body,".
			"`mag_item_log`.level,".
			"`mag_item_log`.snapshot,`mag_item_log`.active,`mag_item_log`.uid,".
			"`mag_class`.name,`mag_brand`.name,`mag_model`.reference,".
			"`mag_inventaire`.tag".
			" FROM `mag_item_log`,`mag_class`,`mag_brand`,`mag_model`,`mag_inventaire`".
			" WHERE mag_item_log.station_id = ".CONFIG::ID_STATION.
			" AND `mag_class`.`id`=`mag_inventaire`.`class_id`".
			" AND `mag_brand`.`id`=`mag_model`.`brand_id`".
			" AND `mag_model`.`id`=`mag_inventaire`.`model_id`".
			" AND `mag_item_log`.`item_id`=`mag_inventaire`.`id` ".$order;
		$result = $this->query($query);
		if (mysqli_num_rows($result)!=0) {
			$out= "<table width=\"100%\">";
			while ($item = mysqli_fetch_array($result)) {
				$out.= '<tr'.($show_item?' class="tr_hover" onclick="window.location.href = \'?concept=INVENTAIRE&item_id='.$item[1].'\'':"").'">';
				$out.= "<td>".$item['datetime']."</td>";
				if ($show_item) {
					$out.= "<td>".$item[9]."</td>";
					$out.= "<td>".$item[10]."</td>";
					$out.= "<td>".$item[11]."</td>";
				}
				$out.= "<td>".($item['uid']!=-1?$this->user($item['uid']):$item['initials'])."</td>";
				$out.= "<td>";
				if ($item[6]<>"") {
					$out.= "<a href=\"?concept=IMAGE_LOG&id=".$item[0]."\">".($item['snapshot']?'<img src="image_log.php?id='.$item['id'].'" height="200" align="right">':"")."</a>";
				}
				$out.= nl2br(stripslashes($item['body']));
				$out.= "</td></tr>";
			}
			$out.= "</table>";
			$this->body($out);
		}
	}
	public function contact_name($id) {
		if ($id==NULL) {
			return;
		}
		$query = "SELECT name ".
				" FROM `mag_contact`".
				" WHERE id=".$id;
		$result = $this->query($query);
		if (mysqli_num_rows($result)>0) {
			$item = mysqli_fetch_array($result);
			return ($item[0]==""?"N°".$id:$item[0]);
		}else{
			return "N°".$id;
		}
	}
	public function rack_name($id) {
		if ($id==NULL) {
			return;
		} 
		$query = "SELECT name ".
				" FROM `mag_rack`".
				" WHERE id=".$id;
		$result = $this->query($query);
		if (mysqli_num_rows($result)>0) {
			$item = mysqli_fetch_array($result);
			return ($item[0]==""?"N°".$id:$item[0]);
		}else{
			return "N°".$id;
		} 
	}
	public function class_resa($id) {
		if ($id==NULL) {
			return;
		}
		$query = "SELECT mag_class.name ".
				" FROM mag_resa_item,mag_inventaire,mag_class".
				" WHERE mag_class.planning = 1 and mag_resa_item.item_id = mag_inventaire.id and".
				" mag_inventaire.class_id = mag_class.id and mag_resa_item.resa_id=".$id.
				" GROUP BY mag_class.name";
		$text="";
		$result = $this->query($query);
		if (mysqli_num_rows($result)>0) {
			while ($item = mysqli_fetch_array($result)) {
				$text .= ($item[0]==""?"N°".$id:$item[0])."<br>";
			}
		}else{
			return "";
		}
		return $text;
	}
	public function rackselect($table,$value,$option,$selected,$prefix) {
		if ($table=="concept") {
			$inactivity = " AND active = 1";
		}else{
			$inactivity = "";
		}
		$sql = "select `".$value."`,`".$option."` from `".$table."` where `".$value."` is not null and station_id = ".CONFIG::ID_STATION.$inactivity." order by `".$option."` asc";
		$result = $this->query($sql);
		$out  = '<SELECT NAME="'.$prefix."_".$table."_".$value.'" onchange="this.form.submit()">';
       	$out .= '<OPTION VALUE="-1">N/A</A>';
		while ($item = mysqli_fetch_array($result)) {
			$out .= '<OPTION VALUE="'.$item[$value].'"';
			if (($selected == $item[$value])and($selected != "")) {
				$out .= " SELECTED";
			}
			$out .= '>'.$item[$option].'</OPTION>'."\n";
		}
       	$out .= '</SELECT>';
       	return $out;
	}
}

### VARIABLES GET / POST

$concept = 		(isset($_GET['concept'])?			$_GET['concept']:			'PLANNING');
$list = 		(isset($_GET['list'])?				$_GET['list']:				'ITEM');
$page= 			(isset($_GET['page'])?				$_GET['page']:				"");
$id=			(isset($_POST['id'])?				$_POST['id']:				(isset($_GET['id'])?				$_GET['id']:				0	));
$category_id=	(isset($_POST['category_id'])?		$_POST['category_id']:		(isset($_GET['category_id'])?		$_GET['category_id']:		-1	));
$item_id=		(isset($_POST['item_id'])?			$_POST['item_id']:			(isset($_GET['item_id'])?			$_GET['item_id']:			0	));
$class_id=		(isset($_POST['class_id'])?			$_POST['class_id']:			(isset($_GET['class_id'])?			$_GET['class_id']:			-1	));
$brand_id=		(isset($_POST['brand_id'])?			$_POST['brand_id']:			(isset($_GET['brand_id'])?			$_GET['brand_id']:			0	));
$model_id=		(isset($_POST['model_id'])?			$_POST['model_id']:			(isset($_GET['model_id'])?			$_GET['model_id']:			0	));
$area_id=		(isset($_POST['area_id'])?			$_POST['area_id']:			(isset($_GET['area_id'])?			$_GET['area_id']:			-1	));
$start_rack_id=	(isset($_POST['start_mag_rack_id'])?$_POST['start_mag_rack_id']:(isset($_GET['start_mag_rack_id'])?	$_GET['start_mag_rack_id']:	0	));
$stop_rack_id=	(isset($_POST['stop_mag_rack_id'])?	$_POST['stop_mag_rack_id']:	(isset($_GET['stop_mag_rack_id'])?	$_GET['stop_mag_rack_id']:	0	));
$date_start=	(isset($_POST['only_time_start'])?	date('Y-m-d H:i:s',intval($_POST['only_time_start'])+intval($_POST['only_date_start'])):	"2021-02-02 12:00:00");
$date_stop=		(isset($_POST['only_time_stop'])?	date('Y-m-d H:i:s',intval($_POST['only_time_stop'])+intval($_POST['only_date_stop'])):		"");
$classe 	= 	(isset($_POST['mag_class_id'])?		$_POST['mag_class_id']:	-1);
$slug 		= 	(isset($_POST['slug'])?				$_POST['slug']:			"");
$info 		= 	(isset($_POST['info'])?stripslashes($_POST['info']):		"");
$scanner 	= 	(isset($_POST['scanner'])?			$_POST['scanner']:		"NO");
$order_by 	= 	(isset($_GET['order_by'])?$_GET['order_by']:"mag_class.name");

### SCANNER ACTIONS

if (substr($scanner,0,4)=="USER") {
	$concept="RESAS";
}elseif (substr($scanner,0,4)=="RESA") {
	$id = substr($_POST["scanner"],4);	
	$html->redirect="?concept=RESAS&id=".$id;
}elseif ($scanner=="8001841606958") {
	$concept="FULLSCREEN";
}

### CONSTRUCTION DE LA PAGE

$html = new html($concept,$list);

if ($concept=="RESAS"){ 		#################################################################################	RESAS
	$order_by 	= (isset($_GET['order_by'])?$_GET['order_by']:"mag_resa.date_start");
	if (isset($_POST['new'])) {
		# NOUVELLE RESA = ON LA CREE ET ON RECUPERE UN ID
		$query = 'INSERT INTO `mag_resa` SET '
			."user_id=".$html->uid.","
			."date_start='".$date_start."',"
			."date_stop='".$date_start."'"
			;
		$result =  $html->query($query);
		$query = 'select LAST_INSERT_ID()';
		$result =  $html->query($query);
		$item = mysqli_fetch_array($result);
		$id=$item[0];
	}elseif (isset($_POST['id'])) {
		# UPDATE RESA #######################################################
		$query = 'UPDATE `mag_resa` SET '
			."level=".$_POST['mag_phase_id'].","
            ."user_id=".$html->uid.","
            ."date_start='".$date_start."',"
            ."date_stop='".$date_stop."',"
			."slug='".addslashes($slug)."',"
			."info='".addslashes($info)."',"
			."contact_id=".($_POST['mag_contact_id']>0?$_POST['mag_contact_id']:"NULL").","
			."start_rack_id=".($start_rack_id==-1?"NULL":$start_rack_id).","
			."stop_rack_id=".($stop_rack_id==-1?"NULL":$stop_rack_id)
			." WHERE id=".$id;
        $result =  $html->query($query);
		# REM FROM RESA ####################################################
		if (isset($_POST['rem_from_resa_item'])) {
			$query = 'DELETE FROM mag_resa_item WHERE (resa_id,item_id) IN (';
			$virgule = false;
			foreach ($_POST['rem_from_resa_item'] as &$value) {
				if ($virgule) {
					$query.=",";
				}else{
					$virgule=true;
				}
				$query.= "(".$id.",".$value.")";
			}
			$query.= ")";
			$result =  $html->query($query);
        }
		# ADD TO RESA ######################################################
		if (isset($_POST['add_to_resa_item'])) {
			$query = 'REPLACE INTO mag_resa_item(resa_id,item_id) VALUES ';
			$virgule = false;
			foreach ($_POST['add_to_resa_item'] as &$value) {
    			if ($virgule) {
					$query.=",";
				}else{
					$virgule=true;
				}
				$query.= "(".$id.",".$value.")";
			}
			$result =  $html->query($query);
		}
		# ADD A CLASS ######################################################
		if (isset($_POST['add_to_resa_class'])) {
			$query = 'REPLACE INTO mag_resa_item(resa_id,item_id) ';
			$query.= " SELECT ".$id.",id FROM mag_inventaire WHERE class_id=".$_POST['add_to_resa_class'];
			$result =  $html->query($query);
        }
	}
	
	if ($id>0) {
		#####################################################################
		# LA RESA EXISTE ET NOUS ALLONS LA MODIFIER
		$query = "SELECT id,level,date_start,date_stop,contact_id,user_id,info,slug,start_rack_id,stop_rack_id FROM mag_resa WHERE id=".$id;
		$result =  $html->query($query);
		$item = mysqli_fetch_array($result);
		$level=$item[1];
		if ($html->uid==-1) {
			$html->body.="<span class=\"level1\">Pour modifier une réservation il faut être identifié. Merci.</span>";
		}else{
			#################################################################################
			# FORMULAIRE AVEC DATA                                                          #
			#################################################################################
			$html->body.= "<h1>Sortie</h1>";
			$html->body.= "<table width=\"100%\">";
			$formulaire = '<form enctype="multipart/form-data" method="post">';
			$formulaire .= '<input type="hidden" name="id" value="'.$id.'">';
			# START DATE ####################################################################
			$unixtimestart= intval( strtotime($item[2]) );
			$formulaire.= '<tr><td>Départ&nbsp;:</td><td>';
			$formulaire.= '<SELECT NAME="only_date_start" onchange="this.form.submit()">';
			for ($i = -90; $i <= 90; $i++) {
				$unixtime=mktime(0, 0, 0, date("m"), date("d")+$i, date("Y"));
				$formulaire.= '<OPTION VALUE="'.$unixtime.'" '.
					(
						(
							(
								intval($unixtime)          <= $unixtimestart
							)
							and
							(
								intval($unixtime)+24*60*60 >  $unixtimestart
							)
						) ? " SELECTED":""
					)
					.'>'.
					strftime("%A %e %b %Y", $unixtime).'</OPTION>';
			}
			$formulaire .= '</SELECT>';
			$formulaire .= '</td>';
			# START HEURE ####################################################################
			$formulaire .= '<td>';
			$secondes = intval( substr($item[2],-8,2) )*60*60 + intval( substr($item[2],-5,2) )*60;
			$formulaire.= '<SELECT NAME="only_time_start" onchange="this.form.submit()">';
			for ($i = 0; $i < 48; $i++) {
				$formulaire.= '<OPTION VALUE="'.strval($i*30*60).'" '.($i*60*30==$secondes?" SELECTED":"").'>'.
					date('H:i', mktime(0, 30*$i, 0, 1, 1, 1)
					).'</OPTION>';
			}
			$formulaire .= '</SELECT>';
			$formulaire .= '</td>';
			# RACK ###########################################################################
			$formulaire .= '<td>';			
			$formulaire .= $html->rackselect("mag_rack","id" ,"name",$item[8],"start");
			$formulaire .= '</td></tr>';
			# STOP   DATE ####################################################################
			$formulaire.= "<tr><td>Retour&nbsp;:</td><td>";
			$formulaire.= '<SELECT NAME="only_date_stop" onchange="this.form.submit()">';
			for ($i = -90; $i <= 90; $i++) {
				$unixtime=mktime(0, 0, 0, date("m"), date("d")+$i, date("Y"));
				if ($unixtime+24*60*60>=$unixtimestart) {
					$formulaire.= '<OPTION VALUE="'.$unixtime.'" '.
						(
							(
								(
									intval($unixtime)          <= intval( strtotime($item[3]) )
								)
								and
								(
									intval($unixtime)+24*60*60 >  intval( strtotime($item[3]) )
								)
							) ? " SELECTED":""
						)
						.'>'.
						strftime("%A %e %b %Y", $unixtime).'</OPTION>';
				}
			}
			$formulaire .= '</SELECT>';
			$formulaire .= '</td>';
			# STOP   HEURE ####################################################################
			$formulaire .= '<td>';
			$secondes = intval( substr($item[3],-8,2) )*60*60 + intval( substr($item[3],-5,2) )*60;
			$formulaire.= '<SELECT NAME="only_time_stop" onchange="this.form.submit()">';
			for ($i = 0; $i < 48; $i++) {
				$formulaire.= '<OPTION VALUE="'.strval($i*30*60).'" '.($i*60*30==$secondes?" SELECTED":"").'>'.
					date('H:i', mktime(0, 30*$i, 0, 1, 1, 1)
					).'</OPTION>';
			}
			$formulaire .= '</SELECT>';
			$formulaire .= '</td>';
			# RACK ###########################################################################
			$formulaire .= '<td>';
			$formulaire .= $html->rackselect("mag_rack","id" ,"name",$item[9],"stop");
			$formulaire .= '</td></tr>';
			# TITULAIRE   #####################################################################
			$formulaire.= '<tr><td>Titulaire&nbsp;:</td><td colspan="3">';
			$formulaire.= $html->menuselect("mag_contact","id" ,"name",$item[4]);
			$formulaire.= "</td></tr>";
			# ETAPE ##########################################################################
			$formulaire.= '<tr><td>Étape&nbsp;:</td><td colspan="3" class="level';
			if ($item[1]==0) {
				$formulaire.= "0";
			}elseif ($item[1]==1) {
				$formulaire.= "0";
			}elseif ($item[1]==2) {
				$formulaire.= "1";
			}elseif ($item[1]==3) {
				$formulaire.= "3";
			}elseif ($item[1]==4) {
				$formulaire.= "4";
			}elseif ($item[1]==5) {
				$formulaire.= "2";
			}elseif ($item[1]==6) {
				$formulaire.= "5";
			}
			$formulaire.= "\">";
		#	$formulaire.= $html->menuswitch("mag_phase","id" ,"name",$item[1]);
			$formulaire.='<SELECT NAME="mag_phase_id" onchange="this.form.submit()">';
		#	$formulaire.='<OPTION VALUE="1" >RESET</OPTION>';
			if ($level<=2) {
				$formulaire.='<OPTION VALUE="1" '.($level==1?"SELECTED":"").'>1-Prévisionnelle</OPTION>';
				$formulaire.='<OPTION VALUE="2" '.($level==2?"SELECTED":"").'>2-Confirmée - À préparer</OPTION>';
			}
			if ($level>=2 and $level<=3) {
				$formulaire.='<OPTION VALUE="3" '.($level==3?"SELECTED":"").'>3-Armoire départ</OPTION>';
			}
			if ($level>=3 and $level<=4) {
				$formulaire.='<OPTION VALUE="4" '.($level==4?"SELECTED":"").'>4-En cours</OPTION>';
			}
			if ($level>=4 and $level<=5) {
				$formulaire.='<OPTION VALUE="5" '.($level==5?"SELECTED":"").'>5-Armoire retour</OPTION>';
			}
			if ($level>=6 and $level<=6) {
				$formulaire.='<OPTION VALUE="6" '.($level==6?"SELECTED":"").'>6-Vérifiée</OPTION></SELECT>';
			}
			$formulaire.= "</td></tr>";
			# TOURNAGE #######################################################################
			$formulaire.= '<tr><td>Tournage&nbsp;:</td><td colspan="3">';
			$formulaire.= '<input SIZE="80" TYPE="text" NAME="slug" VALUE="'.$item[7].'" ></td>';
			$formulaire.= "</tr>";
			# INFO        #####################################################################
			$formulaire.= '<tr height="120"><td>Info&nbsp;:<p><!--input class="bouton_in" type="submit" /--></td><td colspan="3">';
			$formulaire.= '<textarea rows = "8" cols = "74" name = "info">'.$item[6].'</textarea><br>'
				.'<input type="submit" class="bouton_in" value="Envoyer">';
			$formulaire.= "</td></tr>";
			# CLASSE      #####################################################################
			$formulaire.= "</table><h1>Mat&eacute;riel</h1>";
		
			
			############## SCANNER IN OUT
			
			if (isset($_POST['scanner'])) {
				if ($_POST['scanner']=="ADD") {
					if ($html->uid>0 and $level<=3) {
						$html->redirect="?concept=RESAS&list=ADD&id=".$id;
					}else{
						$html->redirect="?concept=RESAS&id=".$id;
					}
				}elseif ($_POST['scanner']=="REMOVE") {
					if ($html->uid>0 and $level<=3) {
						$html->redirect="?concept=RESAS&list=REMOVE&id=".$id;
					}else{
						$html->redirect="?concept=RESAS&id=".$id;
					}
				}elseif ($_POST['scanner']=="CANCEL"){
					$html->redirect="?concept=RESAS&id=".$id;
				}elseif ($_POST['scanner']=="CLOSE") {
					$query="UPDATE mag_resa SET level=6 WHERE id=".$id;
					$result =  $html->query($query);
					$html->redirect="?concept=RESAS&id=".$id;
				}else{
					if ($list=="LEARN") {
						if (intval($_POST['scanner'])) {
							$query_bar = "UPDATE mag_inventaire SET mag_inventaire.barcode='".$_POST['scanner']."' WHERE mag_inventaire.id=".$id;
							$result_bar =  $html->query($query_bar);
							$query_log = "INSERT INTO `mag_item_log` SET "
								."active=1, "
								."item_id="                     .$id.", "
								."level=2, "
								."initials='".($html->uid>0?$html->initials($html->uid):$initials). "', "
								."uid='".$html->uid. "', "
								."ip='".$html->terminal. "', "
								."station_id='".CONFIG::ID_STATION. "', "
								."body='". addslashes("Nouveau code-barre : ".$_POST['scanner'])."'" ;
							$result_log =  $html->query($query_log);
							$html->redirect="?concept=INVENTAIRE&list=ITEM&item_id=".$id;
						}elseif ($_POST['scanner'] == "NULL"){
							$query_bar = "UPDATE mag_inventaire SET mag_inventaire.barcode=NULL WHERE mag_inventaire.id=".$id;
							$result_bar =  $html->query($query_bar);
							$query_log = "INSERT INTO `mag_item_log` SET "
								."active=1, "
								."item_id="                     .$id.", "
								."level=2, "
								."initials='".($html->uid>0?$html->initials($html->uid):$initials). "', "
								."uid='".$html->uid. "', "
								."ip='".$html->terminal. "', "
								."station_id='".CONFIG::ID_STATION. "', "
								."body='". addslashes("Effacement du code-barre")."'" ;
							$result_log =  $html->query($query_log);
							$html->redirect="?concept=INVENTAIRE&list=ITEM&item_id=".$id;
						}
					}elseif ($list=="ADD") {
						$query_bar = "SELECT id FROM mag_inventaire WHERE barcode ='".$_POST['scanner']."'";
						$result_bar =  $html->query($query_bar);
						if (mysqli_num_rows($result_bar)!=0) {
							$item_bar = mysqli_fetch_array($result_bar);
							$query = 'SELECT * FROM mag_resa_item WHERE resa_id='.$id." and item_id=".$item_bar[0];
							$result =  $html->query($query);
							if (mysqli_num_rows($result)>0){
								$html->info="Appareil déjà scanné";
							}
							$query = 'REPLACE INTO mag_resa_item(resa_id,item_id) VALUES '."(".$id.",".$item_bar[0].")";
							$result =  $html->query($query);
						}else{
							$html->info = "Objet absent de la base";
						}
					}elseif ($list=="REMOVE") {
						$query_bar = "SELECT id FROM mag_inventaire WHERE barcode ='".$_POST['scanner']."'";
						$result_bar =  $html->query($query_bar);
						if (mysqli_num_rows($result_bar)!=0) {
							$item_bar = mysqli_fetch_array($result_bar);
							$query = 'DELETE FROM mag_resa_item WHERE resa_id = '.$id.' AND item_id = '.$item_bar[0];
							$result =  $html->query($query);
						}else{
							$html->info = "Objet absent de la base";
						}
					}elseif ($level ==5){
						$query_bar = "SELECT id FROM mag_inventaire WHERE barcode ='".$_POST['scanner']."'";
						$result_bar =  $html->query($query_bar);
						if (mysqli_num_rows($result_bar)!=0) {
							$item_bar = mysqli_fetch_array($result_bar);
							$query = "UPDATE mag_resa_item SET verified=1 WHERE item_id=".$item_bar[0]." and resa_id=".$id;
							$result =  $html->query($query);
							# MAINTENANT QU ON A CHECKE ON REGARDE COMBIEN IL EN RESTE
							$query = "SELECT count(*) FROM mag_resa_item WHERE resa_id=".$id." and verified=0";
							$result =  $html->query($query);
							$item_count = mysqli_fetch_array($result);
							if ($item_count[0]==0) {
								$query="UPDATE mag_resa SET level=6 WHERE id=".$id;
								$result =  $html->query($query);
								$html->redirect="?concept=RESAS&id=".$id;
							}
						}else{
							$html->info = "Objet absent de la base";
						}
					}
				}
			}
			if ($list<>"ADD" and $list<>"REMOVE") {
				# $formulaire.= $html->menuselect("mag_class","id" ,"name",$classe);
				# LISTE DU MATERIEL DE LA CLASSE DISPONIBLE
				if ($classe > 0) {				
					$sql = 'SELECT  a.id,
						`mag_brand`.`name`,
						`mag_model`.`reference`,
						`mag_model`.`description`,
						a.`tag`,
						a.`serial`,
						a.`refMoscou`,
						a.`model_id`
						FROM `mag_inventaire` AS a,`mag_model`,`mag_brand` ';
					$sql.= 'WHERE `mag_model`.`id`=a.`model_id` and
						`mag_brand`.`id`=`mag_model`.`brand_id` and ';
					$sql.= 'NOT EXISTS (SELECT * from mag_resa_item AS b WHERE a.id = b.item_id and b.resa_id = '.$id.') AND ';
					$sql.= 	' a.status_id = 0 AND '.
						' a.class_id = '.$classe;
					$sql.= " ORDER BY mag_brand.name,mag_model.reference";
					$result = $html->query($sql);
					if (mysqli_num_rows($result)!=0) {
						$formulaire.= "<h2>Disponible</h2>";
						$formulaire.=	'<input type="checkbox" name="add_to_resa_class" value='.$classe.
							' onchange="this.form.submit()">Ajouter toute la classe.<p>';
						# Headers
						$formulaire.='<table><tr><th></th>
							<th>Marque</th>
							<th>Modèle</th>
							<th>Description</th>
							<th>Etiquette</th>
							<th>N° Série</th>
							<th>Ref. Moscou</th>
							</tr>';
						while ($item = mysqli_fetch_array($result)) {
							$formulaire .= '<tr class="tr_hover">'
								.'<td><input type="checkbox" name="add_to_resa_item[]" value='.$item[0].'></td>'
								.'<td>'.$item[1].'</td>'
								.'<td>'.$item[2].'</td>'
								.'<td>'.$item[3].'</td>'
								.'<td><a href="mag_item.php?id='.$item[0].'">'.$item[4].'</a></td>'
								.'<td><a href="mag_item.php?id='.$item[0].'">'.$item[5].'</a></td>'
								.'<td><a href="mag_item.php?id='.$item[0].'">'.($item[6]==0?"":($item[6]==-1?"NC":$item[6])).'</a></td>'
								.'</tr>'."\n";
						}
						$formulaire.= "</table>";
						$formulaire.= '<input type="submit" value="Ajouter &agrave; la liste"  class="bouton_in" >';
					}else{
						$formulaire.= " Cettre classe ne contient pas d'objet disponible.";
					}
				}	
			}

			# INDICATION DU BARCODE

			if ($list=="ADD") {
				$formulaire.= '<img src="https://webviewersolutions.com/images/barcodescanning.gif"><span class="bouton_in">SCANNEZ POUR AJOUTER</span>';
			}elseif ($list=="REMOVE") {
				$formulaire.= '<img src="https://webviewersolutions.com/images/barcodescanning.gif"><span class="bouton_out">SCANNEZ POUR RETIRER</span>';
			}elseif ($level==5) {
				$formulaire.= '<img src="https://webviewersolutions.com/images/barcodescanning.gif"><span class="bouton_in">SCANNEZ POUR VERIFIER</span>';
			}
			
			
			# PANIER #########################################################
			$sql = 'SELECT  a.id,
					`mag_brand`.`name`,
					`mag_model`.`reference`,
					`mag_model`.`description`,
					a.`tag`,
					a.`serial`,
					a.`refMoscou`,
					a.`model_id`,
					mag_class.name,
					a.barcode,
					mag_resa_item.verified
					FROM `mag_inventaire` AS a,`mag_model`,`mag_brand`,mag_resa_item,mag_class ';
			$sql.= 'WHERE `mag_model`.`id`=a.`model_id` and
					`mag_brand`.`id`=`mag_model`.`brand_id` and mag_class.id = a.class_id and ';

			#        $sql.= 'NOT EXISTS (SELECT * from mag_resa_item AS b WHERE a.id = b.item_id and b.resa_id = '.$id.') AND ';
			$sql.=  ' a.id = mag_resa_item.item_id AND mag_resa_item.resa_id='.$id;
			$sql.= " ORDER BY mag_resa_item.timestamp DESC,mag_brand.name,mag_model.reference";
			$result = $html->query($sql);
			if (mysqli_num_rows($result)!=0) {
				#	$formulaire.= "<h2>Attribué</h2>";
				 #	$formulaire.= '<input type="submit" value="Retirer de la liste"  class="bouton_out" >';
					$formulaire.=   '<p><table>';
					# Headers
					$formulaire.='<tr><!--th></th-->
							<th>Marque</th>
							<th>Modèle</th>
							<th>Description</th>
							<th>Etiquette</th>
							<th>N° Série</th>
							<th>Ref. Moscou</th>
							<th>Classe</th>
							<th>Code barre</th>';
					if ($level>=5) {
						$formulaire.='<th>Vérifié</th>';
					}
					$formulaire.='</tr>';
					while ($item = mysqli_fetch_array($result)) {
						$formulaire .= '<tr class="tr_hover" onclick="window.location.href = \'?concept=INVENTAIRE&item_id='.$item[0].'\'">'
									.'<!--td><input type="checkbox" name="rem_from_resa_item[]" value='.$item[0].'></td-->'
									.'<td>'.$item[1].'</td>'
									.'<td>'.$item[2].'</td>'
									.'<td>'.$item[3].'</td>'
									.'<td><a href="?concept=INVENTAIRE&item_id='.$item[0].'">'.$item[4].'</a></td>'
									.'<td><a href="?concept=INVENTAIRE&item_id='.$item[0].'">'.$item[5].'</a></td>'
									.'<td><a href="?concept=INVENTAIRE&item_id='.$item[0].'">'.($item[6]==0?"":($item[6]==-1?"NC":$item[6])).'</a></td>'
									.'<td>'.$item[8].'</td>'
									.'<td>'.$item[9].'</td>'
									.($level>=5?'<td><input type="checkbox" name="verified" value='.$item[0].' '.($item[10]==1?"CHECKED":"").'></td>':"")
									.'</tr>'."\n";
					}
					$formulaire.= "</table>";
					if ($level>=3) {
						$formulaire.= '<table class="menubar"><tr height="50"><th><a class="menubut" href="?concept=RESA_OUT&list=print&id='.$id.'">Fiche de sortie</a></th>';
						$formulaire.= '<th><a class="menubut" href="?concept=RESA_OUT&list=ATA&id='.$id.'">Carnet ATA</a></th></tr></table>';
					}
			}else{
				if ($list<>"ADD") {
					$html->redirect="?concept=RESAS&list=ADD&id=".$id;
				}
			}
			
			
			# FIN DU FORMULAIRE ##############################################

			$formulaire .= '</form>';
			$html->body.= $formulaire;
		}
		$html->body.= "";
	} else {
		$out="<h1>R&eacute;servations</h1>";
		#### LISTE DES RESERVATIONS ##################################################################
		$out.="<table>";
		# Headers
		$out.='	<th colspan="2"><a href="?concept=RESAS&'.($page<>""?"page=".$page."&":"").'order_by=mag_resa.date_start">D&eacute;part</a></th>
			<th colspan="2"><a href="?concept=RESAS&'.($page<>""?"page=".$page."&":"").'order_by=mag_resa.date_stop">Arrivée</a></th>
			<th>Classe</th>
			<th>Titulaire</th>
			<th><a href="?concept=RESAS&'.($page<>""?"page=".$page."&":"").'order_by=mag_resa.slug">Tournage</a></th>
			<th><a href="?concept=RESAS&'.($page<>""?"page=".$page."&":"").'order_by=mag_resa.level">&Eacute;tape</a></th>
			</tr><tr>';
		# Selections
		$sql = 'SELECT 	`mag_resa`.`id`,
			`mag_resa`.`slug`,
			`mag_resa`.`date_start`,
			`mag_resa`.`date_stop`,
			`mag_phase`.`name`,
			`mag_resa`.`level`,
			`mag_phase`.`name`,
			`mag_resa`.`start_rack_id`,
			`mag_resa`.`stop_rack_id`,
			`mag_resa`.`contact_id`
			FROM mag_resa,mag_phase ';
		$sql.= ' WHERE mag_resa.level = mag_phase.id and mag_resa.level<>6 ';
		# CLAUSE ORDER BY
		if ($order_by == "mag_resa.date_start" or $order_by == "") {
			$sql.= " ORDER BY mag_resa.date_start ASC,mag_resa.date_stop ASC";
		}elseif ($order_by == "mag_resa.date_stop") {
			$sql.= " ORDER BY mag_resa.date_stop";
		}elseif ($order_by == "mag_resa.slug") {
			$sql.= " ORDER BY mag_resa.slug";
		}elseif ($order_by == "mag_resa.level") {
			$sql.= " ORDER BY mag_resa.level DESC";
		}
		$result =  $html->query($sql);
		while ($item = mysqli_fetch_array($result)) {
			$out .= '<tr class="tr_'.($id==$item[0]?"selected":"hover").'" onclick="window.location.href = \'?concept=RESAS&id='.$item[0].'\'">'
			.'<td>'.$item[2].'</td>'
			.'<td>'.$html->rack_name($item[7]).'</td>'
			.'<td>'.$item[3].'</td>'
			.'<td>'.$html->rack_name($item[8]).'</td>'
			.'<td>'.$html->class_resa($item[0]).'</td>'
			.'<td>'.$html->contact_name($item[9]).'</td>'
			.'<td>'.$item[1].'</td>'
			.'<td  class="level';
			if ($item[5]==0) {
				$out.= "0";
			}elseif ($item[5]==1) {
				$out.= "0";
			}elseif ($item[5]==2) {
				$out.= "1";
			}elseif ($item[5]==3) {
				$out.= "3";
			}elseif ($item[5]==4) {
				$out.= "4";
			}elseif ($item[5]==5) {
				$out.= "2";
			}elseif ($item[5]==6) {
				$out.= "5";
			}
			$out.= "\">";
			$out.=$item[6].'</td>'
				.'</tr>'."\n";
		}
		$out.='</table>';
		$html->body($out);
		# LA RESA N'EXISTE PAS DONC ON PREPARE UN FORMULAIRE
		$html->body.= "<table width=\"100%\">";
		if ($html->uid==-1) {
			$html->body.="<tr><td class=\"level1\">Pour créer une réservation il faut être identifié. Merci.</td></tr>";
		}else{
			$html->body.= "<h1>Nouvelle réservation</h1>";
			$formulaire = '<form enctype="multipart/form-data" method="post">';

			# NEW
			$formulaire .= '<input type="hidden" name="new" value="new">';

			# DATE ET HEURE START ##################################################################
			$formulaire.= "<tr><td>Départ&nbsp;:</td><td>";
			$formulaire.= '<SELECT NAME="only_date_start" onchange="this.form.submit()">';

			for ($i = 0; $i <= 90; $i++) {
				$formulaire.= '<OPTION VALUE="'.
					mktime(0, 0, 0, date("m"), date("d")+$i, date("Y")).
						'" '.($i==0?" SELECTED":"").'>'.
					strftime("%A %e %b %Y", mktime(0, 0, 0, date("m"), date("d")+$i, date("Y"))).'</OPTION>';
			}
            $formulaire .= '</SELECT>';
            $formulaire.= '<SELECT NAME="only_time_start" onchange="this.form.submit()">';
            for ($i = 0; $i <= 48; $i++) {
                $formulaire.= '<OPTION VALUE="'.strval($i*30*60).'" '.($i==13?" SELECTED":"").'>'.
                    date('H:i',mktime(0, 30*$i, 0, 1, 1, 1)).
					'</OPTION>';
            }
            $formulaire .= '</SELECT>';
			$formulaire .= '</form>';
			$formulaire .= '</td></tr>';
			$html->body.= $formulaire;
		}

		$html->body.= "</table>";
	}
	$html->out();
}elseif ($concept=="PLANNING"){ #################################################################################	PLANNING
	$html->head.= "<meta HTTP-EQUIV=\"Refresh\" CONTENT=\"30\">\n";
	$week = substr("0".(isset($_GET['week'])?$_GET['week']:date('W')),-2);
	$year = (isset($_GET['year'])?$_GET['year']:date('Y'));
	$n = ((isset($_GET['n'])?$_GET['n']:1)-1);
	$date1 = date( "Y-m-d 00:00:00", strtotime($year."W".$week."1") ); // First day of week
	$date2 = date( "Y-m-d 23:59:59", strtotime($year."W".$week."7+".$n."week") ); // Last day of week
	if ($page=="print"){
		$y=7;
		$n=1;
	}else{
		$y=14;
		$n=0;
	};
	$table = "<table>";

	# NAVIGATION
	$table.= '<tr>';
	$table.= '<td colspan=2 class=arrow       ><a href="?n='.($n+1).($page<>""?'&page='.$page:"").'&year='.
		date("Y",strtotime($year."W".$week."7-".($n+1)."week")).'&week='.
		date("W",strtotime($year."W".$week."7-".($n+1)."week")).
		'">&larr;</a></td>';
	$table.= '<td colspan='.($y-3).' class="td_center" ><a href="?n='.($n+1).($page==""?'&page=compact':"").($page=="compact"?'&page=print':"").'&year='.
		$year.'&week='.
		$week.
		'">'.date("Y",strtotime($year."W".$week)).'</a></td>';
	$table.= '<td colspan=2 class=arrow_droite><a href="?n='.($n+1).($page<>""?'&page='.$page:"").'&year='.
		date("Y",strtotime($year."W".$week."7+".($n+1)."week")).'&week='.
	    date("W",strtotime($year."W".$week."7+".($n+1)."week")).
	    '">&rarr;</a></td>';
	$table.= '</tr>';
	
	# JOURS DE LA SEMAINE
	$table.='<tr><td width="'.(100/($y+1)).'%"></td>';	
	for ($i = 0; $i <$y ; $i++) {
		$table.= '<td width="'.(100/($y+1)).'%"';
		$table.= ">".strftime("%A", ($i+4)*24*3600);
		$table.= "</td>";
	}
	$table.="</tr>";
	
	for ($i = 0; $i <= $n; $i++) {
		if ($page=="compact" or $page=="print") {
			# CLASSES DE LA SEMAINE
			$unixdate=strtotime($year."W".$week."+".$i."week");
			$query = "SELECT mag_inventaire.class_id, mag_class.name".
				" FROM mag_resa, mag_resa_item, mag_inventaire, mag_class WHERE not(unix_timestamp(date_start)-(86400*7) > ".$unixdate.
				" AND unix_timestamp(date_stop)-(86400*7) > ".$unixdate.")".
				" AND not(unix_timestamp(date_start) < ".$unixdate.
				" AND unix_timestamp(date_stop) < ".$unixdate.")".
				" AND mag_resa.id = mag_resa_item.resa_id".
				" AND mag_inventaire.id = mag_resa_item.item_id".
				" AND mag_class.id = mag_inventaire.class_id".
				" AND mag_class.planning >=1 ".
				" GROUP by mag_inventaire.class_id".
				" ORDER by mag_class.planning,mag_class.name";
		}else{
			# TOUTES LES CLASSES PLANNING
			$query = "SELECT id, mag_class.name FROM mag_class WHERE mag_class.planning >= 1".
				" GROUP by id".
				" ORDER by mag_class.planning,mag_class.name";
		}
		$result_class =  $html->query($query);
		# BARRE DE DATES DE LA SEMAINE
		$table.='<tr class="tr_date">';
		$table.="<th>SEMAINE&nbsp;".date("W",strtotime($year."W".$week."7+".$i."week"))."</th>";
		for ($j = 0;$j < $y;$j++) {
			$unixdate=strtotime($year."W".$week."+".(($i*7)+$j)."day");
			$table.="<th";
			if (date("d M")==date( "d M", $unixdate) ) {
				$table .= ' class="tr_selected"';
			}
			$table.= ">";
			$table.= strftime("%e %b", $unixdate);
			$table.= "</th>";
		}
		$table.="</tr>";
		# UNE LIGNE PAR CLASSE
		if (mysqli_num_rows($result_class)!=0) {
			while ($item_class = mysqli_fetch_array($result_class)) {
				$table.='<tr class="tr_planning">';
				# AFFICAGE DE LA CLASSE
				$table.= '<td class="td_center">'.$item_class[1]."</td>";
				# JOURS PAR CLASSE
				for ($j = 0;$j < $y;$j++) {
					$unixdate=strtotime($year."W".$week."+".(($i*7)+$j)."day");
					$query = "SELECT 	mag_resa.id,
						mag_resa.slug,
						mag_resa.date_start,
						mag_resa.date_stop,
						mag_resa.level,
						mag_resa.contact_id".
						" FROM mag_resa, mag_resa_item, mag_inventaire, mag_class".
						" WHERE mag_inventaire.class_id = ".$item_class[0].
						" AND mag_resa.id = mag_resa_item.resa_id AND mag_inventaire.id = mag_resa_item.item_id ".
						" AND not(unix_timestamp(mag_resa.date_start)-86400 >= ".$unixdate.
						" AND unix_timestamp(mag_resa.date_stop)-86400 > ".$unixdate.")".
						" AND not(unix_timestamp(mag_resa.date_start) <= ".$unixdate.
						" AND unix_timestamp(mag_resa.date_stop) < ".$unixdate.")".
						" GROUP by mag_resa.id".
						" ORDER by mag_inventaire.class_id DESC,date_start,level";
					$result =  $html->query($query);
					$table.='<td class="td_planning_cell">';
					if (mysqli_num_rows($result)!=0) {
						while ($item = mysqli_fetch_array($result)) {
							if ($item[5]>0) {
								$query_name = "SELECT mag_contact.name FROM mag_contact WHERE mag_contact.id=".$item[5];
								$result_name = $html->query($query_name);
								if (mysqli_num_rows($result_name)!=0) {
									$item_name = mysqli_fetch_array($result_name);
									$titulaire=$item_name[0];
								}
							}else{
								$titulaire="";
							}
							if (date( "d M",strtotime($item[2]))==date( "d M",$unixdate)) {
								$time = date( "H:i",strtotime($item[2]))." &rarr;";
							}else{
								$time="";
							}
							$time.="";
							if (date( "d M",strtotime($item[3]))==date( "d M",$unixdate)) {
								if (date( "d M",strtotime($item[2]))!=date( "d M",$unixdate)) {
									$time.= "&rarr;";
								}
								$time.=" ".date( "H:i",strtotime($item[3]));
							}else{
								$time.= "";
							}
							if ($time!= "") {
							$time.= "<br>";
							}
							$table.="<table><tr class=\"tr_planning\"><td class=\"etape_planning".$item[4]."\" onclick=\"window.location.href = '".
								($html->uid==-1?"?concept=RESA_OUT&list=print&id=".$item[0]:"?concept=RESAS&id=".$item[0]."&n=".($n+1)."&year=".$year."&week=".$week).
								"'\">";

							$table.= "<!--a href=\"?concept=RESAS&id=".$item[0]."&n=".($n+1)."&year=".$year."&week=".$week."\"--><p>";
							$table.= $time;
							$table.= stripslashes(($titulaire!=""?"<b>".$titulaire."</b><br>":""));
							$table.= stripslashes(($item[1]!=""?$item[1]:""));
							$table.= "<!--/a-->";
							$table.="</td></tr></table>";;
						}
					}
					$table.="</td>";
				}
				$table.="</tr>";
			}
		}else{
			$table.="<tr><td colspan=8></td></tr>";
		}
	}
	$table.= "</table>";
	$html->body($table);
	$html->out();
}elseif ($concept=="INVENTAIRE"){ ###############################################################################	INVENTAIRE
	# SCANNER GENERAL #
	if (($list<>"LEARN")and(isset($_POST['scanner']))) {
		if ($_POST['scanner']=="NULL") {
			$html->redirect="?concept=INVENTAIRE&list=NULL";
		}else{
			$query = "SELECT id FROM mag_inventaire WHERE barcode = '".$_POST['scanner']."'";
			$result_bar=  $html->query($query);
			if (mysqli_num_rows($result_bar)!=0) {
				$item_bar = mysqli_fetch_array($result_bar);
				$html->redirect="?concept=INVENTAIRE&list=ITEM&item_id=".$item_bar[0];
			}else{
				$html->info="Article inconnu";
			}
		}
	}
	if ($item_id>0){
		$id = $item_id;
		# INSCRIPTION EN BASE DES NOUVELLES DONNEES POSTEES PAR FORMULAIRE
		# CLASSE
		if (isset($_POST['mag_class_id'])) {
			$query_was = "SELECT mag_class.id, mag_class.name FROM mag_class,mag_inventaire WHERE mag_inventaire.class_id = mag_class.id AND"
				." mag_inventaire.id = ".$id;
			$result_was =  $html->query($query_was);
			if (mysqli_num_rows($result_was)!=0) {
				$item_was = mysqli_fetch_array($result_was);
				$query_set = "UPDATE mag_inventaire SET mag_inventaire.class_id=".$_POST['mag_class_id']." WHERE mag_inventaire.id=".$id;
				$result_set =  $html->query($query_set);
			}
		}
		# AREA
		if (isset($_POST['mag_area_id'])) {
			$query_was = "SELECT mag_area.id, mag_area.name FROM mag_area,mag_inventaire WHERE mag_inventaire.area_id = mag_area.id AND"
				." mag_inventaire.id = ".$id;
			$result_was =  $html->query($query_was);
			if (mysqli_num_rows($result_was)!=0) {
				$item_was = mysqli_fetch_array($result_was);
				$query_set = "UPDATE mag_inventaire SET mag_inventaire.area_id=".$_POST['mag_area_id']." WHERE mag_inventaire.id=".$id;
				$result_set =  $html->query($query_set);
			}
		}
		# STATUS
		if (isset($_POST['mag_status_id'])) {
			$query_was = "SELECT mag_status.id, mag_status.name FROM mag_status,mag_inventaire WHERE mag_inventaire.status_id = mag_status.id AND"
				." mag_inventaire.id = ".$id;
			$result_was =  $html->query($query_was);
			if (mysqli_num_rows($result_was)!=0) {
				$item_was = mysqli_fetch_array($result_was);
				$query_set = "UPDATE mag_inventaire SET mag_inventaire.status_id=".$_POST['mag_status_id']." WHERE mag_inventaire.id=".$id;
				$result_set =  $html->query($query_set);
			}
		}
		# INFO
		if (isset($_POST['info'])) {
			$query_was = "SELECT info FROM mag_inventaire WHERE"
				." mag_inventaire.id = ".$id;
			$result_was =  $html->query($query_was);
			if (mysqli_num_rows($result_was)!=0) {
				$item_was = mysqli_fetch_array($result_was);
				$query_set = "UPDATE mag_inventaire SET mag_inventaire.info='".addslashes($_POST['info'])."' WHERE mag_inventaire.id=".$id;
				$result_set =  $html->query($query_set);
			}
		}
		# TAG
		if (isset($_POST['tag'])) {
			$query_was = "SELECT tag FROM mag_inventaire WHERE"
				." mag_inventaire.id = ".$id;
			$result_was =  $html->query($query_was);
			if (mysqli_num_rows($result_was)!=0) {
				$item_was = mysqli_fetch_array($result_was);
				$query_set = "UPDATE mag_inventaire SET mag_inventaire.tag='".addslashes($_POST['tag'])."' WHERE mag_inventaire.id=".$id;
				$result_set =  $html->query($query_set);
			}
		}
		# SCANNER EN CONCEPT INVENTAIRE ###########################################################
		if (isset($_POST['scanner'])) {
			if (($_POST['scanner']=="LEARN") and $html->uid>0 ) {
				$html->redirect="?concept=INVENTAIRE&list=LEARN&item_id=".$id;
			}elseif ($_POST['scanner']=="CANCEL"){
				$html->redirect="?concept=INVENTAIRE&list=ITEM&item_id=".$id;
			}else{
				# LIST LEARN #######################
				if ($list=="LEARN") {
					if (intval($_POST['scanner'])) {
						$query_bar = "UPDATE mag_inventaire SET mag_inventaire.barcode='".$_POST['scanner']."' WHERE mag_inventaire.id=".$id;
						$result_bar =  $html->query($query_bar);
						$query_log = "INSERT INTO `mag_item_log` SET "
							."active=1, "
							."item_id="                     .$id.", "
							."level=2, "
							."initials='".($html->uid>0?$html->initials($html->uid):$initials). "', "
							."uid='".$html->uid. "', "
							."ip='".$html->terminal. "', "
							."station_id='".CONFIG::ID_STATION. "', "
							."body='". addslashes("Nouveau code-barre : ".$_POST['scanner'])."'" ;
						$result_log =  $html->query($query_log);
						$html->redirect="?concept=INVENTAIRE&list=ITEM&item_id=".$id;
					}elseif ($_POST['scanner'] == "NULL"){
						$query_bar = "UPDATE mag_inventaire SET mag_inventaire.barcode=NULL WHERE mag_inventaire.id=".$id;
						$result_bar =  $html->query($query_bar);
						$query_log = "INSERT INTO `mag_item_log` SET "
							."active=1, "
							."item_id="                     .$id.", "
							."level=2, "
							."initials='".($html->uid>0?$html->initials($html->uid):$initials). "', "
							."uid='".$html->uid. "', "
							."ip='".$html->terminal. "', "
							."station_id='".CONFIG::ID_STATION. "', "
							."body='". addslashes("Effacement du code-barre")."'" ;
						$result_log =  $html->query($query_log);
						$html->redirect="?concept=INVENTAIRE&list=ITEM&item_id=".$id;
					}
				}
			}
		}
		$query = "SELECT mag_area.name, mag_brand.name, mag_class.name, mag_class.info,"
			." mag_inventaire.tag, mag_inventaire.serial, mag_inventaire.refMoscou,"
			." mag_inventaire.info, mag_inventaire.verif, mag_model.reference,"
			." mag_model.description, mag_model.info, mag_model.hyperlien,"
			." mag_model.prix, mag_model.poids, mag_model.origine,"
			." mag_status.id, mag_status.name, mag_inventaire.model_id,"
			." mag_model.brand_id, mag_inventaire.class_id, mag_area.id,"
			." mag_category.name, mag_inventaire.barcode, mag_model.category_id "
			." FROM mag_area,mag_brand,mag_class,mag_inventaire,mag_model,mag_status,mag_category"
			." WHERE mag_category.id = mag_model.category_id AND mag_area.id = mag_inventaire.area_id AND mag_brand.id = mag_model.brand_id AND"
			." mag_model.id = mag_inventaire.model_id AND mag_status.id = mag_inventaire.status_id AND mag_inventaire.class_id = mag_class.id AND"
			." mag_inventaire.id = ".$id;
		$result = $html->query($query);
		if (mysqli_num_rows($result)!=0) {
			$item = mysqli_fetch_array($result);
			# MAJ AREA
			if (isset($_POST['mag_area_id']) and isset($item_was[1])) {
				$query_log = "INSERT INTO `mag_item_log` SET "
					."active=1, "
					."item_id="                     .$id.", "
					."level=2, "
					."initials='".($html->uid>0?$html->initials($html->uid):$initials). "', "
					."uid='".$html->uid. "', "
					."ip='".$html->terminal. "', "
					."station_id='".CONFIG::ID_STATION. "', "
					."body='". addslashes("Aire : ".$item_was[1]." -> ".$item[0])."'" ;
				$result_log =  $html->query($query_log);
			}
			# MAJ CLASSE
			if (isset($_POST['mag_class_id']) and isset($item_was[1])) {
				$query_log = "INSERT INTO `mag_item_log` SET "
					."active=1, "
					."item_id="                     .$id.", "
					."level=2, "
					."initials='".($html->uid>0?$html->initials($html->uid):$initials). "', "
					."uid='".$html->uid. "', "
					."ip='".$html->terminal. "', "
					."station_id='".CONFIG::ID_STATION. "', "
					."body='". addslashes("Classe : ".$item_was[1]." -> ".$item[2])."'" ;
				$result_log =  $html->query($query_log);
			}
			# MAJ INFO
			if (isset($_POST['info']) and isset($item_was[0])) {
				$query_log = "INSERT INTO `mag_item_log` SET "
					."active=1, "
					."item_id="                     .$id.", "
					."level=2, "
					."initials='".($html->uid>0?$html->initials($html->uid):$initials). "', "
					."uid='".$html->uid. "', "
					."ip='".$html->terminal. "', "
					."station_id='".CONFIG::ID_STATION. "', "
					."body='". addslashes("Info : ".$item_was[0]." -> ".$item[7])."'" ;
				$result_log =  $html->query($query_log);
			}
			# MAJ TAG
			if (isset($_POST['tag']) and isset($item_was[0])) {
				$query_log = "INSERT INTO `mag_item_log` SET "
					."active=1, "
					."item_id="                     .$id.", "
					."level=2, "
					."initials='".($html->uid>0?$html->initials($html->uid):$initials). "', "
					."uid='".$html->uid. "', "
					."ip='".$html->terminal. "', "
					."station_id='".CONFIG::ID_STATION. "', "
					."body='". addslashes("Etiquette : ".$item_was[0]." -> ".$item[4])."'" ;
				$result_log =  $html->query($query_log);
			}
			# INVENTAIRE ITEM
			$html->body.= "<h1>Item</h1>";
			# DEBUT DE TABLE
			$html->body.= "<table width=\"100%\">";
			# MARQUE
			$html->body.= '<tr><td>Marque&nbsp;:</td><td><a href="?concept=INVENTAIRE&list=MODEL&brand_id='.$item['brand_id'].'">'.$item[1].'</a></td></tr>';
			# MODELE
			$html->body.= '<tr><td>Modèle&nbsp;:</td><td><a href="?concept=INVENTAIRE&list=ITEM&model_id='.$item['model_id'].'">'.$item[9].'</a></td></tr>';

			# CATEGORY
			if ($item[22]!="") {
				$html->body.= '<tr><td>Cat&eacute;gorie&nbsp;:</td><td><a href="?concept=INVENTAIRE&list=ITEM&category_id='.$item['category_id'].'">'.$item[22].'</a></td></tr>';
			}
			
			# DESCRIPTION
			$html->body.= '<tr><td>Description&nbsp;:</td><td>'.	$item[10].'</td></tr>';

			# SPECIFICATION
			if ($item[11]<>NULL) {
				$html->body.= '<tr><td>Spécifications&nbsp;:</td><td>'.	$item[11].'</td></tr>';
			}
			# SITE WEB
			if ($item[12]<>NULL) {
				$html->body.= '<tr><td>Site web&nbsp;:</td><td><a href="'.$item[12].'" target="_blank">'.	$item[12].'</a></td></tr>';
			}
			# PRIX
			if ($item[13]<>NULL) {
				$html->body.= '<tr><td>Prix&nbsp;:</td><td>'.		$item[13].'</td></tr>';
			}
			# POIDS
			if ($item[14]<>NULL) {
				$html->body.= '<tr><td>Poids&nbsp;:</td><td>'.		$item[14].'</td></tr>';
			}
			# ORIGINE
			if ($item[15]<>NULL) {
				$html->body.= '<tr><td>Origine&nbsp;:</td><td>'.   	$item[15].'</td></tr>';
			}
			# SERIAL NUMBER
			if ($item[5]<>NULL) {
				$html->body.= '<tr><td>Serial number&nbsp;:</td><td>'.      $item[5].'</td></tr>';
			}
			# BARCODE
			if (($item[23]<>NULL)or($list=="LEARN")) {
				$html->body.= '<tr><td>Code-Barre&nbsp;:</td><td>';
				if ($list=="ITEM") {
					$html->body.= $item[23];
				}elseif ($list=="LEARN"){
					$html->body.= '<img src="barcodescanning.gif">';
				}
				$html->body.= '</td></tr>';
			}
			# SIM			
			$query_sim = "SELECT * FROM mag_sim"
				." WHERE mag_sim.device_id = ".$id
				." ORDER BY slot";
			$result_sim = $html->query($query_sim);
			while ($item_sim = mysqli_fetch_array($result_sim)) {
				$html->body.= '<tr><td>Carte SIM'.($item_sim[5]!=""?' Slot&nbsp;'.$item_sim[5]:'').'&nbsp;:</td><td>'.           $item_sim[6].' '.$item_sim[1].' '.$item_sim[2].' '.$item_sim[3].'</td></tr>';
			}
			# REF MOSCOU
			if ($item[6]>0) {
			$html->body.= '<tr><td>ref Moscou&nbsp;:</td><td>'.      ($item[6]==-1?"N/C":$item[6]).'</td></tr>';
			}
			# AIRE
			if ($html->uid==-1) {
				$html->body.= '<tr><td>Aire&nbsp;:</td><td><a href="?concept=INVENTAIRE&list=ITEM&area_id='.$item[21].'">'.$item[0].'</a></td></tr>';
			}else{
				$html->body.= '<tr><td>Aire&nbsp;:</td><td>';
				$html->body.= '<form method="POST">';
				$html->body.= $html->menuswitch("mag_area","id" ,"name",$item[21]).' <a href="?concept=INVENTAIRE&list=ITEM&area_id='.$item[21].'">Voir</a>';
				$html->body.= '</form>';
				$html->body.= '</td></tr>';
			}
			# CLASSE
			if ($html->uid==-1) {
				$html->body.= '<tr><td>Classe&nbsp;:</td><td><a href="?concept=INVENTAIRE&list=ITEM&class_id='.$item[20].'">'.$item[2].'</a> '.$item[3].'</td></tr>';
			}else{
				$html->body.= '<tr><td>Classe&nbsp;:</td><td>';
				$html->body.= '<form method="POST">';
				$html->body.= $html->menuswitch("mag_class","id" ,"name",$item[20]).' <a href="?concept=INVENTAIRE&list=ITEM&class_id='.$item[20].'">'.($item[3]==""?"Voir":$item[3]).'</a>';
				$html->body.= '</form>';
				$html->body.= '</td></tr>';
			}
			# TAG
			if ($html->uid==-1) {
				if ($item[4]<>NULL) {
					$html->body.= '<tr><td>Etiquette&nbsp;:</td><td>'.      $item[4].'</td></tr>';
				}
			}else{
				$html->body.= '<tr><td>Etiquette&nbsp;:</td><td>';
				$html->body.= '<form method="POST">';
				$html->body.= '<input SIZE="60" TYPE="text" NAME="tag" VALUE="'.$item[4].'" ><input class="bouton_in" type="submit" />';
				$html->body.= '</form>';
				$html->body.= '</td></tr>';
			}
			# INFORMATIONS
			if ($html->uid==-1) {
				if ($item[7]<>NULL) {
					$html->body.= '<tr><td>Informations&nbsp;:</td><td>'.      $item[7].'</td></tr>';
				}
			}else{
				$html->body.= '<tr><td>Informations&nbsp;:</td><td>';
				$html->body.= '<form method="POST">';
				$html->body.= '<input SIZE="60" TYPE="text" NAME="info" VALUE="'.$item[7].'" ><input class="bouton_in" type="submit" />';
				$html->body.= '</form>';
				$html->body.= '</td></tr>';
			}
			# STATUS
			if ($html->uid==-1) {
				$html->body.= '<tr><td>Etat&nbsp;:</td><td class="status'.$item[16].'">'.           $item[17].'</td></tr>';
			}else{
				$html->body.= '<tr><td>Etat&nbsp;:</td><td class="status'.$item[16].'">';
				$html->body.= '<form method="POST">';
				$html->body.= $html->menuswitch("mag_status","id" ,"name",$item[16]);
				$html->body.= '</form>';
				$html->body.= '</td></tr>';
			}
			# CONSIGNE
			if ($html->uid!=-1) {
				$html->body.= '<tr><td>Consigne</td><td>';
				$html->body.= '<form enctype="multipart/form-data" method="post">';
				$html->body.= '<input type="hidden" name="item_id" value='.$id.'>';
				$html->body.= '<textarea rows = "5" cols = "80" name = "body"></textarea><br>Image:<input type="hidden" name="MAX_FILE_SIZE" value="'.CONFIG::FILE_MAX_SIZE.'" /><input type="file" name="fic" size=100 />';
				if ($html->uid==-1) {
					$html->body.= '<input type="text" name="initials" value="initiales" size="3">';
				}
				$html->body.= '<input type="submit" value="Poster"  class="bouton_in" >';
				$html->body.= "</form>";
			}
			# FIN DE TABLE
			$html->body.= "</table>";
		}else{
			$html->body.= "Cet élément n'existe pas dans la base";
			$html->body($query);
		}
		if (isset($_POST['item_id'])) {
			$item_id = $_POST['item_id'];
			$body = (isset($_POST['body'])?$_POST['body']:"Vide.");
			$initials = (isset($_POST['initials'])?substr($_POST['initials'],0,3):"??");
			$query = "INSERT INTO `mag_item_log` SET "
				."active=1, "
				."item_id="		 	.$id.", "
				."level=1, "
				."initials='".($html->uid>0?$html->initials($html->uid):$initials). "', "
				."uid='".$html->uid. "', "
				."ip='".$html->terminal. "', "
				."station_id='".CONFIG::ID_STATION. "', "
				."body='". addslashes(addslashes($body))."'" ;
			if ( isset($_FILES['fic']) ) {
				$ret        = false;
				$img_blob   = '';
				$img_taille = 0;
				$img_type   = '';
				$img_nom    = '';
				$ret        = is_uploaded_file($_FILES['fic']['tmp_name']);
				$img_taille = $_FILES['fic']['size'];
				if ($ret) {
					// Le fichier a bien été reçu
					$img_taille = $_FILES['fic']['size'];
					if ($img_taille < CONFIG::FILE_MAX_SIZE) {
						$img_type = $_FILES['fic']['type'];
						$img_nom  = $_FILES['fic']['name'];
						$img_blob = file_get_contents ($_FILES['fic']['tmp_name']);
						$query .=",type='".$img_type."' , snapshot='" . addslashes ($img_blob) . "'";
					}
				}
			}
			$result =  $html->query($query);
		}
		# Historique
		$html->h2("Historique");
		$html->mag_historique("AND `mag_item_log`.active = 1 AND item_id=".$id." ORDER BY datetime DESC LIMIT 20",false);		
	#### ITEM LIST ################################################################################################################################################################
	}elseif ($list=="ITEM"){
		# ENTETE CONTEXTUEL
		if ($class_id>=0) {
			$sql="SELECT name,info,planning FROM mag_class WHERE id=".$class_id." ORDER BY name";
			$result = $html->query($sql);
			while ($item = mysqli_fetch_array($result)) {
				$html->body="<h1>".$item[0]."</h1>".($item[1]!=""?"<h2>".$item[1]."</h2>":"");
			}			
		} elseif ($model_id>0) {
			$sql="SELECT mag_model.description,mag_brand.name,mag_model.reference,mag_model.info FROM mag_model,mag_brand WHERE mag_model.brand_id = mag_brand.id and mag_model.id=".$model_id;
			$result = $html->query($sql);
			while ($item = mysqli_fetch_array($result)) {
				$html->body="<h1>".$item[0]." ".$item[1]." ".$item[2]."</h1>".($item[3]!=""?"<h2>".$item[3]."</h2>":"");
			}			
		} 
		# LISTE DES ITEMS
		$order_by 	= (isset($_GET['order_by'])?$_GET['order_by']:"mag_class.name");
		$html->body.="<table>";
		# Headers
			
		$html->body.='
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_class.name">Classe</a></th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_model.description">Description</a></th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_brand.name">Marque</a></th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_model.reference">Modèle</a></th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_inventaire.tag">Etiquette</a></th>
			<th>N° Série</th>
			<th>Ref. Moscou</th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_status.name">&Eacute;tat</a></th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_area.name">Aire</a></th>
			</tr><tr>';
		
		# Selections
		$sql = 'SELECT 	`mag_inventaire`.id,
			`mag_class`.name,
			`mag_class`.`info`,
			`mag_brand`.`name`,
			`mag_model`.`reference`,
			`mag_model`.`description`,
			`mag_inventaire`.`tag`,
			`mag_inventaire`.`serial`,
			`mag_inventaire`.`refMoscou`,
			`mag_inventaire`.`info`,
			`mag_model`.`info`,
			`mag_model`.`hyperlien`,
			`mag_area`.`name`,
			`mag_status`.`name`,
			`mag_status`.`id`,
			`mag_inventaire`.`model_id`,
			`mag_model`.`brand_id`,
			`mag_inventaire`.`class_id`
			FROM `mag_inventaire`,`mag_status`,`mag_model`,`mag_class`,`mag_brand`,`mag_area`';

		# REQUETE
		$sql.= 'WHERE `mag_status`.`id`=`mag_inventaire`.`status_id` and
			`mag_model`.`id`=`mag_inventaire`.`model_id` and
			`mag_class`.`id`=`mag_inventaire`.`class_id` and
			`mag_brand`.`id`=`mag_model`.`brand_id` and
			`mag_area`.`id`=`mag_inventaire`.`area_id`';
		# CLAUSE PAGE
		if ($page <> "") {
			$sql.= " and `mag_page`.`name`='".$page."'";
			$sql.= " and ( `mag_page`.`class_id` =`mag_inventaire`.`class_id` or `mag_page`.`model_id` =`mag_inventaire`.`model_id` or `mag_page`.`area_id` =`mag_inventaire`.`area_id` )";
		}
		# CLAUSE CLASS ID
		if ($class_id >= 0) {
			$sql.= " and `mag_inventaire`.`class_id`='".$class_id."'";
		}
		# CLAUSE MODELE
		if ($model_id > 0) {
			$sql.= " and `mag_inventaire`.`model_id`='".$model_id."'";
		}
		# CLAUSE AIRE
		if ($area_id >= 0) {
			$sql.= " and `mag_inventaire`.`area_id`='".$area_id."'";
		}
		# CLAUSE CATEGORIE
		if ($category_id >= 0) {
			$sql.= " and `mag_model`.`category_id`='".$category_id."'";
		}
		# CLAUSE ORDER BY
		if ($order_by == "mag_brand.name") {
			$sql.= " ORDER BY mag_brand.name,mag_model.reference,mag_class.name";
		}elseif ($order_by == "mag_class.name") {
			$sql.= " ORDER BY mag_class.name,mag_brand.name,mag_model.reference";
		}elseif ($order_by == "mag_model.reference") {
				$sql.= " ORDER BY mag_model.reference,mag_class.name,mag_inventaire.tag";
		}elseif ($order_by == "mag_model.description") {
			$sql.= " ORDER BY mag_model.description";
		}elseif ($order_by == "mag_inventaire.tag") {
			$sql.= " ORDER BY mag_inventaire.tag,mag_class.name,mag_model.reference";
		}elseif ($order_by == "mag_area.name") {
			$sql.= " ORDER BY mag_area.name";
		}elseif ($order_by == "mag_status.name") {
			$sql.= " ORDER BY mag_status.name";
		}

		$result = $html->query($sql);
		while ($item = mysqli_fetch_array($result)) {
			$html->body .= '<tr class="tr_'.($item_id==$item[0]?"selected":"hover").'" onclick="window.location.href = \'?concept=INVENTAIRE&list=ITEM'.($class_id>0?'&class_id='.$class_id:'').'&item_id='.$item[0].'\'">'
			.'<td>'.$item[1].'</td>'                                                                                # CLASS
			.'<td>'.$item[5].'</td>'                                                                                # DESCRIPTION
			.'<td>'.$item[3].'</td>'                                                                                # MARQUE
			.'<td>'.$item[4].'</td>'                                                                                # REFERENCE
			.'<td>'.$item[6].'</td>'                                                                                # ETIQUETTE
			.'<td>'.$item[7].'</td>'                                                                                # N SERIE
			.'<td>'.($item[8]==0?"":($item[8]==-1?"NC":$item[8])).'</td>'  											# REF MOSCOU
			.'<td class="status'.$item[14].'">'.$item[13].'</td>'                   								# STATUS
			.'<td>'.$item[12].'</td>'                                                                               # ZONE
			.'</tr>'."\n";
		}
		$html->body.='</table>'."\n";
		$html->body.= '<table class="menubar"><tr height="50"><th><a class="menubut" href="?concept=EXPORT_CSV&order_by='.$order_by.'&list='.$list.($model_id>0?'&model_id='.$model_id:'')
			.($category_id>0?'&category_id='.$category_id:'').($area_id>0?'&area_id='.$area_id:'').($class_id>0?'&class_id='.$class_id:'').'">Export CSV</a></th>'."\n";
		$html->body.= '</tr></table>'."\n";
		#### ITEM NULL = CODES SANS CODE BARRE
	}elseif ($list=="NULL"){
		# ENTETE CONTEXTUEL
		$html->body="<h1>Liste du matérie sans code-barre</h1>";
		# LISTE DES ITEMS
		$order_by 	= (isset($_GET['order_by'])?$_GET['order_by']:"mag_class.name");
		$html->body.="<table>";
		# Headers
		$html->body.='
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_class.name">Classe</a></th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_model.description">Description</a></th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_brand.name">Marque</a></th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_model.reference">Modèle</a></th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_inventaire.tag">Etiquette</a></th>
			<th>N° Série</th>
			<th>Ref. Moscou</th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_status.name">&Eacute;tat</a></th>
			<th><a href="?concept=INVENTAIRE&'.($page<>""?"page=".$page."&":"").($class_id>0?"class_id=".$class_id."&":"").($model_id>0?"model_id=".$model_id."&":"").($area_id>=0?"area_id=".$area_id."&":"").($category_id>=0?"category_id=".$category_id."&":"").'order_by=mag_area.name">Aire</a></th>
			</tr><tr>';
		# Selections
		$sql = 'SELECT 	`mag_inventaire`.id,		# 0
			`mag_class`.name,		# 1
			`mag_class`.`info`,		# 2
			`mag_brand`.`name`,		# 3
			`mag_model`.`reference`,	# 4
			`mag_model`.`description`,	# 5
			`mag_inventaire`.`tag`,         # 6
			`mag_inventaire`.`serial`,	# 7
			`mag_inventaire`.`refMoscou`,	# 8
			`mag_inventaire`.`info`,	# 9
			`mag_model`.`info`,		#10
			`mag_model`.`hyperlien`,	#11
			`mag_area`.`name`,		#12
			`mag_status`.`name`,		#13
			`mag_status`.`id`,		#14
			`mag_inventaire`.`model_id`,	#15
			`mag_model`.`brand_id`,
			`mag_inventaire`.`class_id`,
			`mag_inventaire`.`barcode`
			FROM `mag_inventaire`,`mag_status`,`mag_model`,`mag_class`,`mag_brand`,`mag_area`';
		if ($page <> "") {
			$sql .= ',`mag_page`';
		}
		# REQUETE
		$sql.= 'WHERE `mag_status`.`id`=`mag_inventaire`.`status_id` and
			`mag_model`.`id`=`mag_inventaire`.`model_id` and
			`mag_class`.`id`=`mag_inventaire`.`class_id` and
			`mag_brand`.`id`=`mag_model`.`brand_id` and
			`mag_area`.`id`=`mag_inventaire`.`area_id` and
			`mag_inventaire`.`barcode` IS NULL ';
		# CLAUSE PAGE
		if ($page <> "") {
			$sql.= " and `mag_page`.`name`='".$page."'";
			$sql.= " and ( `mag_page`.`class_id` =`mag_inventaire`.`class_id` or `mag_page`.`model_id` =`mag_inventaire`.`model_id` or `mag_page`.`area_id` =`mag_inventaire`.`area_id` )";
		}
		# CLAUSE CLASS ID
		if ($class_id >= 0) {
			$sql.= " and `mag_inventaire`.`class_id`='".$class_id."'";
		}
		# CLAUSE MODELE
		if ($model_id > 0) {
			$sql.= " and `mag_inventaire`.`model_id`='".$model_id."'";
		}
		# CLAUSE AIRE
		if ($area_id >= 0) {
			$sql.= " and `mag_inventaire`.`area_id`='".$area_id."'";
		}
		# CLAUSE CATEGORIE
		if ($category_id >= 0) {
			$sql.= " and `mag_model`.`category_id`='".$category_id."'";
		}
		# CLAUSE ORDER BY
		if ($order_by == "mag_brand.name") {
			$sql.= " ORDER BY mag_brand.name,mag_model.reference,mag_class.name";
		}elseif ($order_by == "mag_class.name") {
			$sql.= " ORDER BY mag_class.name,mag_brand.name,mag_model.reference";
		}elseif ($order_by == "mag_model.reference") {
				$sql.= " ORDER BY mag_model.reference,mag_class.name,mag_inventaire.tag";
		}elseif ($order_by == "mag_model.description") {
			$sql.= " ORDER BY mag_model.description";
		}elseif ($order_by == "mag_inventaire.tag") {
			$sql.= " ORDER BY mag_inventaire.tag,mag_class.name,mag_model.reference";
		}elseif ($order_by == "mag_area.name") {
			$sql.= " ORDER BY mag_area.name";
		}elseif ($order_by == "mag_status.name") {
			$sql.= " ORDER BY mag_status.name";
		}
		$result = $html->query($sql);
		while ($item = mysqli_fetch_array($result)) {
			$html->body .= '<tr class="tr_'.($item_id==$item[0]?"selected":"hover").'" onclick="window.location.href = \'?concept=INVENTAIRE&list=ITEM'.($class_id>0?'&class_id='.$class_id:'').'&item_id='.$item[0].'\'">'
			.'<td>'.$item[1].'</td>'										# CLASS
			.'<td>'.$item[5].'</td>'										# DESCRIPTION
			.'<td>'.$item[3].'</td>'										# MARQUE
			.'<td>'.$item[4].'</td>'										# REFERENCE
			.'<td>'.$item[6].'</td>'										# ETIQUETTE
			.'<td>'.$item[7].'</td>'										# N SERIE
			.'<td>'.($item[8]==0?"":($item[8]==-1?"NC":$item[8])).'</td>'	# REF MOSCOU
			.'<td class="status'.$item[14].'">'.$item[13].'</td>'			# STATUS
			.'<td>'.$item[12].'</td>'										# ZONE
			.'</tr>'."\n";
		}
		$html->body.='</table>';
	#### CLASS ####################################################################################################################################################################
	}elseif ($list=="CLASS") {
		$order_by 	= (isset($_GET['order_by'])?$_GET['order_by']:"mag_class.name");		
		$html->body="<table>";
		# Headers
		$html->body.='<th><a href="?concept=INVENTAIRE&list=CLASS&order_by=mag_class.name">Nom</a></th>
			<th>Description</th>
			<th><a href="?concept=INVENTAIRE&list=CLASS&order_by=count">Quantité</a></th>
			</tr><tr>';
		# Selections
		$sql = 'SELECT 	`mag_class`.`name`,
			`mag_class`.`info`,
			count(`mag_inventaire`.`id`),
			`mag_class`.`id`,
			`mag_class`.`planning`
			FROM `mag_inventaire`,`mag_class` ';
		$sql.= 'WHERE `mag_class`.`id`=`mag_inventaire`.`class_id`
			GROUP BY  `mag_class`.`id` ';
		# CLAUSE ORDER BY
		if ($order_by == "mag_class.name") {
			$sql.= " ORDER BY mag_class.name";
		}elseif ($order_by == "count") {
			$sql.= " ORDER BY count(`mag_inventaire`.`id`) DESC,mag_class.name";
		}
		$result = $html->query($sql);
		while ($item = mysqli_fetch_array($result)) {
			$html->body .= '<tr class="tr_hover" onclick="window.location.href = \'?concept=INVENTAIRE&list=ITEM&class_id='.$item[3].'\'">'
			.'<td>'.($item[4]==1?"<b>":"").$item[0].($item[4]==1?"</b>":"").'</td>'
			.'<td>'.$item[1].'</td>'
			.'<td>'.$item[2].'</td>'
			.'</tr>'."\n";
		}
		$html->body.='</table>';
	#### BRAND ####################################################################################################################################################################
	}elseif ($list=="BRAND") {
		$order_by 	= (isset($_GET['order_by'])?$_GET['order_by']:"mag_brand.name");
		# BODY
		$html->body="<table>";
		# Headers
		$html->body.='<th><a href="?concept=INVENTAIRE&list=BRAND&order_by=mag_brand.name">Nom</a></th>
			<th><a href="?concept=INVENTAIRE&list=BRAND&order_by=count">Quantité</a></th>
		</tr><tr>';
		# Selections
		$sql = 'SELECT 	`mag_brand`.`name`,
				count(`mag_inventaire`.`id`),
				`mag_model`.`brand_id`
				FROM `mag_inventaire`,`mag_model`,`mag_brand` ';
		$sql.= 'WHERE `mag_model`.`id`=`mag_inventaire`.`model_id` and
				`mag_brand`.`id`=`mag_model`.`brand_id`
			GROUP BY  `mag_brand`.`id` ';
		# CLAUSE ORDER BY
		if ($order_by == "mag_brand.name") {
			$sql.= " ORDER BY mag_brand.name";
		}elseif ($order_by == "count") {
				$sql.= " ORDER BY count(`mag_inventaire`.`id`) DESC,mag_brand.name";
		}
		$result = $html->query($sql);
		while ($item = mysqli_fetch_array($result)) {
				$html->body .= '<tr class="tr_hover" onclick="window.location.href = \'?concept=INVENTAIRE&list=MODEL&brand_id='.$item[2].'\'">'
				.'<td>'.$item[0].'</td>'
				.'<td>'.$item[1].'</td>'
				.'</tr>'."\n";
		}
		$html->body.='</table>';
	#### MODEL ####################################################################################################################################################################
	}elseif ($list=="MODEL") {
		$order_by 	= (isset($_GET['order_by'])?$_GET['order_by']:"mag_brand.name");
		# BODY
		$html->body="<table>";
		# Headers
		$html->body.='<th><a href="?concept=INVENTAIRE&list=MODEL&'.($brand_id>0?"brand_id=".$brand_id."&":"").'order_by=mag_brand.name">Marque</a></th>
			<th><a href="?concept=INVENTAIRE&list=MODEL&'.($brand_id>0?"brand_id=".$brand_id."&":"").'order_by=mag_model.reference">R&eacute;f&eacute;rence</a></th>
			<th><a href="?concept=INVENTAIRE&list=MODEL&'.($brand_id>0?"brand_id=".$brand_id."&":"").'order_by=mag_model.description">Description</a></th>
			<th><a href="?concept=INVENTAIRE&list=MODEL&'.($brand_id>0?"brand_id=".$brand_id."&":"").'order_by=category">Catégorie</a></th>
			<th><a href="?concept=INVENTAIRE&list=MODEL&'.($brand_id>0?"brand_id=".$brand_id."&":"").'order_by=count">Quantité</a></th>
		</tr><tr>';
		# Selections
		$sql = 'SELECT 	`mag_brand`.`name`,
				`mag_model`.`reference`,
				`mag_model`.`description`,
				count(`mag_inventaire`.`id`),
				`mag_model`.`id`,
				`mag_model`.`brand_id`, `mag_category`.`name`
				FROM `mag_inventaire`,`mag_model`,`mag_brand`,`mag_category` ';
		$sql.= 'WHERE `mag_model`.`id`=`mag_inventaire`.`model_id` and
				`mag_brand`.`id`=`mag_model`.`brand_id` and
				`mag_model`.`category_id`=`mag_category`.`id`';
		# CLAUSE CLASS ID
		if ($brand_id > 0) {
			$sql.= " and `mag_brand`.`id`='".$brand_id."'";
		}
		$sql.= '	GROUP BY `mag_model`.`id` ';
		# CLAUSE ORDER BY
		if ($order_by == "mag_brand.name") {
			$sql.= " ORDER BY mag_brand.name,mag_model.reference";
		}elseif ($order_by == "mag_model.reference") {
				$sql.= " ORDER BY mag_model.reference";
		}elseif ($order_by == "mag_model.description") {
				$sql.= " ORDER BY mag_model.description,mag_brand.name,mag_model.reference";
		}elseif ($order_by == "count") {
				$sql.= " ORDER BY count(`mag_inventaire`.`id`) DESC,mag_brand.name,mag_model.reference";
		}elseif ($order_by == "category") {
				$sql.= " ORDER BY mag_category.name,mag_model.description,mag_brand.name,mag_model.reference";
		}
		$result = $html->query($sql);
		while ($item = mysqli_fetch_array($result)) {
				$html->body .= '<tr class="tr_hover" onclick="window.location.href = \'?concept=INVENTAIRE&list=ITEM&model_id='.$item[4].'\'">'
					.'<td>'.$item[0].'</td>'
					.'<td>'.$item[1].'</td>'
					.'<td>'.$item[2].'</td>'
					.'<td>'.$item[6].'</td>'
					.'<td>'.$item[3].'</td>'
					.'</tr>'."\n";
		}
		$html->body.='</table>';
	}elseif ($list=="AREA") {
		$order_by 	= (isset($_GET['order_by'])?$_GET['order_by']:"mag_area.name");
		# BODY
		$html->body="<table>";
		# Headers
		$html->body.='<th><a href="?concept=INVENTAIRE&list=MODEL&order_by=mag_area.name">Nom</a></th>
			<th><a href="?concept=INVENTAIRE&list=MODEL&order_by=count">Quantité</a></th>
		</tr><tr>';
		# Selections
		$sql = 'SELECT 	`mag_area`.`name`,
				count(`mag_inventaire`.`id`),
				`mag_area`.`id`
				FROM `mag_inventaire`,`mag_area` ';
		$sql.= 'WHERE `mag_area`.`id`=`mag_inventaire`.`area_id`
			GROUP BY  `mag_area`.`id` ';
		if ($order_by == "mag_area.name") {
			$sql.= " ORDER BY mag_area.name";
		}elseif ($order_by == "count") {
				$sql.= " ORDER BY count(`mag_inventaire`.`id`) DESC";
		}
		$result = $html->query($sql);
		while ($item = mysqli_fetch_array($result)) {
				$html->body .= '<tr class="tr_hover" onclick="window.location.href = \'?concept=INVENTAIRE&list=ITEM&area_id='.$item[2].'\'">'
				.'<td>'.$item[0].'</td>'
				.'<td>'.$item[1].'</td>'
				.'</tr>'."\n";
		}
		$html->body.='</table>';
	}elseif ($list=="SIM") {
		$order_by 	= (isset($_GET['order_by'])?$_GET['order_by']:"mag_sim.operator");
		# BODY
		$html->body="<table>";
		# Headers
		$html->body.='
			<th><a  href="?concept=INVENTAIRE&list=SIM&order_by=mag_sim.operator"	>Opérateur</a></th>
			<th>N° Tel</th>
			<th>NSCE</th>
			<th>Info</th>
			<th>Slot</th>
			<th>Marque</th>
			<th>Modèle</th>
			<th>&Eacute;tat</th>
			<th><a  href="?concept=INVENTAIRE&list=SIM&order_by=mag_inventaire.tag"       >&Eacute;tiquette</a></th>
			<th><a  href="?concept=INVENTAIRE&list=SIM&order_by=mag_class.name"       >Kit</a></th>
			<th>Aire</th>
			<th>Info</th>
			<th><a  href="?concept=INVENTAIRE&list=SIM&order_by=valid"       >Validité</a></th>
		</tr><tr>';
		# Selections
		$sql = 'SELECT 	`mag_sim`.id,
				`mag_class`.`name`,		
				`mag_brand`.`name`,		
				`mag_model`.`reference`,	
				`mag_inventaire`.`tag`,         
				`mag_inventaire`.`refMoscou`,	
				`mag_inventaire`.`info`,	
				`mag_area`.`name`,		
				`mag_status`.`name` ,		
				mag_sim.operator,		
				`mag_sim`.`nsce`,		
				`mag_sim`.`info`,		
				`mag_sim`.`slot`,		
				`mag_sim`.`msisdn`,		
				`mag_inventaire`.`id`,
				`mag_sim`.`valid`,
				class_id,
				device_id
				FROM `mag_inventaire`,`mag_status`,`mag_model`,`mag_class`,`mag_brand`,`mag_area`,`mag_sim`';
		$sql.= ' WHERE `mag_status`.`id`=`mag_inventaire`.`status_id` and
				`mag_model`.`id`=`mag_inventaire`.`model_id` and
				`mag_class`.`id`=`mag_inventaire`.`class_id` and
				`mag_brand`.`id`=`mag_model`.`brand_id` and
				`mag_sim`.`device_id`=`mag_inventaire`.`id` and
				`mag_area`.`id`=`mag_inventaire`.`area_id`';
		$sql.= ' UNION ALL  SELECT 	`mag_sim`.id,
			NULL,	
			NULL,	
			NULL,
			NULL,        
			NULL,
			NULL,
			NULL,	
			NULL ,		
			`mag_sim`.`operator`,		
			`mag_sim`.`nsce`,		
			`mag_sim`.`info`,		
			`mag_sim`.`slot`,		
			`mag_sim`.`msisdn`,		
			NULL,
			`mag_sim`.`valid`,
			NULL,
			device_id
			FROM `mag_sim`';
		$sql.= ' WHERE 
			`mag_sim`.`device_id` is NULL ';
		# CLAUSE ORDER BY
		if ($order_by == "mag_sim.operator") {
			$sql.= " ORDER BY operator";
		}elseif ($order_by == "mag_class.name") {
			$sql.= " ORDER BY class_id,device_id,slot";
		}elseif ($order_by == "mag_inventaire.tag") {
				$sql.= " ORDER BY tag,device_id,slot";
		}elseif ($order_by == "valid") {
				$sql.= " ORDER BY valid DESC";
		}
		$result = $html->query($sql);
		while ($item = mysqli_fetch_array($result)) {
				$html->body .= '<tr class="tr_hover" onclick="window.location.href = \'?concept=INVENTAIRE&list=ITEM&item_id='.$item[14].'\'">'
				.'<td>'.$item[9].'</td>'
				.'<td>'.$item[13].'</td>'
				.'<td>'.$item[10].'</td>'
				.'<td>'.$item[11].'</td>'
				.'<td>'.$item[12].'</td>'
				.'<td>'.$item[2].'</td>'
				.'<td>'.$item[3].'</td>'
				.'<td>'.$item[8].'</td>'
				.'<td>'.$item[4].'</td>'
				.'<td>'.$item[1].'</td>'
				.'<td>'.$item[7].'</td>'
				.'<td>'.$item[6].'</td>'
				.'<td>'.$item[15].'</td>'
				.'</tr>'."\n";
		}
		$html->body.='</table>';
	}elseif ($list=="CATEGORIE"){
		$html->body.="<table>";
		$sql = 'SELECT 	`mag_category`.id,`mag_category`.name,count(*)
				FROM `mag_inventaire`,`mag_category`,`mag_model`';
		$sql.= "WHERE mag_inventaire.model_id = mag_model.id and mag_model.category_id = mag_category.id GROUP BY mag_category.id ORDER BY mag_category.name";
		$result = $html->query($sql);
		while ($item = mysqli_fetch_array($result)) {
			$html->body.='<tr class="tr_'.($category_id==$item[0]?"selected":"hover").'" onclick="window.location.href = \'?concept=INVENTAIRE&list=ITEM&category_id='.$item[0].'\'"><td>'.$item[1]."</td><td>".$item[2]."</td></tr>";
		}
		$html->body.="</table>";
	}
	$html->out();
}elseif ($concept=="FULLSCREEN") { ##############################################################################	FULLSCREEN
	$html->body = '<table height=100% width=100%><tr><td class="td_center"><img src="mrpropre.png"><h1>Le scanner reconnait bien les lingettes mais elles ne font pas partie de l\'inventaire !</h1>';
	$html->body.= "</td></tr></table>";
	$html->out();
}elseif ($concept=="HISTORIQUE"){ ###############################################################################	HISTORIQUE
	$html->mag_historique("AND `mag_item_log`.active = 1 ORDER BY datetime DESC LIMIT 1000",true);
	$html->out();
}elseif ($concept=="CONTACTS"){ #################################################################################	CONTACTS
	$out="<table>";
	# Headers
	$out.='<tr><th>nom</th>
		<th>fonction</th>
		<th>email</th>
		<th>mobile</th>
		<th>info</th>
		</tr>';
	# Selections
	$sql = 'SELECT 	id,		# 0
		name,				# 1
		email,				# 2
		mobile,				# 3
		info,         		# 4
		fonction            # 5
		FROM `mag_contact`';
	$sql.= " ORDER BY name";
	$result = $html->query($sql);
	while ($item = mysqli_fetch_array($result)) {
        $out .= '<tr class="tr_hover">'
		.'<td>'.$item[1].'</td>'
		.'<td>'.$item[5].'</td>'
		.'<td><a href="mailto:'.$item[2].'">'.$item[2].'</a></td>'
		.'<td>'.$item[3].'</td>'
		.'<td>'.$item[4].'</td>'
       	.'</tr>'."\n";
	}
	$out.='</table>';
	$html->body($out);
	$html->out();
}elseif ($concept=="HELP") { ################################################################################	HELP
	$html->body="<h2>Codes-barre</h2>";
	$barcodes = [
		['AJOUTER AU PANIER',   'ADD'			,'Ajoute les éléments suivants au panier'],
		['ANNULE',    			'CANCEL'		,'Annule l\'opération en cours'],
		['FERMER RESA',    		'CLOSE'			,'Force la fermeture'],
		['AUCUN CODE', 			'NULL'			,'Aucun code barre ( en mode LEARN )'],
		['LOG MATHILDE', 		'USER2'			,'Mathilde Fournier'],
		['LOG OUT', 			'USER0'			,'Déconnexion utilisateur'],
		['NOUVEAU CODE BARRE', 	'LEARN'			,'Apprentissage du code barre sur un équipement'],
		['RETIRER DU PANIER', 	'REMOVE'		,'Supprime les éléments suivants du panier'],
	];
	$html->body="<h2>Codes-barre</h2>";
	$html->body.="<center>\n";
	foreach ($barcodes as [$titre, $code, $help]) {
		$html->body.="<br><br><br>\n";
		$html->body.="<h3>".$titre."</h3>";
		$html->body.='<img src="/barcodegen/html/image.php?code=code128&o=1&t=30&r=2&text='.$code.'&f=0&a1=B&a2=" alt="'.$code.'"><br>';
		$html->body.=$help;
		$html->body.="<br><br><br>\n";
	}
	$html->body.="</center>\n";
	$html->out();
}elseif ($concept=="IMAGE_LOG") { ###########################################################################
	$query = "SELECT `mag_item_log`.id,`mag_item_log`.item_id,`mag_item_log`.datetime,`mag_item_log`.initials,`mag_item_log`.body,`mag_item_log`.level,".
                                "`mag_item_log`.snapshot,`mag_item_log`.active,`mag_item_log`.uid,".
                                " `mag_class`.name,`mag_brand`.name,`mag_model`.reference,`mag_inventaire`.tag".
                                " FROM `mag_item_log`,`mag_class`,`mag_brand`,`mag_model`,`mag_inventaire`".
                                " WHERE mag_item_log.station_id = ".CONFIG::ID_STATION.
                                " AND `mag_class`.`id`=`mag_inventaire`.`class_id`".
                                " AND `mag_brand`.`id`=`mag_model`.`brand_id`".
                                " AND `mag_model`.`id`=`mag_inventaire`.`model_id`".
				" AND `mag_item_log`.`item_id`=`mag_inventaire`.`id` ".
                                " AND `mag_item_log`.`id`=".$id;

	$result = $html->query($query);

	if (mysqli_num_rows($result)!=0) {

        	$item = mysqli_fetch_array($result);
		$out = '<img src="image_log.php?id='.$item['id'].'" width="100%">';

        	$out.= "<a href=\"?concept=INVENTAIRE&item_id=".$item[1]."\">".$item[12]." ".$item[11]." ".$item[10]." ".$item[9]."</a>";
        	$html->h2("<b>".$item['datetime']." ".($item['uid']!=-1?$html->user($item['uid']):$item['initials'])."</b>");

		$html->body($out);
	}
	$html->out();
}elseif ($concept=="RESA_OUT") { ################################################################################	RESA CHECKOUT
	if ($id>0) {
		if ($list=="ATA") {
			header("Content-Type: text/csv; charset=UTF-8");
			header("Content-Type: text/csv");
			header("Content-disposition: filename=resa".$id.".csv");
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
			}else{
				$formulaire="La resa ".$id." n'existe pas";
			}
			echo $formulaire;
		}else{
			### FORMULAIRE PRINT ###
			?>
			<html>
			<head>
			<style>
			h1 {
				font:14px Helvetica;
				font-weight: bold;
				color: white;
				background-color: #43b61d;
				text-align: center;
				-webkit-print-color-adjust: exact;
			}
			h2 {
				font:12px Helvetica;
				font-weight: bold;
				color: #43b61d;
				text-align: center;
				-webkit-print-color-adjust: exact;
			}
			th {
  				display: table-cell;
  				vertical-align: top;
  				text-align: left;
  				padding: 1px;
  				font:10px Helvetica;
  				font-weight: bold;
			}
			table {
				table-layout: auto;
				width: 100%;
				font-size:80%;
			}
			.td_full {
  				border-bottom:0;
			}
			td {
  				display: table-cell;
  				vertical-align: top;
  				text-align: left;
  				padding: 1px;
  				font:10px Helvetica;
  				border-bottom:0.5px solid #d6d6d6;
			}
			</style>
			<title>Résa #<?php echo $id;?></title>
			</head>
			<body>
			<table>
			<tr><td class="td_full">
			<img src="logo.png" width="70px" valign="middle" align="center">
			</td><td class="td_full">
			<img src="/barcodegen/html/image.php?code=code128&amp;o=1&amp;t=30&amp;r=2&amp;text=RESA<?php echo $id; ?>&amp;f=0&amp;a1=B&amp;a2=" alt="RESA<?php echo $id; ?>">
			</td></tr><tr><td class="td_full"></td><td class="td_full">
			<h1>Fiche de sortie</h1>
			<?php
			# RECUPERATION DES DATA DE FORMULAIRE
			if ($id>0) {
				$query = "SELECT date_start,date_stop,mag_contact.name,mag_contact.fonction,mag_contact.mobile,slug,mag_resa.info,mag_resa.start_rack_id,mag_resa.stop_rack_id".
					" FROM mag_resa,mag_contact WHERE mag_contact.id = mag_resa.contact_id AND mag_resa.id=".$id;
				$result =  $html->query($query);
				if (mysqli_num_rows($result)>0) {
					$item = mysqli_fetch_array($result);
					# START DATE ####################################################################
					$unixtimestart= intval( strtotime($item[0]) );
					$date_depart = strftime("%A %e %b %Y",$unixtimestart);
					# START HEURE ####################################################################
					$heure_depart = date('H:i', $unixtimestart);
					# STOP   DATE ####################################################################
					$unixtimestop= intval( strtotime($item[1]) );
					$date_retour = strftime("%A %e %b %Y",$unixtimestop);
					# STOP HEURE #####################################################################
					$heure_retour = date('H:i', $unixtimestop);
					$nom = $item[2];
					$fonction = $item[3];
					$telephone = $item[4];
					$slug = stripslashes($item[5]);
					$info = stripslashes($item[6]);
					$order   = array("\r\n", "\n", "\r");
					$info = str_replace($order, "<br />", $info);
					$rack_start= $html->rack_name($item[7]);
					$rack_stop=  $html->rack_name($item[8]);
				}else{
					$slug="";
					$info="";
					$nom="";
					$fonction="";
					$telephone="";
					$heure_retour = "";
					$date_retour = "";
					$heure_depart = "";
					$date_depart = "";
					$rack_start="";
					$rack_stop="";
				}
				# PANIER #########################################################
				$sql = 'SELECT  a.id,
								`mag_brand`.`name`,
								`mag_model`.`reference`,
								`mag_model`.`description`,
								a.`tag`,
								a.`serial`,
								a.`refMoscou`,
								a.`model_id`,
					mag_class.name
					FROM `mag_inventaire` AS a,`mag_model`,`mag_brand`,mag_resa_item,mag_class ';

				$sql.= 'WHERE `mag_model`.`id`=a.`model_id` and
						`mag_brand`.`id`=`mag_model`.`brand_id` and mag_class.id = a.class_id and ';
				$sql.=  ' a.id = mag_resa_item.item_id AND mag_resa_item.resa_id='.$id;
				$sql.= " ORDER BY `mag_model`.`description`,mag_brand.name,mag_model.reference";
				$result = $html->query($sql);
				if (mysqli_num_rows($result)!=0) {
					$formulaire=   '<h2>Liste du materiel emprunté</h2><table>';
					# Headers
					$formulaire.='<tr>
						<th>Description</th>
						<th>Marque</th>
						<th>Modèle</th>
						<th>Etiquette</th>
						<!--th>N° Série</th-->
						<!--th>Ref. Moscou</th-->
						<!--th>Classe</th-->							
						<!--th></th-->
						</tr>';
					while ($item = mysqli_fetch_array($result)) {
						$formulaire .= '<tr>'
						.'<td>'.$item[3].'</td>'
						.'<td>'.$item[1].'</td>'
						.'<td>'.$item[2].'</td>'
						.'<td>'.$item[4].'</td>'
						.'<!--td>'.$item[5].'</td-->'
						.'<!--td>'.($item[6]==0?"":($item[6]==-1?"":$item[6])).'</td-->'
						.'<!--td class="tableau">'.$item[8].'</td-->'
						.'<!--td class="tableau"></td-->'
						.'</tr>'."\n";
					}
					$formulaire.= "</table>";
				}
			}
			?>
			<table>
			<tr class="tableau"><td  class="tableau">Nom</td><td  class="tableau" colspan=3><?php echo $nom; ?></td></tr>
			<tr class="tableau"><td class="tableau">Fonction</td><td  class="tableau" colspan=3><?php echo $fonction; ?></td></tr>
			<?php if ($telephone!="") { ?>
				<tr class="tableau"><td class="tableau">Téléphone</td><td  class="tableau" colspan=3><?php echo $telephone; ?></td></tr>
			<?php } ?>
			<tr class="tableau"><td class="tableau">Départ</td><td class="tableau"><?php echo $date_depart; ?></td><td><?php echo $heure_depart; ?></td><td><?php echo $rack_start; ?></td></tr>
			<?php if ($slug!="") { ?>
				<tr class="tableau"><td class="tableau">Tournage</td><td  class="tableau" colspan=3><?php echo $slug; ?></td></tr>
			<?php } ?>
			<tr class="tableau"><td class="tableau">Retour</td><td class="tableau"><?php echo $date_retour; ?></td><td><?php echo $heure_retour; ?></td><td><?php echo $rack_stop; ?></td></tr>
			<?php if ($info!="") { ?>
				<tr class="tableau"><td class="tableau">Informations</td><td  class="tableau" colspan=3><?php echo $info; ?></td></tr>
			<?php } ?>
			</table>
			<?php echo $formulaire; ?>
			<h2>Signature obligatoire</h2>
			<table width="100%" class="tableau">
			<tr><th></th><th>Magasin</th><th>OPV/JRI</th></tr>
			<tr height=80><td class="tableau">Sortie</td><td class="tableau">Nom :<p>Signature :</td><td class="tableau">Nom :<p>Signature :</td></tr>
			<tr height=80><td class="tableau">Retour</td><td class="tableau">Nom :<p>Signature :</td><td class="tableau">Nom :<p>Signature :</td></tr>
			</table>
			</td></tr>
			</table>
			</body>
			<?php
		}
	}else{
		$formulaire="Il manque l'ID de la resa";
	}
}elseif ($concept=="EXPORT_CSV") {
	
	# Selections
	$sql = 'SELECT * FROM `mag_inventaire`,`mag_status`,`mag_model`,`mag_class`,`mag_brand`,`mag_area`';
	$sql.= 'WHERE `mag_status`.`id`=`mag_inventaire`.`status_id` and
		`mag_model`.`id`=`mag_inventaire`.`model_id` and
		`mag_class`.`id`=`mag_inventaire`.`class_id` and
		`mag_brand`.`id`=`mag_model`.`brand_id` and
		`mag_area`.`id`=`mag_inventaire`.`area_id`';
	# CLAUSE CLASS ID
	if ($class_id >= 0) {
		$sql.= " and `mag_inventaire`.`class_id`='".$class_id."'";
	}
	# CLAUSE MODELE
	if ($model_id > 0) {
		$sql.= " and `mag_inventaire`.`model_id`='".$model_id."'";
	}
	# CLAUSE AIRE
	if ($area_id >= 0) {
		$sql.= " and `mag_inventaire`.`area_id`='".$area_id."'";
	}
	# CLAUSE CATEGORIE
	if ($category_id >= 0) {
		$sql.= " and `mag_model`.`category_id`='".$category_id."'";
	}
	# CLAUSE ORDER BY
	if ($order_by == "mag_brand.name") {
		$sql.= " ORDER BY mag_brand.name,mag_model.reference,mag_class.name";
	}elseif ($order_by == "mag_class.name") {
		$sql.= " ORDER BY mag_class.name,mag_brand.name,mag_model.reference";
	}elseif ($order_by == "mag_model.reference") {
		$sql.= " ORDER BY mag_model.reference,mag_class.name,mag_inventaire.tag";
	}elseif ($order_by == "mag_model.description") {
		$sql.= " ORDER BY mag_model.description";
	}elseif ($order_by == "mag_inventaire.tag") {
		$sql.= " ORDER BY mag_inventaire.tag,mag_class.name,mag_model.reference";
	}elseif ($order_by == "mag_area.name") {
		$sql.= " ORDER BY mag_area.name";
	}elseif ($order_by == "mag_status.name") {
		$sql.= " ORDER BY mag_status.name";
	}
	$result = $html->query($sql);
	header("Content-Type: text/csv; charset=UTF-8");
	header("Content-Type: text/csv");
	header("Content-disposition: filename=resa".$id.".csv");
	$formulaire=   utf8_decode('ETIQUETTE;SERIE;REF MOSCOU;INFO;BARCODE;STATUT;REFERENCE;DESCRIPTION;INFO;HYPERLIEN;PRIX;POIDS;ORIGINE;CLASSE;INFO;MARQUE;LIEU').PHP_EOL;
	while ($item = mysqli_fetch_array($result)) {
		$formulaire .= '"=""'.utf8_decode($item[ 3]).'""";'; #ETIQUETTE
		$formulaire .= '"=""'.utf8_decode($item[ 4]).'""";'; #SERIE
		$formulaire .= '"=""'.utf8_decode(($item[ 5]>0?$item[ 5]:"")).'""";'; #REF MOSCOU
		$formulaire .= '"=""'.utf8_decode($item[ 8]).'""";'; #INFO
		$formulaire .= '"=""'.utf8_decode($item[10]).'""";'; #BARCODE
		$formulaire .= '"=""'.utf8_decode($item[12]).'""";'; #STATUT
		$formulaire .= '"=""'.utf8_decode($item[16]).'""";'; #REFERENCE
		$formulaire .= '"=""'.utf8_decode($item[17]).'""";'; #DESCRIPTION
		$formulaire .= '"=""'.utf8_decode($item[18]).'""";'; #INFO
		$formulaire .= '"=""'.utf8_decode($item[19]).'""";'; #HYPERLIEN
		$formulaire .= '"=""'.utf8_decode($item[20]).'""";'; #PRIX
		$formulaire .= '"=""'.utf8_decode($item[21]).'""";'; #POIDS
		$formulaire .= '"=""'.utf8_decode($item[22]).'""";'; #ORIGINE
		$formulaire .= '"=""'.utf8_decode($item[25]).'""";'; #CLASSE
		$formulaire .= '"=""'.utf8_decode($item[26]).'""";'; #INFO
		$formulaire .= '"=""'.utf8_decode($item[30]).'""";'; #MARQUE
		$formulaire .= '"=""'.utf8_decode($item[32]).'""";'; #LIEU
		$formulaire .= PHP_EOL;
	}
	echo $formulaire;
}

?>
