<?php

namespace App\Exports;

use App\Data;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromArray, WithHeadings
{
    use Exportable;

    private $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function array(): array
    {
        $list = Data::when($this->filter['start'], function ($query, $start) {
            return $query->where('created_at', '>=', $start.' 00:00:00');
        })->when($this->filter['end'], function ($query, $end) {
            return $query->where('created_at', '<=', $end.' 23:59:59');
        })->get();

        $result = [];
        foreach ($list as $item) {
            foreach ($item->data as $one) {
                $result[] = [
                    'id' => $item->id,
                    'school' => $item->school,
                    'class' => $item->class,
                    'student_no' => $item->student_no,
                    'ip' => $item->ip,
                    'round' => $one['round'],
                    'guideId' => $one['guideId'],
                    'goalId' => $one['goalId'],
                    'answer' => $one['answer'],
                    'cost_time' => $one['cost_time'],
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
            ];
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            '学校',
            '班级',
            '学号',
            'IP地址',
            '回合',
            '线索',
            '目标',
            '回答',
            '耗时',
            '创建时间',
            '修改时间',
        ];
    }
}
