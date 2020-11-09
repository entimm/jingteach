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
        $counter = [];
        $list = Data::when($this->filter['start'], function ($query, $start) {
            return $query->where('created_at', '>=', $start.' 00:00:00');
        })->when($this->filter['end'], function ($query, $end) {
            return $query->where('created_at', '<=', $end.' 23:59:59');
        })->get();

        $result = [];
        foreach ($list as $item) {
            $key = md5(implode('::', [
                $item->school,
                $item->class,
                $item->name,
                $item->grade,
                $item->age,
                $item->student_no,
            ]));
            $counter[$key] = isset($counter[$key]) ? ++$counter[$key] : 1;
            $guideNameMap = [
                1 => '无线索',
                2 => '中央线索',
                3 => '双线索',
                4 => '空间线索-上',
                5 => '空间线索-下',
            ];
            $goalNameMap = [
                1 => '上-右-一致',
                2 => '下-右-一致',

                3 => '上-左-一致',
                4 => '下-左-一致',

                5 => '上-左-不一致',
                6 => '下-左-不一致',

                7 => '上-右-不一致',
                8 => '下-右-不一致',
            ];
            $answeerMap = [
                1 => '左',
                2 => '右',
            ];
            $sexMap = [
                1 => '男',
                2 => '女',
            ];
            foreach ($item->data as $one) {
                $rightAnswer = in_array($one['goalId'], [3, 4, 5, 6]) ? 1 : 2;
                $result[] = [
                    'id' => $item->id,
                    'times' => $counter[$key],
                    'school' => $item->school,
                    'class' => $item->class,
                    'name' => $item->name,
                    'grade' => $item->grade,
                    'age' => $item->age,
                    'sex' => isset($sexMap[$item->sex]) ? $sexMap[$item->sex] : '',
                    'student_no' => $item->student_no,
                    'ip' => $item->ip,
                    'round' => $one['round'],
                    'guideId' => $guideNameMap[$one['guideId']] ?? '',
                    'goalId' => $goalNameMap[$one['goalId']] ?? '',
                    'answer' => $answeerMap[$one['answer']] ?? '',
                    'cost_time' => $one['cost_time'],
                    'time_cost1' => $one['time_details'][1],
                    'time_cost2' => $one['time_details'][2],
                    'time_cost3' => $one['time_details'][3],
                    'time_cost4' => $one['time_details'][4],
                    'time_cost5' => $one['time_details'][5],
                    'is_right' => $rightAnswer == $one['answer'] ? '对' : '错',
                    'is_consistent' => $one['goalId'] <= 4 ? '是' : '否',
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
            '次数',
            '学校',
            '班级',
            '姓名',
            '年级',
            '年龄',
            '性别',
            '学号',
            'IP地址',
            '回合',
            '线索',
            '目标',
            '回答',
            '耗时',
            '步骤1',
            '步骤2',
            '步骤3',
            '步骤4',
            '步骤5',
            '对错',
            '是否一致',
            '创建时间',
            '修改时间',
        ];
    }
}
