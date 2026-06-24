<?php

	// Define subnav links and titles
	
	PerchUI::set_subnav([
        [
            'page' => 'simple_calendar/accommodation',
            'label'=> 'Accommodation'
        ],
        [
            'page' => 'simple_calendar/bookings',
            'label'=> 'Bookings'
        ],
        [
            'page' => 'simple_calendar/giftvouchers',
            'label'=> 'Gift Vouchers'
        ],
    ], $CurrentUser);
