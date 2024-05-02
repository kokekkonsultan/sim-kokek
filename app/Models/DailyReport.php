<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DailyReport extends Model
{
    // protected $table = 'view_dpb';
    // protected $primaryKey = 'id_dpb';


    public static function query()
    {
        $query = DB::table('daily_report')
        ->select('*',
        DB::raw('(SELECT branch_name FROM branch_agency WHERE branch_agency.id_branch_agency = daily_report.id_branch_agency) AS organisasi'),
        DB::raw('(SELECT contact_person_name FROM contact_person WHERE contact_person.id_contact_person = daily_report.id_contact_person) AS contact_person_name'),
        DB::raw("(SELECT CONCAT(first_name, ' ' , last_name) FROM users WHERE users.id = daily_report.input_id) AS nama_pic")
        );
        return $query;
    }
}
