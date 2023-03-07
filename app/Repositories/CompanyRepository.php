<?php

namespace App\Repositories;


use App\Models\Company;
class CompanyRepository
{
    public function pluck()
    {
        return Company::orderBy('name')->pluck('name', 'id');
        /*return [
            1 => 'Company One',
            2 => 'Company Two',
        ];*/
    }
}