<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
| include adnin_routes.php, frontend_routes.php, hotel_routes.php
*/

// routes for admin
require __DIR__.'/Routes/admin_routes.php';

// routes for hotel
require_once  __DIR__.'/Routes/hotel_routes.php';

// routes for frontend
require_once  __DIR__.'/Routes/frontend_routes.php';
