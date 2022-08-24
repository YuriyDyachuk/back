<?php

use Illuminate\Support\Facades\Http;

$res = Http::withHeaders([
    'UserAgent' => "4dcca956-c1a5-4fa0-8497-20baf670f337",
])->get('https://data.rada.gov.ua/laws/show/80731-10.json');
print_r($res);
