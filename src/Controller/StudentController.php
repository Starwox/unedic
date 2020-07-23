<?php
/**
 * Created by PhpStorm.
 * User: starwox
 * Date: 22/07/2020
 * Time: 20:12
 */

namespace App\Controller;

use App\Entity\Department;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Student;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class StudentController extends AbstractController
{
    /**
     * @Route("/create/student", name="create_student")
     */
    public function createStudent(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('list_student');
        }

            return $this->render('student/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="list_student")
     */
    public function listStudent()
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Student::class);
        $value = $em->findAll();

        return $this->render('student/list.html.twig',[
            'students' => $value
        ]);
    }

    /**
     * @Route("/edit/student/{id}", name="edit_student")
     */
    public function editStudent($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository(Student::class)->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $form = $this->createFormBuilder($student)
            ->add("firstname", TextType::class, [
                'data' => $student->getFirstName()
            ])
            ->add("lastname", TextType::class, [
                'data' => $student->getLastName()
            ])
            ->add("numetud", IntegerType::class, [
                'data' => $student->getNumEtud()
            ])
            ->add('save', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $value = $form->getData();
            $student->setFirstName($value->getFirstName());
            $student->setLastName($value->getLastName());
            $student->setNumEtud($value->getNumEtud());
            $em->flush();

            return $this->redirectToRoute('list_student');
        }

        return $this->render('student/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/student/{id}", name="delete_student")
     */
    public function deleteStudent($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository(Student::class)->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute('list_student');

    }
}