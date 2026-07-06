<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('notifications:check')->dailyAt('08:00');
