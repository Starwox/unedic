<?php
/**
 * Created by PhpStorm.
 * User: starwox
 * Date: 23/07/2020
 * Time: 14:28
 */

namespace App\Controller;

use App\Entity\Department;
use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class APIController extends AbstractController
{
    /**
     * @Route("/api/department", name="get_department")
     */
    public function getDepartment(): Response
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Department::class);
        $object = $em->findAll();

        $encoders = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];

        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoders]);
        $data = $serializer->serialize($object, 'json', [AbstractNormalizer::ATTRIBUTES => [
            'id',
            'Name',
            'Capacity',
            'student'  => [
                'id',
                'FirstName',
                'LastName',
                'NumEtud'
            ]
        ]]);

        return new Response($data);
    }

    /**
     * @Route("/api/add_studtodep", name="api_add_studtodep", methods={"POST","HEAD"})
     */
    public function ApiAddStudToDep(Request $request): JsonResponse
    {
        $studentId = $request->request->get('student_id');
        $departmentId = $request->request->get('department_id');

        $studRepo = $this->getDoctrine()->getRepository(Student::class);
        $departmentRepo = $this->getDoctrine()->getRepository(Department::class);

        $student = $studRepo->find($studentId);
        $deparment = $departmentRepo->find($departmentId);

        $deparment->addStudent($student);

        $em = $this->getDoctrine()->getManager();
        $em->persist($deparment);
        $em->flush();

        return new JsonResponse([
            "success" => "yes"
        ]);
    }

    /**
     * @Route("/api/oneDepart", name="get_oneDepart", methods={"POST","HEAD"})
     */
    public function getOneDepartment(Request $request): Response
    {
        $id = $request->request->get('department_id');

        $em = $this->getDoctrine()->getManager()->getRepository(Department::class);
        $object = $em->find($id);

        $encoders = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];

        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoders]);
        $data = $serializer->serialize($object, 'json', [AbstractNormalizer::ATTRIBUTES => [
            'id',
            'Name',
            'Capacity',
            'student'  => [
                'id',
                'FirstName',
                'LastName',
                'NumEtud'
            ]
        ]]);

        return new Response($data);
    }
}