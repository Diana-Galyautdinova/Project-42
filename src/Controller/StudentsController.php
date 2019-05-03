<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Students;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StudentsController extends AbstractController
{
    /**
     * @Route("/students", name="students")
     */
    public function index()
    {
        $students = $this->getDoctrine()
            ->getRepository(Students::class)
            ->findAll();
        return $this->render('Students/index.html.twig', ['students' => $students]);
    }

    /**
     * @Route("/students/save", name="students.save")
     */
    public function save(Request $request, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $students = new Students();
        $validator = Validation::createValidator();
        $arg = [
            new Length(['max' => 255]),
            new NotBlank()];
        $firstname = $validator->validate($request->request->get('firstname'), $arg);
        $lastname = $validator->validate($request->request->get('lastname'), $arg);
        $averagemark = $validator->validate($request->request->get('average-mark'), [
            new Length(['min' => 1]),
            new NotBlank()
        ]);

        if (0 === count($firstname) && 0 === count($lastname) && 0 === count($averagemark)) {
            $students->setFirstname($request->request->get('firstname'));
            $students->setLastname($request->request->get('lastname'));
            $students->setAverageMark($request->request->get('average-mark'));
            $em->persist($students);
            $em->flush();

            return new Response(
                '{"response":'.$serializer->serialize($students, 'json').'}'
            );
        }

        $errors = [];
        foreach ($firstname as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($lastname as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($averagemark as $error) {
            $errors[] = $error->getMessage();
        }

        return new JsonResponse([
            'error' => $errors
        ]);
    }

    /**
     * @Route("/students/delete", name="students.delete")
     */
    public function delete(Request $request, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $students = $this->getDoctrine()
            ->getRepository(Students::class)
            ->find($request->request->get('id'));

        if (!$students) {
            throw $this->createNotFoundException(
                'No product found for id '.$request->request->get('id')
            );
        }

        $em->remove($students);
        $em->flush();

        return new JsonResponse([
            'response' => $request->request->get('id')
        ]);
    }
}
