<?php
    $this->register_app('simple_calendar', 'Simple Calendar', 1, 'Simple Calendar Accommodation Booking System', '1.0');
    
    $this->add_setting('simple_calendar_DefaultEmail', 'Default Email Address', 'text', false);
    $this->add_setting('simple_calendar_StripeTestPublishable', 'Stripe Test Publishable Key', 'text', false);
    $this->add_setting('simple_calendar_StripeTestSecret', 'Stripe Test Secret Key', 'text', false);
    $this->add_setting('simple_calendar_StripeLivePublishable', 'Stripe Live Publishable Key', 'text', false);
    $this->add_setting('simple_calendar_StripeLiveSecret', 'Stripe Live Secret Key', 'text', false);
    $this->add_setting('simple_calendar_Live', 'Activate Live Payments', 'checkbox', false);