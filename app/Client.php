<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function getLatestPaymentsByDates(array $dates){

        return DB::select("
            select c.id,c.name,c.surname,p.amount,p.updated_at from laravelDB.clients c
            left join  (
            SELECT t1.*
                FROM laravelDB.payments t1
                INNER JOIN
                (
                    SELECT client_id, MAX(updated_at) AS max_date
                    FROM laravelDB.payments
                    where updated_at BETWEEN '{$dates['startDate']}' and '{$dates['endDate']}'
                    GROUP BY client_id
                ) t2
                    ON t1.client_id = t2.client_id AND t1.updated_at = t2.max_date
            ) p on c.id=p.client_id 
            group by c.id
            order by c.id asc;"
        );
    }

}
