<?php namespace App\ApiHelpers\Transformers;

use App\Date;

class DatesTransformer extends Transformer
{
    protected $resourceName = 'dates';

    public function transform($data)
    {
        $date = new Date();
        return [
            'start'             => $data['date_from'],
            'end'               => $data['date_to'],
            'status'            => $date->getLabel($data['status']),
            'createdAt'         => $data['created_at']->toAtomString(),
            'updatedAt'         => $data['updated_at']->toAtomString()
        ];
    }
}