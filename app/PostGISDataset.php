<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class PostGISDataset extends Model
{
    use PostgisTrait;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gis_data_entry_table';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'pgsql';



    // Deifne Geom field
    protected $postgisFields = [
        'geom',
    ];

    // Define Geom Type
    protected $postgisTypes = [
        'geom' => [
            'geomtype' => 'geometry',
            'srid' => 4326
        ],
    ];

}
