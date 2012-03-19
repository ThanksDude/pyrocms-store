<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CRON library
 * 
 * @author Antoine Benevaut
 * 
 * @package		OursITShow
 * @subpackage  PyroCMS-Store
 * @category  	Library
 *
 */

function end_date_cmp($a, $b){ 
    return strcmp($b['end_at'], $a['end_at']); 
}

class event {

  $name;
  $sleepTime;
  
  /**
   * name	= string
   * eventDate	= timestamp
   */
  public function __construct($name, $eventDate) {
    $this->name = $name;
    $sleepTime = strtotime(timespan(time(), $eventDate));
  }
}
 
class cron_like
{
	private	$event_stock;

	public function __construct() {
		$this->load->model('store/auctions_m');
	}

	public static function add_event($event) { 
		$this->manage_clock($event);
	} 

	private function manage_clock($event) {
		if ($event-> === "awake") {
			usort($this->event_stock, 'end_date_cmp');
			$this->manage_clock( (now() - $this->event_stock[0]['end_at']), $this->event_stock[0]['id']);
		}
		else {
		
		}
	}

	private function manage_clock($sleeping_time) {
		sleep($sleeping_time);
		
		
		
		$this->manage_clock("awake");
	}
}

/* End of file cron_like.php */