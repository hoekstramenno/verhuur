<?php namespace App\ApiHelpers\Transformers;

use App\Date;
use Carbon\Carbon;

class DatesTransformer extends Transformer
{
    protected $resourceName = 'dates';

    public function transform($data)
    {
        $date = new Date();


        return [
            'id'                => $data['id'],
            'start'             => $data['date_from']->toDateTimeString(),
            'end'               => $data['date_to']->toDateTimeString(),
            'status'            => [
                'code' => $data['status'],
                'label' => $date->getLabel($data['status'])
            ],
            'createdAt'         => $data['created_at']->toDateTimeString(),
            'updatedAt'         => $data['updated_at']->toDateTimeString(),
            'difference'        => $data['date_from']->diffInDays($data['date_to']),
            'total_options'     => count($data['options'])
        ];
    }
}