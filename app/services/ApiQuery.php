<?php

namespace App\services;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Operator;

class ApiQuery {

    public function __construct($safeParms,$columnMap)
    {
        $this->safeParms=$safeParms;
        $this->columnMap=$columnMap;
    }

    protected $safeParms ;

    protected $columnMap ;

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];

    public function transform(Request $request) {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }
        return $eloQuery;
    }
}