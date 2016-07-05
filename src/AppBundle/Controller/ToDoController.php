<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ToDoController extends Controller
{
    /**
     * @Route("/todos", name="todo_list")
     */
    public function listAction()
    {

        // replace this example code with whatever you need
        return $this->render('default/todo/list.html.twig');
    }

    /**
     * @Route("/todos/create", name="todo_create")
     */
    public function createAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('default/todo/create.html.twig');
    }

    /**
     * @Route("/todos/edit/{id}", name="todo_edit")
     */
    public function editAction($id, Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('default/todo/edit.html.twig');
    }

    /**
     * @Route("/todos/details/{id}", name="todo_details")
     */
    public function detailsAction($id)
    {

        // replace this example code with whatever you need
        return $this->render('default/todo/details.html.twig');
    }
}
