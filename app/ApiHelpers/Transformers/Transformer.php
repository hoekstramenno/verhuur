<?php namespace App\ApiHelpers\Transformers;

use Illuminate\Support\Collection;
use App\ApiHelpers\Paginate\Paginate;

abstract class Transformer
{
    /**
     * Resource name of the json object.
     *
     * @var string
     */
    protected $resourceName = 'data';

    /**
     * Transform a collection of items.
     *
     * @param Collection $data
     * @return array
     */
    public function collection(Collection $data)
    {
        $result = [
            str_plural($this->resourceName) => []
        ];

        foreach ($data->toArray() as $row) {
            $transformed = $this->transform($row);
            $result[str_plural($this->resourceName)][] = $transformed;
        }

        return $result;
    }

    /**
     * Transform a single item.
     *
     * @param $data
     * @return array
     */
    public function item($data)
    {
        return [
            $this->resourceName => $this->transform($data)
        ];
    }

    /**
     * Transform a paginated item.
     *
     * @param Paginate $paginated
     * @return array
     */
    public function paginate(Paginate $paginated)
    {
        $resourceName = str_plural($this->resourceName);

        $countName = str_plural($this->resourceName) . 'Count';

        $data = [
            $resourceName => $paginated->getData()->map([$this, 'transform'])
        ];

        return array_merge($data, [
            $countName => $paginated->getTotal()
        ]);
    }

    /**
     * Apply the transformation.
     *
     * @param $data
     * @return mixed
     */
    public abstract function transform($data);
}