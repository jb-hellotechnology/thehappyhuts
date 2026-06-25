<?php

    $HTML = $API->get('HTML');

    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');

    $SimpleCalendar->ensurePromoSchema();

    $promos = $SimpleCalendar->getPromos();

    // Map unitID => name so the list can show which huts each code is limited to.
    $unitNames = array();
    foreach($SimpleCalendar->getAccUnit(0) as $u){
        $unitNames[$u['unitID']] = $u['name'];
    }
