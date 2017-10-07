<?php namespace App\ApiHelpers\Transformers\Reunie;

use App\Date, App\ApiHelpers\Transformers\Transformer;

class PersonsTransformer extends Transformer
{
    protected $resourceName = 'material';

    public function transform($data)
    {
        return $data;
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