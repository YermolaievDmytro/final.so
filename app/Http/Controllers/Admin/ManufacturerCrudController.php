<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManufacturerRequest as StoreRequest;
use App\Http\Requests\ManufacturerRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class ManufacturerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ManufacturerCrudController extends CrudController {

    public function setup() {
        /*
          |--------------------------------------------------------------------------
          | CrudPanel Basic Information
          |--------------------------------------------------------------------------
         */
        $this->crud->setModel('App\Models\Manufacturer');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manufacturer');
        $this->crud->setEntityNameStrings('manufacturer', 'manufacturers');

        /*
          |--------------------------------------------------------------------------
          | CrudPanel Configuration
          |--------------------------------------------------------------------------
         */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in ManufacturerRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        //выбор продуктов
//        $this->crud->addField([
//            'type' => 'select',
//            'name' => 'products', // the relationship name in your Model
//            'entity' => 'products', // the relationship name in your Model
//            'attribute' => 'name', // attribute on Article that is shown to admin
//        ]);
    }

    public function store(StoreRequest $request) {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request) {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

}
