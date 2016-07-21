<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Todo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ToDoController extends Controller
{
    /**
     * @Route("/", name="todo_list")
     */
    public function listAction()
    {
        $todos = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->findAll();
        // replace this example code with whatever you need
        return $this->render('todo/index.html.twig', array(
            'todos' => $todos
        ));
    }

    /**
     * @Route("/todos/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
        $todo = new Todo();

        $form = $this->createFormBuilder($todo)
            ->add('name', TextType::class ,
            array('attr' => array(
                'class' => 'form-control',
                'style' => 'margin-bottom:15px')))
            ->add('category', TextType::class ,
                array('attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px')))
            ->add('description', TextareaType::class ,
        array('attr' => array(
            'class' => 'form-control',
            'style' => 'margin-bottom:15px')))
            ->add('priority', ChoiceType::class , array('choices' => array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High')),
            array('attr' => array(
                'class' => 'form-control',
                'style' => 'margin-bottom:15px')))
            ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Create Post', 'attr' => array('class' => 'btn btn-primary')))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //Get Date
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();
            $now = new \DateTime('now');


            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();

            $this->addFlash('notice',
            'Todo Added');

            return $this->redirectToRoute('todo_list');
        }

        // replace this example code with whatever you need
        return $this->render('todo/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/todos/edit/{id}", name="todo_edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {
        $todo = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->find($id);

        $now = new \DateTime('now');
        $todo->setName($todo->getName());
        $todo->setCategory($todo->getCategory());
        $todo->setDescription($todo->getDescription());
        $todo->setPriority($todo->getPriority());
        $todo->setDueDate($todo->getDueDate());
        $todo->setCreateDate($todo->getCreateDate($now));

        $form = $this->createFormBuilder($todo)
            ->add('name', TextType::class,
                array('attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px')))
            ->add('category', TextType::class,
                array('attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px')))
            ->add('description', TextareaType::class,
                array('attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px')))
            ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High')),
                array('attr' => array(
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px')))
            ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Create Post', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Get Date
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();
            $now = new \DateTime('now');

            $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository('AppBundle:Todo')->find($id);

            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);

            $em->flush();

            $this->addFlash('notice',
                'Todo Updated');

            return $this->redirectToRoute('todo_list');
        }

        // replace this example code with whatever you need
        return $this->render('todo/edit.html.twig', array('todo' => $todo,
            'form' => $form->createView()) );
    }

    /**
     * @Route("/todos/details/{id}", name="todo_details")
     */
    public function detailsAction($id)
    {
        $todo = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->find($id);

        // replace this example code with whatever you need
        return $this->render('todo/details.html.twig', array(
            'todo' => $todo
        ));
        // replace this example code with whatever you need
        return $this->render('todo/details.html.twig');
    }

    /**
     * @Route("/todos/delete/{id}", name="todo_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $todo = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->find($id);

        $em->remove($todo);
        $em->flush();

        $this->addFlash('notice', 'Todo Removed');

        return $this->redirectToRoute('todo_list');

    }
}
