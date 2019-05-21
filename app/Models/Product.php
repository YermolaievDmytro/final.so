<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use GuzzleHttp\Client;

class Product extends Model {

    use CrudTrait;

    /*
      |--------------------------------------------------------------------------
      | GLOBAL VARIABLES
      |--------------------------------------------------------------------------
     */

    protected $table = 'products';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'price',
        'date_of_create',
        'weight',
        'height',
        'width',
        'length',
        'country_id',
        'in_stock',
        'min_age',
        'description',
        'manufacturer_id',
        'color',
    ];

    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'products_categories');
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function manufacturer() {
        return $this->belongsTo(Manufacturer::class);
    }

    public function USD() {
        $client = new Client(['base_uri' => 'https://bank.gov.ua']);
        $request = $client->get('/NBUStatService/v1/statdirectory/exchange?json');
        if ($request->getStatusCode() !== 200) {
            return redirect('/admin');
        }
        $body = $request->getBody();
        $content_array = json_decode($body->getContents());
        $USD = 0;
        foreach ($content_array as $key => $value) {
            if ($value->cc === 'USD') {
                $USD = $value->rate;
            }
        }
        return $USD;
    }

    // protected $hidden = [];
    // protected $dates = [];

    /*
      |--------------------------------------------------------------------------
      | FUNCTIONS
      |--------------------------------------------------------------------------
     */

    /*
      |--------------------------------------------------------------------------
      | RELATIONS
      |--------------------------------------------------------------------------
     */

    /*
      |--------------------------------------------------------------------------
      | SCOPES
      |--------------------------------------------------------------------------
     */

    /*
      |--------------------------------------------------------------------------
      | ACCESORS
      |--------------------------------------------------------------------------
     */

    /*
      |--------------------------------------------------------------------------
      | MUTATORS
      |--------------------------------------------------------------------------
     */
}
