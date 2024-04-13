<?php

namespace App\Actions\Members;

use App\Models\Member;

class CountMemberGroupActions
{
    public function execute()
    {
        $countWadah = Member::query()
            ->where('status', Member::STATUS_ACTIVE)
            ->selectRaw("
                    SUM(CASE WHEN `marital_status` = 'S' AND TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) < 11 THEN 1 ELSE 0 END) AS 'PELNAP',
                    SUM(CASE WHEN `marital_status` = 'S' AND TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 11 AND 17 THEN 1 ELSE 0 END) AS 'PELRAP',
                    SUM(CASE WHEN `marital_status` = 'S' AND TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > 17 THEN 1 ELSE 0 END) AS 'PELPAP',
                    SUM(CASE WHEN `marital_status` <> 'S' AND `gender` = 'F' THEN 1 ELSE 0 END) AS 'PELWAP',
                    SUM(CASE WHEN `marital_status` <> 'S'  AND `gender` = 'M' THEN 1 ELSE 0 END) AS 'PELPRIP'")
            ->get()->toArray();

        return $countWadah[0];
    }
}
