<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProductRequest as StoreRequest;
use App\Http\Requests\ProductRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ProductCrudController extends CrudController {

    public function setup() {
        /*
          |--------------------------------------------------------------------------
          | CrudPanel Basic Information
          |--------------------------------------------------------------------------
         */
        $this->crud->setModel('App\Models\Product');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/product');
        $this->crud->setEntityNameStrings('product', 'products');

        /*
          |--------------------------------------------------------------------------
          | CrudPanel Configuration
          |--------------------------------------------------------------------------
         */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in ProductRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        //в наличии
        $this->crud->addColumn([
            'name' => 'in_stock', // The db column name
            'label' => "In stock", // Table column heading
            'type' => 'check',
        ]);

        //страна
        $this->crud->addColumn([
            // 1-n relationship
            'label' => "Country", // Table column heading
            'type' => "select",
            'name' => 'country_id', // the column that contains the ID of that connected entity;
            'entity' => 'country', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Country", // foreign key model
        ]);

        //категории
        $this->crud->addColumn([
            'label' => "Categories", // Table column heading
            'type' => "select_multiple",
            'name' => 'categories', // the method that defines the relationship in your Model
            'entity' => 'categories', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Category", // foreign key model
        ]);

        //выбор категории
        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'categories', // the relationship name in your Model
            'entity' => 'categories', // the relationship name in your Model
            'attribute' => 'name', // attribute on Article that is shown to admin
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        //выбор страны
        $this->crud->addField([
            'type' => 'select',
            'label' => "Country",
            'name' => 'country_id', // the relationship name in your Model
            'entity' => 'country', // the relationship name in your Model
            'attribute' => 'name', // attribute on Article that is shown to admin
            'required' => 'required',
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        //выбор даты
        $this->crud->addField([
            'name' => 'date_of_create',
            'type' => 'date_picker',
            'label' => 'Create at',
            'date_picker_options' => [
                'todayBtn' => 'linked',
                'format' => 'dd-mm-yyyy',
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        $this->crud->addField([
            'name' => 'in_stock',
            'label' => 'In stock',
            'type' => 'checkbox'
        ]);
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
