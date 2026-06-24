<?php

    # include the API
    include('../../../core/inc/api.php');

    $API  = new PerchAPI(1.0, 'simple_calendar');

    # include your class files
    include('Simple_Calendars.class.php');
    include('Simple_Calendar.class.php');

    $HTML = $API->get('HTML');

    