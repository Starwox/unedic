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
            'name',
            'capacity',
            'student'  => [
                'id',
                'firstname',
                'lastname',
                'numetud'
            ]
        ]]);

        return new Response($data);
    }

    /**
     * @Route("/api/create_student", name="api_create_student", methods={"POST","HEAD"})
     */
    public function ApiCreateStudent(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $firstname = $request->request->get('firstname');
        $lastname = $request->request->get('lastname');
        $numetud = $request->request->get('numetud');

        // Check if FirstName was send as JSON
        if (empty($firstname)) {
            $jsonId = json_decode(file_get_contents("php://input"), true);

            $firstname = $jsonId['firstname'];
        }

        // Check if LastName was send as JSON
        if (empty($lastname)) {
            $jsonId = json_decode(file_get_contents("php://input"), true);

            $lastname = $jsonId['lastname'];
        }

        // Check if NumEtud was send as JSON
        if (empty($numetud)) {
            $jsonId = json_decode(file_get_contents("php://input"), true);

            $numetud = $jsonId['numetud'];
        }

        $repo = $this->getDoctrine()->getRepository(Student::class);
        $checker = $repo->findBy([
            'firstname' => $firstname,
            'lastname' => $lastname
        ]);

        if (!empty($checker)) {
            return new JsonResponse(['success' => 'no']);
        }

        $student = new Student();
        $student->setFirstName($firstname);
        $student->setLastName($lastname);
        $student->setNumEtud($numetud);
        $em->persist($student);
        $em->flush();

        return new JsonResponse([
            'success' => 'yes',
            'id' => $student->getId(),
            'firstname' => $student->getFirstName(),
            'lastname' => $student->getLastName(),
            'numetud' => $student->getNumEtud()

        ]);
    }


    /**
     * @Route("/api/create_dpartment", name="api_create_department", methods={"POST","HEAD"})
     */
    public function ApiCreateDepartment(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $name = $request->request->get('name');
        $capacity = $request->request->get('capacity');

        // Check if Name was send as JSON
        if (empty($name)) {
            $jsonId = json_decode(file_get_contents("php://input"), true);

            $name = $jsonId['name'];
        }

        // Check if Capacity was send as JSON
        if (empty($capacity)) {
            $jsonId = json_decode(file_get_contents("php://input"), true);

            $capacity = $jsonId['capacity'];
        }

        $repo = $this->getDoctrine()->getRepository(Student::class);
        $checker = $repo->findBy([
            'name' => $name,
            'capacity' => $capacity
        ]);

        if (!empty($checker)) {
            return new JsonResponse(['success' => 'no']);
        }

        $department = new Department();
        $department->setName($name);
        $department->setCapacity($capacity);
        $em->persist($department);
        $em->flush();

        return new JsonResponse([
            'success' => 'yes',
        ]);
    }
}