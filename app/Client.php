<?php

namespace App;

use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\Storage;

/**
 * @property integer id
 * @property string name
 * @property string last_name
 * @property string civil_status
 * @property string document_type
 * @property string sex
 * @property mixed rfid
 * @property mixed active
 * @property string fingerprint
 * @property string full_name
 */
class Client extends Base
{
    /**
     * The mutated attributes that should be added for arrays.
     *
     * @var array
     */
    protected $appends = [
        'actions', 'fingerprint', 'full_name', 'translated_civil_status', 'translated_document_type', 'translated_sex', 'select_value',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $exported = [
        'translated_document_type', 'document', 'name', 'last_name', 'translated_sex', 'translated_civil_status', 'birth_date', 'address', 'neighborhood', 'phone', 'cellphone',
    ];

    /**
     * The data to build the layout.
     *
     * @var array
     */
    protected $layout = [
        'tools' => [
            'create' => true,
            'reload' => true,
            'export' => true,
        ],
        'table' => [
            'check' => false,
            'fields' => ['document', 'name', 'last_name',],
            'active' => true,
            'actions' => true,
        ],
        'form' => [
            [
                'name' => 'document_type',
                'type' => 'select',
                'value' => 'app.selects.person.document_type',
            ],
            [
                'name' => 'document',
                'type' => 'text',
            ],
            [
                'name' => 'name',
                'type' => 'text',
            ],
            [
                'name' => 'last_name',
                'type' => 'text',
            ],
            [
                'name' => 'sex',
                'type' => 'select',
                'value' => 'app.selects.person.sex',
            ],
            [
                'name' => 'civil_status',
                'type' => 'select',
                'value' => 'app.selects.person.civil_status',
            ],
            [
                'name' => 'birth_date',
                'type' => 'date',
            ],
            [
                'type' => 'section',
                'value' => 'app.sections.contact_information',
            ],
            [
                'name' => 'address',
                'type' => 'text'
            ],
            [
                'name' => 'neighborhood',
                'type' => 'text'
            ],
            [
                'name' => 'phone',
                'type' => 'text'
            ],
            [
                'name' => 'cellphone',
                'type' => 'text'
            ],
            [
                'name' => 'rfid',
                'type' => 'text'
            ],
        ],
    ];

    // Mutator

    /**
     * Mutator for the actions
     *
     * @return array
     */
    public function getActionsAttribute()
    {
        return [
            'id' => $this->id,
            'active' => $this->active,
            'fingerprint' => Storage::exists("public/fingerprints/{$this->id}.bmp"),
        ];
    }

    /**
     * Mutator for the fingerprint
     *
     * @return string
     */
    public function getFingerprintAttribute()
    {
        if(file_exists(storage_path("app/public/fingerprints/{$this->id}.bmp"))) return asset("storage/fingerprints/{$this->id}.bmp");
        else return null;
    }

    /**
     * Mutator for the full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->last_name}";
    }

    /**
     * Mutator for the translated civil status
     *
     * @return string
     */
    public function getTranslatedCivilStatusAttribute()
    {
        return __('app.selects.person.civil_status.' . $this->civil_status);
    }

    /**
     * Mutator for the translated document type
     *
     * @return string
     */
    public function getTranslatedDocumentTypeAttribute()
    {
        return __('app.selects.person.document_type.' . $this->document_type);
    }

    /**
     * Mutator for the translated sex
     *
     * @return string
     */
    public function getTranslatedSexAttribute()
    {
        return __('app.selects.person.sex.' . $this->sex);
    }

    // Methods

    /**
     * Boot methods
     *
     */
    public static function boot()
    {
        parent::boot();

        self::updated(function($model) {
            $model->notifyUpdate();
        });
    }

    public function notifyUpdate()
    {
        $active = $this->active ? 'true' : 'false';
        $date = date("Y-m-d");
        $date = strtotime(date("Y-m-d", strtotime($date)) . " +50 years");
        $date = date("Y-m-d", $date);

        Amqp::publish('Demo',
            '{
                "id":"' . $this->id . '",
                "canEnter":' . $active . ',
                "errorMessage":"",
                "fingerprintURL":"' . $this->fingerprint . '",
                "fullname":"' . $this->full_name . '",
                "endDate":"' . $date . '",
                "idSubsidiary":1,
                "rfid":"' . $this->rfid . '"
            }',
            ['queue' => 'Demo']
        );
    }
}
