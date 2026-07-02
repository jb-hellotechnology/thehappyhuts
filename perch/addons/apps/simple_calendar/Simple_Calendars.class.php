<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
$stripe = new \Stripe\StripeClient(
  getenv('STRIPE_SECRET_KEY')
);

class Simple_Calendars extends PerchAPI_Factory
{
    protected $table     = 'simple_calendar';
	protected $pk        = 'simpleCalendarID';
	protected $singular_classname = 'Simple_Calendar';
	
	protected $default_sort_column = 'id';
	
	public $static_fields   = array();	
    
    public function getAccUnit($parent){
	    
	    if($parent==0){
	    	$sql = 'SELECT * FROM simple_calendar_accommodation_units ORDER BY name ASC';
	    }elseif($parent>0){
			$sql = 'SELECT * FROM simple_calendar_accommodation_units ORDER BY name ASC';    
	    }else{
		    $sql = 'SELECT * FROM simple_calendar_accommodation_units ORDER BY name ASC';  
	    }

		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function getAccSingleUnit($id){
	      
	    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE unitID='.$id;  
	    
		$data = $this->db->get_row($sql);

	    return $data;
	    
    }
    
    public function getAccUnits($id){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE typeID="'.$id.'" ORDER BY name ASC';
		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function unitAdd($data){
	    
	    $unit = array();
	    $unit['name'] = $data['name'];
	    $unit['slug'] = $data['slug'];

	    $insert = $this->db->insert('simple_calendar_accommodation_units', $unit);
	    
    }
    
    public function unitUpdate($data){
	    
	    $unit = array();
	    $unit['name'] = $data['name'];
	    $unit['slug'] = $data['slug'];
	    $unit['dogFriendly'] = $data['dogFriendly'];
	    $unit['enableCalendar'] = $data['enableCalendar'];

	    $insert = $this->db->update('simple_calendar_accommodation_units', $unit, 'unitID', $data['unitID']);
	    
    }
    
    public function unit($id,$object){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE unitID="'.$id.'"';
		  $data = $this->db->get_row($sql);

		  return $data;
    }
  
    public function unitbySlug($slug,$object){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE slug="'.$slug.'"';
	  	$data = $this->db->get_row($sql);

		  return $data;
    }
    
    public function unitSlug($slug){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE slug="'.$slug.'"';
		$data = $this->db->get_row($sql);

		return $data;
    }
    
    public function unitDelete($id){

	    $unitDelete = $this->db->delete('simple_calendar_accommodation_units', 'unitID', $id);
	    
    }
    
    public function unitPrice($data){
	    
	    $pricing = array();
	    $pricing['unitID'] = $data['unitID'];
	    // The pricing period now spans a whole calendar month: derive the first
	    // and last day from the submitted month + year.
	    $month = (int) $data['month'];
	    $year  = (int) $data['year'];
	    $pricing['startDate'] = sprintf('%04d-%02d-01', $year, $month);
	    $pricing['endDate']   = sprintf('%04d-%02d-%02d', $year, $month, (int) date('t', mktime(0, 0, 0, $month, 1, $year)));
/*
	    $pricing['freeText'] = $data['freeText'];
	    $pricing['minStay'] = $data['minStay'];
	    $pricing['changeOver'] = $data['changeOver'];
		$pricing['strict'] = $data['strict'];
		$pricing['discount'] = $data['discount'];
*/
	    $pricing['onenight'] = $data['onenight'];
	    $pricing['twonights'] = $data['twonights'];
/*
	    $pricing['threenights'] = $data['threenights'];
	    $pricing['fournights'] = $data['fournights'];
	    $pricing['fivenights'] = $data['fivenights'];
	    $pricing['sixnights'] = $data['sixnights'];
	    $pricing['sevennights'] = $data['sevennights'];
*/

	    // These legacy columns are NOT NULL with no default, so set them explicitly
	    // (empty / zero) — required under MySQL strict mode. The booking flow only
	    // uses the weekday (onenight) and weekend (twonights) prices; the rest are
	    // unused price tiers / changeover options.
	    $pricing['freeText']    = '';
	    $pricing['minStay']     = '0';
	    $pricing['changeOver']  = '';
	    $pricing['strict']      = '';
	    $pricing['discount']    = '';
	    $pricing['threenights'] = '0.00';
	    $pricing['fournights']  = '0.00';
	    $pricing['fivenights']  = '0.00';
	    $pricing['sixnights']   = '0.00';
	    $pricing['sevennights'] = '0.00';

	    $insert = $this->db->insert('simple_calendar_accommodation_unit_pricing', $pricing);
	    
    }
    
    public function updateunitPrice($data){
	    
	    $pricing = array();
	    // The pricing period now spans a whole calendar month: derive the first
	    // and last day from the submitted month + year.
	    $month = (int) $data['month'];
	    $year  = (int) $data['year'];
	    $pricing['startDate'] = sprintf('%04d-%02d-01', $year, $month);
	    $pricing['endDate']   = sprintf('%04d-%02d-%02d', $year, $month, (int) date('t', mktime(0, 0, 0, $month, 1, $year)));
/*
	    $pricing['freeText'] = $data['freeText'];
	    $pricing['minStay'] = $data['minStay'];
	    $pricing['changeOver'] = $data['changeOver'];
        $pricing['strict'] = $data['strict'];
	    $pricing['discount'] = $data['discount'];
*/
	    $pricing['onenight'] = $data['onenight'];
	    $pricing['twonights'] = $data['twonights'];
/*
	    $pricing['threenights'] = $data['threenights'];
	    $pricing['fournights'] = $data['fournights'];
	    $pricing['fivenights'] = $data['fivenights'];
	    $pricing['sixnights'] = $data['sixnights'];
	    $pricing['sevennights'] = $data['sevennights'];
*/

	    $insert = $this->db->update('simple_calendar_accommodation_unit_pricing', $pricing, 'pricingID', $data['pricingID']);
	    
    }
    
    public function getunitPricing($id){
	    
	    $today = date('Y-m-d');
	    $sql = 'SELECT * FROM simple_calendar_accommodation_unit_pricing WHERE unitID="'.$id.'" ORDER BY startDate ASC';
		  $data = $this->db->get_rows($sql);

	    return $data;
	    
    }
  
   public function getunitPriceRow($id){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_unit_pricing WHERE pricingID="'.$id.'"';
		  $data = $this->db->get_row($sql);
	    return $data;
	    
    }
    
    public function getunitPricingDate($date,$id){
	    
	    $today = date('Y-m-d');
	    $sql = 'SELECT * FROM simple_calendar_accommodation_unit_pricing WHERE unitID="'.$id.'" AND startDate<="'.$date.'" AND endDate>="'.$date.'"';
		  $data = $this->db->get_row($sql);

	    return $data;
	    
    }
    
    
    public function getunitPricing_Public($slug){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE slug="'.$slug.'"';
		$data = $this->db->get_rows($sql);
	    
	    $today = date('Y-m-d');
	    $sql = 'SELECT * FROM simple_calendar_accommodation_unit_pricing WHERE unitID="'.$data[0]['unitID'].'" ORDER BY startDate ASC';
		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function unitDeletePricing($id){

	    $unitPricingDelete = $this->db->delete('simple_calendar_accommodation_unit_pricing', 'pricingID', $id);
	    
    }
    
    public function getAddons(){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_addons ORDER BY name ASC';
		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function addonAdd($data){
	    
	    $addon = array();
	    $addon['name'] = $data['name'];
	    $addon['description'] = $data['description'];
	    $addon['price'] = $data['price'];

	    $insert = $this->db->insert('simple_calendar_accommodation_addons', $addon);
	    
    }
    
    public function addon($id){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_addons WHERE addonID='.$id;
		$data = $this->db->get_row($sql);

		return $data;
    }
    
    public function addonDelete($id){

	    $addonDelete = $this->db->delete('simple_calendar_accommodation_addons', 'addonID', $id);
	    
    }
    
    public function addonUpdate($data){
	    
	    $addon = array();
	    $addon['name'] = $data['name'];
	    $addon['description'] = $data['description'];
	    $addon['price'] = $data['price'];

	    $insert = $this->db->update('simple_calendar_accommodation_addons', $addon, 'addonID', $data['addonID']);
	    
    }
    
    public function allAvailableAccommodation($start,$end,$bookingSex){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_units ORDER BY name ASC';
		$data = $this->db->get_rows($sql);
		
		$list = array();
		
		foreach($data as $Accommodation){
			
			$count = $this->db->get_count('SELECT COUNT(*) FROM simple_calendar_accommodation_units WHERE parentID="'.$Accommodation['typeID'].'"');
			if($count==0){
				
				$sqlB = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE 
					(startTime<="'.$start.'" AND endTime>"'.$start.'" AND typeID="'.$Accommodation['typeID'].'") OR 
					(startTime<="'.$end.'" AND endTime>"'.$end.'" AND typeID="'.$Accommodation['typeID'].'") OR 
					(startTime<="'.$start.'" AND endTime>="'.$end.'" AND typeID="'.$Accommodation['typeID'].'") OR 
					(startTime>="'.$start.'" AND endTime<="'.$end.'" AND typeID="'.$Accommodation['typeID'].'") OR 
					(startTime="'.$start.'" AND endTime="'.$end.'" AND typeID="'.$Accommodation['typeID'].'")';  
				$dataB = $this->db->get_count($sqlB);
				
				if($dataB==0){
				
					if($Accommodation['parentID']>0){
						
						//GET ANY BOOKINGS OF THE SAME TYPE
						$sqlC = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE 
							(startTime="'.$start.'" AND endTime="'.$end.'" AND parentID="'.$Accommodation['parentID'].'" AND bookingSex<>"'.$bookingSex.'") OR 
							(startTime<"'.$start.'" AND endTime>"'.$end.'" AND parentID="'.$Accommodation['parentID'].'" AND bookingSex<>"'.$bookingSex.'") OR 
							(startTime<"'.$start.'" AND endTime>"'.$start.'" AND parentID="'.$Accommodation['parentID'].'" AND bookingSex<>"'.$bookingSex.'") OR 
							(startTime<"'.$end.'" AND endTime>"'.$end.'" AND parentID="'.$Accommodation['parentID'].'" AND bookingSex<>"'.$bookingSex.'")';  
						$dataC = $this->db->get_count($sqlC);
						
						if($dataC==0){
						
							$sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE typeID='.$Accommodation['parentID'];
							$parent = $this->db->get_row($sql);
							$list[] = array('name'=>"$parent[name] - $Accommodation[name]", 'typeID'=>$Accommodation['typeID']);
						
						}
					}else{
						$list[] = array('name'=>"$Accommodation[name]", 'typeID'=>$Accommodation['typeID']);	
					}
				
				}
			}
			
		}
		
		sort($list);

	    return $list;
	    
    }
    
    public function isAvailableAccommodation($start,$end,$typeID,$bookingID){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE typeID="'.$typeID.'"';
		$data = $this->db->get_rows($sql);
		
		foreach($data as $Accommodation){
				
			$sqlB = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE 
				(startTime<="'.$start.'" AND endTime>"'.$start.'" AND typeID="'.$Accommodation['typeID'].'" AND bookingID<>"'.$bookingID.'") OR 
				(startTime<="'.$end.'" AND endTime>"'.$end.'" AND typeID="'.$Accommodation['typeID'].'" AND bookingID<>"'.$bookingID.'") OR 
				(startTime<="'.$start.'" AND endTime>="'.$end.'" AND typeID="'.$Accommodation['typeID'].'" AND bookingID<>"'.$bookingID.'") OR 
				(startTime>="'.$start.'" AND endTime<="'.$end.'" AND typeID="'.$Accommodation['typeID'].'" AND bookingID<>"'.$bookingID.'") OR 
				(startTime="'.$start.'" AND endTime="'.$end.'" AND typeID="'.$Accommodation['typeID'].'" AND bookingID<>"'.$bookingID.'")';  
			$dataB = $this->db->get_count($sqlB);
			
			if($dataB==0){
				
				return 0;
			
			}else{
				
				return 1;
				
			}

		}
	    
    }
    
    public function bookingAdd($booking){

	    $booking = $this->fillRequiredBookingDefaults($booking);
	    $insert = $this->db->insert('simple_calendar_accommodation_bookings', $booking);

    }
    
    public function getBookings(){
	    
		$sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE reference="" OR reference is NULL ORDER BY bookingID ASC';

		$data = $this->db->get_rows($sql);

	    return $data;

    }

    // Sum confirmed-booking value per unit for a date range, grouped in SQL so it
    // stays fast as the bookings table grows. The range is matched against the
    // arrival time (startTime). Pending/expired holds are excluded the same way
    // getBookings() does (empty/NULL reference). Swap SUM(cost) for SUM(paid) to
    // report money actually received instead of gross booking value.
    public function getMonthlySalesByUnit($rangeStart,$rangeEnd){

		// For each booking: if it used a voucher, count the voucher's value (looked
		// up from simple_calendar_vouchers by the code(s) stored in the "voucher"
		// column, which may be comma-separated); otherwise count what was paid.
		$sql = 'SELECT b.unitID, COUNT(*) AS bookings,
					SUM(CASE
						WHEN b.voucher IS NOT NULL AND b.voucher != "" THEN
							(SELECT COALESCE(SUM(v.voucherValue), 0)
							   FROM simple_calendar_vouchers v
							  WHERE FIND_IN_SET(v.voucherCode, b.voucher))
						ELSE b.paid
					END) AS total
				FROM simple_calendar_accommodation_bookings b
				WHERE b.startTime >= "'.$rangeStart.'" AND b.startTime <= "'.$rangeEnd.'" AND (b.reference = "" OR b.reference IS NULL)
				GROUP BY b.unitID';

		$data = $this->db->get_rows($sql);

	    return $data;

    }
    
    public function getFutureBookings(){
	    
	    $date = date('Y-m-d H:i:s');
		$sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE startTime>="'.$date.'" ORDER BY startTime ASC';  
	   
		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function getBookingsReviews($date){
	    
		$sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE endTime="'.$date.' 10:00:00"';  
	   
		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function booking($bookingID){
	    
		$sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE bookingID='.$bookingID;  
	   
		$data = $this->db->get_row($sql);

	    return $data;
	    
    }
    
    public function findBooking($emailAddress,$startTime,$endTime,$unitID){
	    
		$sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE emailAddress="'.$emailAddress.'" AND startTime="'.$startTime.'" AND endTime="'.$endTime.'" AND unitID="'.$unitID.'"';  
	   
		$data = $this->db->get_row($sql);

	    return $data;
	    
    }
    
    public function groupBookings($bookingGroup){
	    
		$sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE bookingGroup="'.$bookingGroup.'"';  
	   
		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function bookingUpdate($data,$id){

		$update = $this->db->update('simple_calendar_accommodation_bookings', $data, 'bookingID', $id);
	    
    }
    
    public function bookingDelete($id){

	    $bookingDelete = $this->db->delete('simple_calendar_accommodation_bookings', 'bookingID', $id);
	    
    }
    
    public function getEmails(){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_emails ORDER BY subject ASC';
		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function getEmail($id){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_emails WHERE emailID="'.$id.'"';
		$data = $this->db->get_row($sql);

	    return $data;
	    
    }
    
    public function emailAdd($data){
	    
	    $email = array();
	    $email['subject'] = $data['subject'];
	    $email['content'] = $data['content'];
	    
	    $insert = $this->db->insert('simple_calendar_accommodation_emails', $email);
	    
    }
    
    public function emailUpdate($data){
	    
	    $email = array();
	    $email['subject'] = $data['subject'];
	    $email['content'] = $data['content'];
	    $id = $data['emailID'];
	    
	    $insert = $this->db->update('simple_calendar_accommodation_emails', $email, 'emailID', $id);
	    
    }
    
    public function emailDelete($data){
	    
	    $email = array();
	    $id = $data['emailID'];
	    
	    $insert = $this->db->delete('simple_calendar_accommodation_emails', 'emailID', $id);
	    
    }
    
    public function getCustomers(){
	    
	    $sql = 'SELECT * FROM perch3_members ORDER BY memberEmail ASC';
		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function customer($id){
	    
	    $sql = 'SELECT * FROM perch3_members WHERE memberID="'.$id.'"';
		$data = $this->db->get_row($sql);

	    return $data;
	    
    }
    
    public function createReview($review){
	    
	    $insert = $this->db->insert('simple_calendar_reviews', $review);
	    
    }
    
    public function getReviewData($reviewcode){
	    
	    $sql = 'SELECT * FROM simple_calendar_reviews WHERE reviewCode="'.$reviewcode.'"';
		$data = $this->db->get_row($sql);

	    return $data;
	    
    }
    
    public function getReview($reviewID){
	    
	    $sql = 'SELECT * FROM simple_calendar_reviews WHERE reviewID="'.$reviewID.'"';
		$data = $this->db->get_row($sql);

	    return $data;
	    
    }
    
     public function getReviews($unitID){
	    
	    $sql = 'SELECT * FROM simple_calendar_reviews WHERE unitID="'.$unitID.'" AND published="yes" ORDER BY timestamp DESC';
		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function logReview($review){
	    
	    $sql = 'UPDATE simple_calendar_reviews SET rating="'.$review['rating'].'", comments="'.$review['comments'].'", timestamp="'.$review['timestamp'].'" WHERE reviewCode="'.$review['reviewCode'].'"';
		$data = $this->db->execute($sql);

	    return $data;
	    
    }
    
    public function getAllReviews(){
	    
	    $sql = 'SELECT * FROM simple_calendar_reviews ORDER BY reviewID DESC';
		$data = $this->db->get_rows($sql);

	    return $data;
	    
    }
    
    public function deleteReview($id){
	    
	    $sql = 'DELETE FROM simple_calendar_reviews WHERE reviewID="'.$id.'"';
		$data = $this->db->execute($sql);
	    
    }
    
    public function updateReview($review){
	    
	    $sql = 'UPDATE simple_calendar_reviews SET rating="'.$review['rating'].'", comments="'.$review['comments'].'", published="'.$review['published'].'" WHERE reviewID="'.$review['reviewID'].'"';
		$data = $this->db->execute($sql);
	    
    }
    
    public function getNights($arrival,$departure){
		
		$diff = strtotime($departure) - strtotime($arrival);
		
		return $diff/86400;
		
    }
    
    public function getConflicts($arrival,$departure,$unitID){
	  
	    $sqlB = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE 
				(startTime<="'.$arrival.'" AND endTime>"'.$arrival.'" AND unitID="'.$unitID.'") OR 
				(startTime<="'.$departure.'" AND endTime>"'.$departure.'" AND unitID="'.$unitID.'") OR 
				(startTime<="'.$arrival.'" AND endTime>="'.$departure.'" AND unitID="'.$unitID.'") OR 
				(startTime>="'.$arrival.'" AND endTime<="'.$departure.'" AND unitID="'.$unitID.'") OR 
				(startTime="'.$arrival.'" AND endTime="'.$departure.'" AND unitID="'.$unitID.'")';  
		$conflicts = $this->db->get_count($sqlB);
		
		return $conflicts;
		
    }
    
    public function getConflictsB($arrival,$departure,$unitID,$bookingID){
	  
	    $sqlB = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE 
				(startTime<="'.$arrival.'" AND endTime>"'.$arrival.'" AND unitID="'.$unitID.'") AND bookingID<>"'.$bookingID.'" OR 
				(startTime<="'.$departure.'" AND endTime>"'.$departure.'" AND unitID="'.$unitID.'") AND bookingID<>"'.$bookingID.'"  OR 
				(startTime<="'.$arrival.'" AND endTime>="'.$departure.'" AND unitID="'.$unitID.'") AND bookingID<>"'.$bookingID.'"  OR 
				(startTime>="'.$arrival.'" AND endTime<="'.$departure.'" AND unitID="'.$unitID.'") AND bookingID<>"'.$bookingID.'"  OR 
				(startTime="'.$arrival.'" AND endTime="'.$departure.'" AND unitID="'.$unitID.'") AND bookingID<>"'.$bookingID.'"';  
		$conflicts = $this->db->get_count($sqlB);
		
		return $conflicts;
		
    }
    
    public function getConflictsC($arrival,$departure,$unitID,$reference){
	  
	    $sqlB = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE 
				(startTime<="'.$arrival.'" AND endTime>"'.$arrival.'" AND unitID="'.$unitID.'") AND reference<>"'.$reference.'" OR 
				(startTime<="'.$departure.'" AND endTime>"'.$departure.'" AND unitID="'.$unitID.'") AND reference<>"'.$reference.'"  OR 
				(startTime<="'.$arrival.'" AND endTime>="'.$departure.'" AND unitID="'.$unitID.'") AND reference<>"'.$reference.'"  OR 
				(startTime>="'.$arrival.'" AND endTime<="'.$departure.'" AND unitID="'.$unitID.'") AND reference<>"'.$reference.'"  OR 
				(startTime="'.$arrival.'" AND endTime="'.$departure.'" AND unitID="'.$unitID.'") AND reference<>"'.$reference.'"';  
		$conflicts = $this->db->get_count($sqlB);
		return $conflicts;
		
    }
    
    public function bookingCheck($unit,$date){
	    
	    $sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE unitID="'.$unit.'" AND startTime<="'.$date.' 23:59:00" AND endTime>="'.$date.' 12:00:00"';
		$rows = $this->db->get_count($sql);

		return $rows;

    }

    // Fetch every booking that overlaps a date range for one unit in a single
    // query, so the caller can test many days in PHP instead of one query per day.
    public function bookingsForUnitInRange($unitID,$rangeStart,$rangeEnd){

	    $sql = 'SELECT startTime, endTime FROM simple_calendar_accommodation_bookings WHERE unitID="'.$unitID.'" AND startTime<="'.$rangeEnd.'" AND endTime>="'.$rangeStart.'"';
		$data = $this->db->get_rows($sql);

		return $data;

    }
  
  public function isArrival($slug,$date){

    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE slug="'.$slug.'"';
	$data = $this->db->get_rows($sql);

	$sql = 'SELECT * FROM simple_calendar_accommodation_unit_pricing WHERE startDate<="'.$date.'" AND endDate>="'.$date.'" AND unitID="'.$data[0]['unitID'].'" ORDER BY startDate ASC';
	$data = $this->db->get_rows($sql);
    
    if(date('Y-m-d')<'2019-11-25'){
      $today = '2019-11-25';
    }else{
      $today = date('Y-m-d');
    }
    
    $dates = explode("-",$date);
    $day = date("D", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));

    $sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE unitID="'.$data[0]['unitID'].'" AND startTime>="'.$date.'" ORDER BY startTime ASC LIMIT 1';
	$bookingData = $this->db->get_rows($sql);
    $arrDates = explode(" ",$bookingData[0]['startTime']);
    $nextArrival = $arrDates[0];
    $nights = 0 - ((strtotime($date) - strtotime($nextArrival)) / 86400);
    $nights++;
    
    if($nights<0){
      $nights = 14;
    }

	if($data[0]['changeOver']=='Any Day' AND $date>$today AND $nights>$data[0]['minStay']){
      return 1;
    }elseif($data[0]['changeOver']=='Sat - Sat' AND $day=='Sat' AND $date>$today AND $nights>$data[0]['minStay']){
      return 1;
    }elseif($data[0]['changeOver']=='Fri - Fri' AND $day=='Fri' AND $date>$today AND $nights>$data[0]['minStay']){
      return 1;
    }elseif($data[0]['changeOver']=='Fri/Mon' AND ($day=='Fri' OR $day=='Mon') AND $date>$today AND $nights>$data[0]['minStay']){
      return 1;
    }elseif($data[0]['changeOver']=='Sat/Tue' AND ($day=='Sat' OR $day=='Tue') AND $date>$today AND $nights>$data[0]['minStay']){
      return 1;
    }
    
  }
  
  public function getMaxNights($unit,$date){

    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE slug="'.$unit.'"';
	$data = $this->db->get_rows($sql);
	
    $sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE unitID="'.$data[0]['unitID'].'" AND startTime>="'.$date.'" ORDER BY startTime ASC LIMIT 1';
	$bookingData = $this->db->get_rows($sql);
    
    $arrDates = explode(" ",$bookingData[0]['startTime']);
    $nextArrival = $arrDates[0];
    $nights = 0 - ((strtotime($date) - strtotime($nextArrival)) / 86400);
    
	$dates = explode("-", $date);
	$month = $dates[1];
	$month = strtolower(date("F", mktime(0, 0, 0, $dates[1], 10)));
	$day = strtolower(date("l", mktime(0, 0, 0, $dates[1], $dates[2])));
	
	$sql = "SELECT * FROM simple_calendar_availability WHERE availabilityID='1'";
	$availabilityData = $this->db->get_row($sql);
	$availability = $availabilityData[$month];
	
	if($availability=='weekends'){
		
		
		if($nights>2){
			if($day == 'saturday'){
				$nights = 2;
			}elseif($day == 'sunday'){
				$nights = 1;
			}
		}
		
	}else{
    
	    if($nights<0){
	      $nights = 14;
		}
    
    }
    
    return $nights;
    
  }
  
  public function getMinNights($unit,$date){

    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE slug="'.$unit.'"';
		$data = $this->db->get_rows($sql);
    
    $sql = 'SELECT * FROM simple_calendar_accommodation_unit_pricing WHERE startDate<="'.$date.'" AND endDate>="'.$date.'" AND unitID="'.$data[0]['unitID'].'" ORDER BY startDate ASC';
		$data = $this->db->get_rows($sql);
    
    $nights = $data[0]['minStay'];
    
    return $nights;
    
  }
  
  public function getMaxOccupants($unit){

    $sql = 'SELECT * FROM simple_calendar_accommodation_units WHERE slug="'.$unit.'"';
		$data = $this->db->get_rows($sql);
    
    return $data[0]['maxOccupants'];
    
  }
  
  public function makeBooking($startTime,$endTime,$unitID,$firstName,$lastName,$email,$phone,$cost,$paid){
      $booking = array();
	  $booking['startTime'] = $startTime;
      $booking['endTime'] = $endTime;
      $booking['unitID'] = $unitID;
      $booking['firstName'] = $firstName;
      $booking['lastName'] = $lastName;
      $booking['emailAddress'] = $email;
      $booking['phone'] = $phone;
      $booking['cost'] = $cost;
      $booking['paid'] = $paid;

	  $booking = $this->fillRequiredBookingDefaults($booking);
	  $insert = $this->db->insert('simple_calendar_accommodation_bookings', $booking);
  }
  
   public function progressBooking($startTime,$endTime,$unitID,$firstName,$lastName,$email,$phone,$cost,$paid,$reference){
	   if($reference<>''){
	   	$this->db->execute('UPDATE simple_calendar_accommodation_bookings SET firstName="'.$firstName.'", lastName="'.$lastName.'", emailAddress="'.$email.'", phone="'.$phone.'", cost="'.$cost.'" WHERE reference="'.$reference.'"');
	  }
  }
  
  public function completeBooking($startTime,$endTime,$unitID,$firstName,$lastName,$email,$phone,$cost,$paid,$reference){
	  if($reference<>''){
	  $this->db->execute('UPDATE simple_calendar_accommodation_bookings SET firstName="'.$firstName.'", lastName="'.$lastName.'", emailAddress="'.$email.'", phone="'.$phone.'", cost="'.$cost.'", paid="'.$paid.'", expires="0000-00-00 00:00:00", reference="" WHERE reference="'.$reference.'"');
	  }
  }
  
  public function completeBookingStripeWebhook($checkoutSession,$paid){
	  if($checkoutSession<>''){
		$sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE checkoutSession="'.$checkoutSession.'"';
		$data = $this->db->get_row($sql);
	  	$this->db->execute('UPDATE simple_calendar_accommodation_bookings SET paid="'.$paid.'", expires="0000-00-00 00:00:00", reference="" WHERE checkoutSession="'.$checkoutSession.'"');
	  }
  }
  
  public function completeBookingBarclays($reference,$paid){
	  if($reference<>''){
	  	$this->db->execute('UPDATE simple_calendar_accommodation_bookings SET paid="'.$paid.'", expires="0000-00-00 00:00:00", reference="" WHERE reference="'.$reference.'"');
	  }
  }
  
  public function tempBooking($startTime,$endTime,$unitID,$cost){
      $booking = array();
	  $booking['startTime'] = $startTime;
      $booking['endTime'] = $endTime;
      $booking['unitID'] = $unitID;
      $booking['cost'] = $cost;
		
	  $booking['reference'] = uniqid();
	  $booking['expires'] = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s')+230, date('m'), date('d'), date('Y')));

	  // Strict mode rejects an INSERT that omits NOT NULL columns without a default.
	  // Fill any such columns with type-appropriate empty values before inserting.
	  $booking = $this->fillRequiredBookingDefaults($booking);

	  $insert = $this->db->insert('simple_calendar_accommodation_bookings', $booking);
	  
	  return $booking['reference'];
  }

  // Returns $booking with type-appropriate empty values added for every NOT NULL
  // column on the bookings table that has no default and isn't already set, so
  // partial inserts (e.g. hold bookings) succeed under MySQL strict mode. This
  // mirrors what non-strict MySQL did implicitly.
  public function fillRequiredBookingDefaults($booking){
	  $cols = $this->db->get_rows("SHOW COLUMNS FROM simple_calendar_accommodation_bookings");
	  if(!is_array($cols)) return $booking;
	  foreach($cols as $col){
		  $field = $col['Field'];
		  if(array_key_exists($field, $booking)) continue;   // already provided
		  if($col['Extra']=='auto_increment')    continue;   // primary key
		  if($col['Null']=='YES')                continue;   // nullable, can be omitted
		  if($col['Default']!==null)             continue;   // has a default, can be omitted
		  // NOT NULL, no default, not set: pick a safe empty value by column type.
		  $type = strtolower($col['Type']);
		  if(strpos($type,'int')!==false || strpos($type,'decimal')!==false || strpos($type,'float')!==false || strpos($type,'double')!==false){
			  $booking[$field] = 0;
		  }elseif(strpos($type,'datetime')!==false || strpos($type,'timestamp')!==false || strpos($type,'date')!==false){
			  $booking[$field] = '0000-00-00 00:00:00';
		  }elseif(strpos($type,'time')!==false){
			  $booking[$field] = '00:00:00';
		  }else{
			  $booking[$field] = '';
		  }
	  }
	  return $booking;
  }
  
  public function getLastBooking(){
    $sql = 'SELECT * FROM simple_calendar_accommodation_bookings ORDER BY bookingID DESC LIMIT 1';
		$data = $this->db->get_row($sql);

	  return $data;
  }
  
  public function giftvoucher($id){
	  $sql = 'SELECT * FROM simple_calendar_vouchers WHERE voucherID='.$id;
	  $data = $this->db->get_row($sql);

	  return $data;
  }
  
  public function getVouchers(){
	  $sql = 'SELECT * FROM simple_calendar_vouchers ORDER BY createdDate DESC';
	  $data = $this->db->get_rows($sql);

	  return $data;
  }
  
  public function voucherAdd($data){
	  $units = $this->voucherUnitsFromInput($data);
	  // Provide the NOT NULL columns that have no DB default so the INSERT works
	  // under MySQL strict mode. '0000-00-00 00:00:00' is the "not yet used"
	  // sentinel the rest of the app checks usedDate against.
	  $createdDate = date('Y-m-d H:i:s');
	  $sql = 'INSERT INTO simple_calendar_vouchers (voucherCode, voucherValue, units, createdDate, usedDate, usedBy) VALUES ("'.$data['voucherCode'].'", "'.$data['voucherValue'].'", "'.$units.'", "'.$createdDate.'", "0000-00-00 00:00:00", "")';
	  $data = $this->db->execute($sql);

	  return $data;
  }
  
  public function getVoucher($code){
	  $sql = 'SELECT * FROM simple_calendar_vouchers WHERE voucherCode="'.$code.'"';
	  $data = $this->db->get_row($sql);

	  return $data;
  }
  
  public function voucherUpdate($data){
	  $units = $this->voucherUnitsFromInput($data);
	  $sql = 'UPDATE simple_calendar_vouchers SET voucherValue="'.$data['voucherValue'].'", voucherCode="'.$data['voucherCode'].'", units="'.$units.'" WHERE voucherID="'.$data['voucherID'].'"';
	  $data = $this->db->execute($sql);
  }

  // Build the stored "units" value from a submitted voucher form: 'all' when no
  // specific huts are ticked, otherwise a comma-separated list of unit IDs.
  public function voucherUnitsFromInput($data){
	  if(isset($data['units']) && is_array($data['units']) && count($data['units'])>0){
		  $ids = array();
		  foreach($data['units'] as $u){ $ids[] = (int)$u; }
		  return implode(',', $ids);
	  }
	  return 'all';
  }

  // Ensure the vouchers table has the "units" column this feature relies on.
  // Safe to call repeatedly; it only alters the table the first time.
  public function ensureVoucherUnitsColumn(){
	  $exists = $this->db->get_row("SHOW COLUMNS FROM simple_calendar_vouchers LIKE 'units'");
	  if(!$exists){
		  $this->db->execute("ALTER TABLE simple_calendar_vouchers ADD units VARCHAR(255) NOT NULL DEFAULT 'all'");
	  }
  }

  /* ===== Promotional Codes =====================================================
     Reusable percentage discounts (e.g. WELCOME10 = 10% off), separate from the
     single-use £ gift vouchers. A code runs until deleted and can be used by any
     number of customers. Like vouchers, it applies to 'all' huts or a specific
     comma-separated list of unit IDs (reusing voucherUnitsFromInput()).
  ============================================================================= */

  // Create the promo-codes table and the bookings.promoCode column if missing.
  // Safe to call repeatedly.
  public function ensurePromoSchema(){
	  $this->db->execute("CREATE TABLE IF NOT EXISTS simple_calendar_promocodes (promoID INT NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL DEFAULT '', percentage DECIMAL(5,2) NOT NULL DEFAULT '0.00', units VARCHAR(255) NOT NULL DEFAULT 'all', createdDate DATETIME NULL DEFAULT NULL, PRIMARY KEY (promoID))");
	  $exists = $this->db->get_row("SHOW COLUMNS FROM simple_calendar_accommodation_bookings LIKE 'promoCode'");
	  if(!$exists){
		  $this->db->execute("ALTER TABLE simple_calendar_accommodation_bookings ADD promoCode VARCHAR(255) NOT NULL DEFAULT ''");
	  }
  }

  public function getPromos(){
	  return $this->db->get_rows('SELECT * FROM simple_calendar_promocodes ORDER BY createdDate DESC');
  }

  public function getPromo($id){
	  return $this->db->get_row('SELECT * FROM simple_calendar_promocodes WHERE promoID="'.(int)$id.'"');
  }

  public function getPromoByCode($code){
	  $code = addslashes($code);
	  return $this->db->get_row('SELECT * FROM simple_calendar_promocodes WHERE name="'.$code.'"');
  }

  public function promoAdd($data){
	  $promo = array();
	  $promo['name']        = $data['name'];
	  $promo['percentage']  = (float) $data['percentage'];
	  $promo['units']       = $this->voucherUnitsFromInput($data);
	  $promo['createdDate'] = date('Y-m-d H:i:s');
	  $this->db->insert('simple_calendar_promocodes', $promo);
  }

  public function promoUpdate($data){
	  $promo = array();
	  $promo['name']       = $data['name'];
	  $promo['percentage'] = (float) $data['percentage'];
	  $promo['units']      = $this->voucherUnitsFromInput($data);
	  $this->db->update('simple_calendar_promocodes', $promo, 'promoID', $data['promoID']);
  }

  public function promoDelete($id){
	  $this->db->execute('DELETE FROM simple_calendar_promocodes WHERE promoID="'.(int)$id.'"');
  }

  // Record which promo code was applied to a booking (for the owner's records).
  public function applyPromoToBooking($code, $reference){
	  $booking = array();
	  $booking['promoCode'] = $code;
	  $this->db->update('simple_calendar_accommodation_bookings', $booking, 'reference', $reference);
  }
  
  public function voucherDelete($id){
	  $sql = 'DELETE FROM simple_calendar_vouchers WHERE voucherID='.$id; 
	  $data = $this->db->execute($sql);
  }
  
  public function applyVoucher($voucher,$reference){
	  
	  $vouchers = implode(",", $voucher);
	  $sql = 'UPDATE simple_calendar_accommodation_bookings SET notes="Voucher Used: '.$vouchers.'", voucher="'.$vouchers.'" WHERE reference="'.$reference.'"';
	  //mail('jack@jackbarber.co.uk','test',$sql);
	  $data = $this->db->execute($sql);
	  
  }
  
  public function useVoucher($code,$email,$balance){
	  if($balance==0){
	  	$date = date('Y-m-d H:i:s');
	  }else{
	  	// Partial use: a balance remains, so keep the voucher usable by leaving
	  	// usedDate as the "unused" sentinel. (An empty string here is rejected
	  	// under MySQL strict mode, which silently broke the whole UPDATE.)
	  	$date = '0000-00-00 00:00:00';
	  }
	  $sql = 'UPDATE simple_calendar_vouchers SET voucherValue="'.$balance.'", usedDate="'.$date.'", usedBy="'.$email.'" WHERE voucherCode="'.$code.'"';
	  $data = $this->db->execute($sql);
  }
  
  public function tomorrowArrivals(){
	  $date = date("Y-m-d", mktime(0, 0, 0, date('m'), date('d')+1, date('Y')));
	  $arrival = $date." 09:30:00";
	  $sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE startTime="'.$arrival.'"';
	  $data = $this->db->get_rows($sql);
	  return $data;
  }
  
  public function todayArrivals(){
	  $date = date("Y-m-d");
	  $arrival = $date." 09:30:00";
	  $sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE startTime="'.$arrival.'"';
	  $data = $this->db->get_rows($sql);
	  return $data;
  }
  
  public function deleteExpiredBookings(){
	  global $stripe;
	  $time = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s')+10, date('m'), date('d'), date('Y')));
	  $sql = 'SELECT * FROM simple_calendar_accommodation_bookings WHERE reference<>"" AND expires<="'.$time.'" AND expires<>"0000-00-00 00:00:00"';
	  $data = $this->db->get_rows($sql);
	  foreach($data as $booking){
		if($booking['checkoutSession']){
			//$booking['checkoutSession'];
			$session = $stripe->checkout->sessions->retrieve(
			  $booking['checkoutSession'],
			  []
			);
			if($session->status == 'open'){
				$session = $stripe->checkout->sessions->expire(
				  $booking['checkoutSession'],
				  []
				);	
			};
		}
		$sql = 'DELETE FROM simple_calendar_accommodation_bookings WHERE bookingID="'.$booking['bookingID'].'"';
		$data = $this->db->execute($sql); 
	  }
  }
  
  public function setSecret($reference,$secret){
	  $sql = 'UPDATE simple_calendar_accommodation_bookings SET clientSecret="'.$secret.'" WHERE reference="'.$reference.'"';
	  if($secret<>''){
	  	//mail('jack@jackbarber.co.uk','test',$sql);
	  }
	  $data = $this->db->execute($sql);
  }
  
  public function checkBookingExists($first_name,$last_name,$email,$telephone,$arrival,$departure,$unitID,$amount){
	  $sql = "SELECT * FROM simple_calendar_accommodation_bookings WHERE emailAddress='$email' AND startTime='$arrival' AND endTime='$endTime' AND unitID='$unitID' AND (expires is NULL OR expires='0000-00-00 00:00:00')";
	  $data = $this->db->get_row($sql);
	  if(count($data)==1){
		  //mail('jack@jackbarber.co.uk','Booking Exists', 'No need to add booking - in database already');
	  }else{
		  $sql = "INSERT INTO simple_calendar_accommodation_bookings (firstName, lastName, emailAddress, phone, startTime, endTime, unitID, cost, paid) VALUES ('$first_name', '$last_name', '$email', '$telephone', '$arrival', '$departure', '$unitID', '$cost', '$paid')";
		  $data = $this->db->execute($sql);
		  //mail('jack@jackbarber.co.uk','Booking Added', $sql);
	  }
  }
  
  public function getAvailability(){
	  $sql = "SELECT * FROM simple_calendar_availability WHERE availabilityID='1'";
	  $data = $this->db->get_row($sql);
	  return $data;
  }
  
  public function getAvailabilityMonth($month){
	  $sql = "SELECT $month FROM simple_calendar_availability WHERE availabilityID='1'";
	  $data = $this->db->get_row($sql);
	  return $data[$month];
  }
  
  public function updateAvailability($data){
	  $sql = "UPDATE simple_calendar_availability SET january='$data[january]', february='$data[february]', march='$data[march]', april='$data[april]', may='$data[may]', june='$data[june]', july='$data[july]', august='$data[august]', september='$data[september]', october='$data[october]', november='$data[november]', december='$data[december]' WHERE availabilityID='1'";
	  $this->db->execute($sql);
  }
  
  public function getByReference($reference){
	  $sql = "SELECT * FROM simple_calendar_accommodation_bookings WHERE reference='".$reference."'";
	  $data = $this->db->get_row($sql);
	  return $data;
  }
  
  public function getByIntent($paymentIntent){
	  $sql = "SELECT * FROM simple_calendar_accommodation_bookings WHERE paymentIntent='".$paymentIntent."'";
	  $data = $this->db->get_row($sql);
	  return $data;
  }
  
  public function getByCheckoutSession($checkoutSession){
	  $sql = "SELECT * FROM simple_calendar_accommodation_bookings WHERE checkoutSession='".$checkoutSession."'";
	  $data = $this->db->get_row($sql);
	  return $data;
  }
  
  public function storeSession($reference,$first_name,$last_name,$email_address,$phone,$cost,$session_id,$payment_intent){
	  $sql = "UPDATE simple_calendar_accommodation_bookings SET checkoutSession='$session_id', paymentIntent='$payment_intent', firstName='$first_name', lastName='$last_name', emailAddress='$email_address', phone='$phone', cost='$cost' WHERE reference='$reference'";
	  echo $sql;
	  $data = $this->db->execute($sql);
  }
    
}
