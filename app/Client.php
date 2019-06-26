<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @property integer id
 * @property string name
 * @property string last_name
 * @property string civil_status
 * @property string document_type
 * @property string sex
 * @property string rfid
 * @property string end
 * @property boolean active
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
        'actions', 'fingerprint', 'full_name', 'select_value',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $exported = [
        'name', 'end', 'rfid',
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
            'fields' => [
                'name', 'end', 'rfid',
            ],
            'active' => true,
            'actions' => true,
        ],
        'form' => [
            [
                'name' => 'name',
                'type' => 'text',
            ],
            [
                'name' => 'rfid',
                'type' => 'text'
            ],
            [
                'name' => 'end',
                'type' => 'date'
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
            'fingerprint' => file_exists(storage_path("app/public/fingerprints/{$this->id}.bmp")),
        ];
    }

    /**
     * Mutator for the fingerprint
     *
     * @return string
     */
    public function getFingerprintAttribute()
    {
        if(file_exists(storage_path("app/public/fingerprints/{$this->id}.bmp"))) return env('APP_URL') . "/storage/fingerprints/{$this->id}.bmp";
        else return null;
    }

    // Methods

    /**
     * Boot methods
     *
     */
    public static function boot()
    {
        parent::boot();

        self::updated(function(Client $model) {
            $model->notifyUpdate();
        });
    }

    public function notifyUpdate()
    {
        $connection = new AMQPStreamConnection(env('RABBIT_HOST', 'localhost'), env('RABBIT_PORT', 5672), env('RABBIT_USERNAME', ''), env('RABBIT_PASSWORD', ''));
        $channel = $connection->channel();

        $channel->queue_declare(env('RABBIT_QUEUE_TERMINAL', 'demo'), false, true, false, false);

        $msg = new AMQPMessage(json_encode([
            'id' => $this->id,
            'canEnter' => $this->active ? 'true' : 'false',
            'errorMessage' => '',
            'fingerprintURL' => $this->fingerprint,
            'fullname' => $this->full_name,
            'endDate' => $this->end,
            'idSubsidiary' => 1,
            'rfid' => $this->rfid,
        ]));
        $channel->basic_publish($msg, '', env('RABBIT_QUEUE_TERMINAL', 'demo'));

        $channel->close();
        $connection->close();
    }

    // Relationships

    /**
     * Punches relationship
     *
     * @return HasMany
     */
    public function punches()
    {
        return $this->hasMany(Punch::class);
    }
}
