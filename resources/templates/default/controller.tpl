<?php

namespace App\Controllers;

use App\Models\{{entity}}Model;
use CodeIgniter\Controller;

class {{entity}}Controller extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new {{entity}}Model();
    }

    public function index()
    {
        $data = [
            'title' => lang('CrudGenerator.viewIndex'),
            '{{variableNamePlural}}' => $this->model->getAll(),
        ];

        return view('templates/header', $data)
            . view('{{viewPath}}/index')
            . view('templates/footer');
    }

    public function show($id = null)
    {
        $data = [
            'title' => lang('CrudGenerator.viewShow'),
            'item' => $this->model->getById($id),
        ];

        return view('templates/header', $data)
            . view('{{viewPath}}/show')
            . view('templates/footer');
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();

            if (! $this->model->insertData($data)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->model->errors());
            }

            return redirect()->to('/{{routeBase}}');
        }

        $data = [
            'title' => lang('CrudGenerator.viewCreate'),
            'item'  => new \App\Entities\{{entity}}()
        ];

        return view('templates/header', $data)
            . view('{{viewPath}}/create')
            . view('templates/footer');
    }

    public function edit($id = null)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();

            if (! $this->model->updateData($id, $data)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->model->errors());
            }

            return redirect()->to('/{{routeBase}}');
        }

        $data = [
            'title' => sprintf(lang('CrudGenerator.editItem'), $id),
            'item'  => $this->model->getById($id),
        ];

        return view('templates/header', $data)
            . view('{{viewPath}}/edit')
            . view('templates/footer');
    }

    public function delete($id = null)
    {
        $this->model->deleteData($id);
        return redirect()->to('/{{routeBase}}');
    }
}
