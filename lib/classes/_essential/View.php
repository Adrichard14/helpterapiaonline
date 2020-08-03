<?php
	class View {
		private $ID;
		private $table;
		private $elementID;
		private $count;
		private $date; //day, month and year.
		
		public $PUBLIC_VARS = array('ID', 'table', 'elementID', 'count', 'date');
		public static $DATABASE = "view_log";
		public static $VIEW_SESSION = "PageViewer";
		public static $VIEWS_DATABASE = "page_views";
		public static $ONLINE_DATABASE = "page_online";
		
		public function __construct($ID, $table, $elementID, $count, $date) { foreach($this->PUBLIC_VARS as $var) $this->{$var} = $$var; }
		public function get($var) { return $this->{$var}; }
		
		public static function load($ID = -1, $limit = NULL, $orderby = "date DESC", $table = NULL, $year = -1, $month = -1, $day = -1, $elementID = -1, $mindate = NULL, $maxdate = NULL) {
			$con = new Connector();
			$hasParam = $ID != -1 || $table != NULL || $year != -1 || $month != -1 || $day != -1 || $elementID != -1 || $mindate != NULL | $maxdate != NULL;
			$where = $hasParam ? " WHERE" : "";
			$limit = $limit != NULL ? " LIMIT ".$limit : "";
			$orderby = $orderby != NULL ? " ORDER BY ".$orderby : "";
			$args[0] = ""; $before = false;
			if($ID != -1) {
				$where.=" ID=?";
				$args[0].="i";
				$args[] = intval($ID);
				$before = true;
			}
			if($table != NULL) {
				$and = $before ? " AND" : "";
				$where.=$and." `table`=?";
				$args[0].="s";
				$args[] = $table."";
				$before = true;
			}
			if($year != -1) {
				$and = $before ? " AND" : "";
				$where.=$and." DATEPART(year, `date`)=?";
				$args[0].="i";
				$args[] = intval($year);
				$before = true;
			}
			if($month != -1) {
				$and = $before ? " AND" : "";
				$where.=$and." DATEPART(month, `date`)=?";
				$args[0].="i";
				$args[] = intval($month);
				$before = true;
			}
			if($day != -1) {
				$and = $before ? " AND" : "";
				$where.=$and." DATEPART(day, `date`)=?";
				$args[0].="i";
				$args[] = intval($day);
				$before = true;
			}
			if($elementID != -1) {
				$and = $before ? " AND" : "";
				$where.=$and." elementID=?";
				$args[0].="i";
				$args[] = intval($elementID);
				$before = true;
			}
			if($mindate != NULL) {
				$and = $before ? " AND" : "";
				$where.=$and." `date`>=?";
				$args[0].="s";
				$args[] = $mindate."";
				$before = true;
			}
			if($maxdate != NULL) {
				$and = $before ? " AND" : "";
				$where.=$and." `date`<=?";
				$args[0].="s";
				$args[] = $maxdate."";
			}
			$result = $con->query("SELECT `ID`, `table`, `elementID`, `count`, `date` FROM `".View::$DATABASE."`".$where.$orderby.$limit, $hasParam ? $args : NULL);
			if(sizeof($result) == 1 && $ID != -1) {
				$view = $result[0];
				$result = new View($view["ID"], $view["table"], $view["elementID"], $view["count"], $view["date"]);
			}
			return $result;
		}
		
		public static function getViews($table = NULL, $year = -1, $month = -1, $day = -1, $elementID = -1, $mindate = NULL, $maxdate = NULL) {
			$con = new Connector();
			$hasParam = $table != NULL || $year != -1 || $month != -1 || $day != -1 || $elementID != -1 || $mindate != NULL | $maxdate != NULL;
			$where = $hasParam ? " WHERE" : "";
			$args[0] = ""; $before = false;
			if($table != NULL) {
				$where.=" `table`=?";
				$args[0].="s";
				$args[] = $table."";
				$before = true;
			}
			if($year != -1) {
				$and = $before ? " AND" : "";
				$where.=$and." YEAR(`date`)=?";
				$args[0].="i";
				$args[] = intval($year);
				$before = true;
			}
			if($month != -1) {
				$and = $before ? " AND" : "";
				$where.=$and." MONTH(`date`)=?";
				$args[0].="i";
				$args[] = intval($month);
				$before = true;
			}
			if($day != -1) {
				$and = $before ? " AND" : "";
				$where.=$and." DAY(`date`)=?";
				$args[0].="i";
				$args[] = intval($day);
				$before = true;
			}
			if($elementID != -1) {
				$and = $before ? " AND" : "";
				$where.=$and." elementID=?";
				$args[0].="i";
				$args[] = intval($elementID);
				$before = true;
			}
			if($mindate != NULL) {
				$and = $before ? " AND" : "";
				$where.=$and." `date`>=?";
				$args[0].="s";
				$args[] = $mindate."";
				$before = true;
			}
			if($maxdate != NULL) {
				$and = $before ? " AND" : "";
				$where.=$and." `date`<=?";
				$args[0].="s";
				$args[] = $maxdate."";
			}
			$result = $con->query("SELECT SUM(`count`) AS views FROM `".View::$DATABASE."`".$where, $hasParam ? $args : NULL);
			return empty($result) ? 0 : intval($result[0]["views"]);
		}
		
		public static function create($table, $elementID) {
			$con = new Connector();
			$exists = sizeof($con->query(
				"SELECT ID FROM `".View::$DATABASE."` WHERE `date`=CURDATE() AND `table`=? AND `elementID`=?",
				array("si", $table."", intval($elementID))
			)) > 0;
			if(!$exists) {
				$result = $con->query(
					"INSERT INTO `".View::$DATABASE."` (`date`, `table`, `elementID`) VALUES (CURDATE(), ?, ?)",
					array("si", $table."", intval($elementID)),
					false
				);
			}
			return isset($result) && $result;
		}
		
		public static function view($table = NULL, $elementID = 0, $times = 2) {
			if(!isset($_SESSION)) session_start();
			$con = new Connector();
			$times = $times*60;
			$month = intval(date('m'));
			$year = intval(date('Y'));
			$visit = isset($_SESSION[View::$VIEW_SESSION]);
			//--------------------------------------------------USERS ONLINE TEST
			if($visit) {
				$result = $con->query(
					"SELECT time_end FROM `".View::$ONLINE_DATABASE."` WHERE session=? AND IP=?",
					array("ss", $_SESSION[View::$VIEW_SESSION]['session']."", $_SERVER['REMOTE_ADDR']."")
				);
				$exists = sizeof($result) > 0;
				$time_end = $exists ? $result[0]["time_end"] : NULL;
			} else $exists = false;
			if(!$exists){ //regist a new session
				//--------------------------------------------------USERS ONLINE
				$_SESSION[View::$VIEW_SESSION]['session'] = session_id();
				$time_end = time() + $times;
				$con->query(
					"INSERT INTO `".View::$ONLINE_DATABASE."` (session, IP, URL, time_end) VALUES (?, ?, ?, ?)",
					array("sssi", $_SESSION[View::$VIEW_SESSION]['session']."", $_SERVER['REMOTE_ADDR']."", $_SERVER['REQUEST_URI']."", intval($time_end)),
					false
				);
				//--------------------------------------------------SITE STATISTIC
				$visit = $visit ? "" : ", visits=visits+1";
				$args = array("ii", intval($month), intval($year));
				$values = $con->query(
					"SELECT * FROM `".View::$VIEWS_DATABASE."` WHERE month=? AND year=?",
					$args
				);
				if(empty($values)) {
					$con->query(
						"INSERT INTO `".View::$VIEWS_DATABASE."` (month, year) VALUES (?, ?)",
						$args,
						false
					);
				} else {
					$con->query(
						"UPDATE `".View::$VIEWS_DATABASE."` SET pageviews=pageviews+1".$visit." WHERE month=? AND year=?",
						$args,
						false
					);
				}
			} else { //update current session time_end and URL info
				//--------------------------------------------------USERS ONLINE
				$time_end = time() + $times;
				$con->query(
					"UPDATE `".View::$ONLINE_DATABASE."` SET time_end=?, URL=? WHERE session=?",
					array("iss", intval($time_end), $_SERVER['REQUEST_URI']."", $_SESSION[View::$VIEW_SESSION]['session'].""),
					false
				);
				//--------------------------------------------------SITE STATISTIC
				$updated = $con->query(
					"UPDATE `".View::$VIEWS_DATABASE."` SET pageviews=pageviews+1 WHERE month=? AND year=?",
					array("ii", intval($month), intval($year)),
					false
				);
			}
			//--------------------------------------------------KILL "USERS OFFLINE" DATA
			$time = time();
			$con->query(
				"DELETE FROM `".View::$ONLINE_DATABASE."` WHERE time_end <= ?",
				array("i", intval($time)),
				false
			);
			//--------------------------------------------------ELEMENT STATISTIC
			if($table != NULL) {
				$args = array("si", $table."", intval($elementID));
				$values = $con->query(
					"SELECT ID FROM `".View::$DATABASE."` WHERE `table`=? AND `elementID`=? AND `date`=CURDATE()",
					$args
				);
				if(empty($values)) $updated = View::create($table, $elementID);
				else $updated = $con->query("UPDATE `".View::$DATABASE."` SET count=count+1 WHERE `table`=? AND `elementID`=? AND `date`=CURDATE()", $args, false);
			}
			return $updated;
		}
		
		public static function delete($targetID, $targetName = "ID", $targetType = "i") {
			$con = new Connector();
			return $con->query(
				"DELETE FROM `".View::$DATABASE."` WHERE ".$targetName."=?",
				array($targetType."", intval($targetID)),
				false
			);
		}
		
		public static function OnlineGuests() {
			$con = new Connector();
			$time = time();
			return $con->query(
				"SELECT ID, session, IP, URL, time_end FROM `".View::$ONLINE_DATABASE."` WHERE time_end > ?",
				array("i", intval($time))
			);
		}
		
		public static function pageViews($month = -1, $year = -1) {
			$con = new Connector();
			$hasParam = $month != -1 || $year != -1;
			$where = $hasParam ? " WHERE" : "";
			$args[0] = ""; $and = ""; $before = false;
			if($month != -1) {
				if(!is_array($month)) {
					$where.=" month=?";
					$args[0].="i";
					$args[] = intval($month);
					$before = true;
				} else {
					if(isset($month['min'])) {
						$where.=" month>=?";
						$args[0].="i";
						$args[] = intval($month['min']);
						$and = " AND";
					}
					if(isset($month['max'])) {
						$where.=$and." month<=?";
						$args[0].="i";
						$args[] = intval($month['max']);
						$and = " AND";
					}
					$where.=$and." (";
					$before = false;
					foreach($month as $index => $m) {
						if($index != "min" && $index != "max") {
							$or = $before ? " OR" : "";
							$where.=$or." month=?";
							$args[0].="i";
							$args[] = intval($m);
							$before = true;
						}
					}
					$before = true;
					$where.=")";
				}
			}
			if($year != -1) {
				$and = $before ? " AND" : "";
				if(!is_array($year)) {
					$where.=$and." year=?";
					$args[0].="i";
					$args[] = intval($year);
				} else {
					if(isset($year['min'])) {
						$where.=" year>=?";
						$args[0].="i";
						$args[] = intval($year['min']);
						$and = " AND";
					}
					if(isset($year['max'])) {
						$where.=$and." year<=?";
						$args[0].="i";
						$args[] = intval($year['max']);
						$and = " AND";
					}
					$where.=$and." (";
					$before = false;
					foreach($year as $index => $y) {
						if($index != "min" && $index != "max") {
							$or = $before ? " OR" : "";
							$where.=$or." year=?";
							$args[0].="i";
							$args[] = intval($y);
							$before = true;
						}
					}
					$before = true;
					$where.=")";
				}
			}
			return $con->query(
				"SELECT visits, pageviews FROM `".View::$VIEWS_DATABASE."`".$where,
				$hasParam ? $args : NULL
			);
		}
	}
?>