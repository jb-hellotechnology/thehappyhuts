<?php

    $HTML = $API->get('HTML');

    $SimpleCalendar = new Simple_Calendars($API);

    // --- Which month are we showing? (defaults to the current month) ---
    $month = isset($_GET['month']) ? (int) $_GET['month'] : (int) date('n');
    $year  = isset($_GET['year'])  ? (int) $_GET['year']  : (int) date('Y');

    if ($month < 1 || $month > 12) {
        $month = (int) date('n');
        $year  = (int) date('Y');
    }

    // Bookings are attributed to the month of their arrival date (startTime).
    $lastDay    = (int) date('t', mktime(0, 0, 0, $month, 1, $year));
    $rangeStart = sprintf('%04d-%02d-01 00:00:00', $year, $month);
    $rangeEnd   = sprintf('%04d-%02d-%02d 23:59:59', $year, $month, $lastDay);

    $monthLabel = date('F Y', mktime(0, 0, 0, $month, 1, $year));

    // Previous / next month for the navigation buttons.
    $prevMonth = $month - 1; $prevYear = $year;
    if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }

    $nextMonth = $month + 1; $nextYear = $year;
    if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }

    $prevLink = $API->app_path() . '/?month=' . $prevMonth . '&year=' . $prevYear;
    $nextLink = $API->app_path() . '/?month=' . $nextMonth . '&year=' . $nextYear;

    // --- Sales per unit for the selected month ---
    $units = $SimpleCalendar->getAccUnit(0);

    // One grouped query returns the totals; map them by unitID for quick lookup.
    $salesRows = $SimpleCalendar->getMonthlySalesByUnit($rangeStart, $rangeEnd);
    $salesMap  = array();
    foreach ($salesRows as $row) {
        $salesMap[$row['unitID']] = $row;
    }

    // Totals across all listed units.
    $grandTotal    = 0;
    $grandBookings = 0;
    foreach ($units as $unit) {
        $uid = $unit['unitID'];
        if (isset($salesMap[$uid])) {
            $grandTotal    += (float) $salesMap[$uid]['total'];
            $grandBookings += (int) $salesMap[$uid]['bookings'];
        }
    }
