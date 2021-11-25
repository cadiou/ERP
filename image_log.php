<?php
 
 /*
 * 211125
 * timeticket / image_log.php
 * Baptiste Cadiou bc@mangrove.tv
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
	}
	public function query($query) {
		$result = mysqli_query($this->mysqli,$query) or die($query." : ".mysqli_error($this->mysqli));
		return $result;
	}
}

$html = new HTML("",-1);

    if ( isset($_GET['id']) ){
        $id = intval ($_GET['id']);
        
        $req = "SELECT id, type ,snapshot " . 
               "FROM mag_item_log WHERE id = " . $id;
        $ret = $html->query($req);
        $col = mysqli_fetch_row ($ret);
        
        if ( !$col[0] ){
            echo "Id d'image inconnu";
        } else {
            header ("Content-type: " . $col[1]);
            echo $col[2];
        }

    } else {
        echo "id d'image non defini";
    }

?>
