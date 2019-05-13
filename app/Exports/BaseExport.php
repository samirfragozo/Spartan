<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;

class BaseExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    use Exportable;

    private $collection;
    private $fields;
    private $title;

    /**
     * BaseExport constructor.
     * @param Collection $collection
     * @param array $fields
     * @param String $title
     */
    public function __construct(Collection $collection, Array $fields, String $title)
    {
        $this->collection = $collection;
        $this->fields = $fields;
        $this->title = $title;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->collection;
    }

    /**
     * @param $invoice
     * @return array
     */
    public function map($invoice): array
    {
        $values = array_map(function ($item) use ($invoice) {
            if (!substr_compare($item, '_id', -3)) {
                $item = substr($item, 0, -3);
                return $invoice->$item->full_name;
            } else return $invoice->$item;
        }, $this->fields);

        return $values;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headers = array_map(function ($item) {
            return __('validation.attributes.' . $item);
        }, $this->fields);

        return $headers;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return  __('app.titles.' . $this->title);
    }
}
