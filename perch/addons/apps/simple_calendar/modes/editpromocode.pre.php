<?php

    $HTML = $API->get('HTML');

    $SimpleCalendar = new Simple_Calendars($API);

    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');

    $SimpleCalendar->ensurePromoSchema();

    if ($Form->submitted()) {

		$data = $_POST;
		$SimpleCalendar->promoUpdate($data);
		$message = $HTML->success_message('Promotional code updated');

    }

    $promo = $SimpleCalendar->getPromo($_GET['id']);

    $units = $SimpleCalendar->getAccUnit(0);
    $promoUnits    = isset($promo['units']) ? trim($promo['units']) : 'all';
    $selectedUnits = ($promoUnits=='' || strtolower($promoUnits)=='all') ? array() : array_map('trim', explode(',', $promoUnits));
