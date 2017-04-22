<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class Cloud extends Facade
{
    protected static function getFacadeAccessor() { return 'cloud.service'; }
}