<?php namespace App\ApiHelpers\Transformers;

use App\Date;

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
            'total_options'     => count($data['options'])
        ];
    }
}