<?php

namespace App\Exports;

use App\Data;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataRawExport implements FromCollection, WithHeadings
{
    use Exportable;

    private $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        return Data::when($this->filter['start'], function ($query, $start) {
            return $query->where('created_at', '>=', $start.' 00:00:00');
        })->when($this->filter['end'], function ($query, $end) {
            return $query->where('created_at', '<=', $end.' 23:59:59');
        })->get();
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
            '姓名',
            '年级',
            '年龄',
            '学号',
            'IP地址',
            '数据',
            '创建时间',
            '修改时间',
        ];
    }
}
