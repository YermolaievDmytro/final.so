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

        //имя
        $this->crud->addColumn([
            'name' => 'name', // The db column name
            'label' => "Name", // Table column heading
            'type' => "text",
        ]);

        //производитель
        $this->crud->addColumn([
            'name' => 'manufacturer_id', // The db column name
            'label' => "Manufacturer", // Table column heading
            'type' => "text",
            'attribute' => "name",
        ]);

        //цена
        $this->crud->addColumn([
            'name' => 'price', // The db column name
            'label' => "Price", // Table column heading
            'type' => "number",
            'suffix' => " EUR",
            'decimals' => 2,
        ]);

        $this->crud->addColumn([
            'name' => 'manufacturer_id', // The db column name
            'label' => "Manufacturer", // Table column heading
            'type' => "text",
            'attribute' => "name",
        ]);

        //описание
        $this->crud->addColumn([
            'name' => 'description', // The db column name
            'label' => "Description", // Table column heading
            'type' => "closure",
            'function' => function($entry) {
                return 'Created on ' . $entry->description;
            }
                //'view' => 'package::columns.column_type_name',
        ]);

        //дата
        $this->crud->addColumn([
            'name' => 'date_of_create', // The db column name
            'label' => "Date of creat", // Table column heading
            'type' => "date",
        ])->afterColumn('name');

        //вес
        $this->crud->addColumn([
            'name' => 'weight', // The db column name
            'label' => "Weight", // Table column heading
            'type' => "text",
        ]);

        //высота
        $this->crud->addColumn([
            'name' => 'height', // The db column name
            'label' => "Height", // Table column heading
            'type' => "text",
        ]);

        //ширина
        $this->crud->addColumn([
            'name' => 'width', // The db column name
            'label' => "Width", // Table column heading
            'type' => "text",
        ]);

        //длина
        $this->crud->addColumn([
            'name' => 'length', // The db column name
            'label' => "Length", // Table column heading
            'type' => 'number',
            'decimals' => 2,
        ]);

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

        //производитель
        $this->crud->addColumn([
            // 1-n relationship
            'label' => "Manufacturer", // Table column heading
            'type' => "select",
            'name' => 'manufacturer_id', // the column that contains the ID of that connected entity;
            'entity' => 'manufacturer', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Manufacturer", // foreign key model
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

        //выбор цены
        $this->crud->addField([
            'name' => 'price',
            'label' => 'Price',
            'type' => 'number',
            'attributes' => ["step" => "0.01"],
        ]);

        //выбор описания
        $this->crud->addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'wysiwyg',
        ]);

        //выбор веса
        $this->crud->addField([
            'name' => 'weight',
            'label' => 'Weight',
            'type' => 'number',
            'attributes' => ["step" => "0.01"],
        ]);

        //выбор высоты
        $this->crud->addField([
            'name' => 'height',
            'label' => 'Height',
            'type' => 'number',
            'attributes' => ["step" => "0.01"],
        ]);

        //выбор ширины
        $this->crud->addField([
            'name' => 'width',
            'label' => 'Width',
            'type' => 'number',
            'attributes' => ["step" => "0.01"],
        ]);

        //выбор длины
        $this->crud->addField([
            'name' => 'length',
            'label' => 'Length',
            'type' => 'number',
            'attributes' => ["step" => "0.01"],
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
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        //выбор производителя
        $this->crud->addField([
            'type' => 'select',
            'label' => "Manufacturer",
            'name' => 'manufacturer_id', // the relationship name in your Model
            'entity' => 'manufacturer', // the relationship name in your Model
            'attribute' => 'name', // attribute on Article that is shown to admin
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

        //выбор наличия
        $this->crud->addField([
            'name' => 'in_stock',
            'label' => 'In stock',
            'type' => 'checkbox'
        ]);

        //выбрать минимальный возраст
        $this->crud->addField([
            'name' => 'min_age',
            'label' => 'Minimal age for use',
            'type' => 'number',
            'attributes' => [
                'required' => 'required',
            ],
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
