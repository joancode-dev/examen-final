<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Book extends BaseController
{
    private $model;

    function __construct()
    {
        $this->model = model('BookModel');
    }

    protected function request()
    {
        return [
            'title' => $this->request->getVar('title'),
            'edition'  => $this->request->getVar('edition'),
            'authors'  => $this->request->getVar('authors'),
        ];
    }

    public function index()
    {
        $data['books'] = $this->model->findAll();
        return view('book/index', $data);
    }

    public function new()
    {
        $data['authors'] = model('AuthorModel')->findAll();
        return view('book/new', $data);
    }

    public function create()
    {
        $data = $this->request();

        $this->model->transBooksTutors($data);

        return $this->response->redirect(site_url('/books'));
    }

    public function show($id = null)
    {
        $data['book'] = $this->model->find($id);
        return view('book/show', $data);
    }

    public function edit($id = null)
    {
        $data['authors'] = model('AuthorModel')->findAll();
        $data['book'] = $this->model->find($id);
        return view('book/edit', $data);
    }

    public function update($id = null)
    {
        $data = $this->request();

        $this->model->transBooksTutors($data, $id);

        return $this->response->redirect(site_url('/books'));
    }

    public function delete($id = null)
    {
        $this->model->where('id', $id)->delete($id);
        return $this->response->redirect(site_url('books'));
    }
}
