<?php

declare(strict_types=1);

namespace App\Controller;

use App\Document\Resume;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResumeController extends AbstractController
{
    private DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    #[Route('/api/cv', name: 'cv_index', methods: ['GET'])]
    public function index(): Response
    {
        
        $resumeRepository = $this->dm->getRepository(Resume::class);
        $resumes = $resumeRepository->findAll();
    
        
        // Преобразуем объекты в массивы
        $data = [];
        foreach ($resumes as $resume) {
            $data[] = [
                'id' => (string) $resume->getId(),
                'name' => $resume->getName() ?? '',
                'profession' => $resume->getProfession() ?? '',
                'age' => $resume->getAge() ?? 0,
                'status' => $resume->getStatus() ?? '',
                'photo' => $resume->getPhoto() ?? '',
                'city' => $resume->getCity() ?? '',
                'phone' => $resume->getPhone() ?? '',
                'email' => $resume->getEmail() ?? '',
                'birthDate' => $resume->getBirthDate() ? $resume->getBirthDate()->format('Y-m-d') : '',
                'education' => $resume->getEducation() ?? '',
                'desiredSalary' => $resume->getDesiredSalary() ?? 0,
                'skills' => $resume->getSkills() ?? [],
                'about' => $resume->getAbout() ?? '',
                'additionalEducation' => $resume->getAdditionalEducation() ?? [],
                'educationList' => $resume->getEducationList() ?? [],
            ];
        }
    
        
        return $this->json($data);
    }
    

    #[Route('/api/cvID', name: 'api_cv_show', methods: ['GET'])]
    public function show(Request $request): JsonResponse
    {
        // Получаем id из GET параметров
        $id = $request->query->get('id');
    
        // Если id не передан, возвращаем ошибку
        if (!$id) {
            return new JsonResponse(['message' => 'ID is required'], Response::HTTP_BAD_REQUEST);
        }
    
        // Поиск резюме по id
        $resume = $this->dm->getRepository(Resume::class)->find($id);
    
        if (!$resume) {
            return new JsonResponse(['message' => 'Resume not found'], Response::HTTP_NOT_FOUND);
        }
    
        // Возвращаем данные резюме в формате JSON
        return $this->json([
            'id' => (string)$resume->getId(),
            'name' => $resume->getName(),
            'profession' => $resume->getProfession(),
            'status' => $resume->getStatus(),
            'photo' => $resume->getPhoto(),
            'city' => $resume->getCity(),
            'phone' => $resume->getPhone(),
            'email' => $resume->getEmail(),
            'birthDate' => $resume->getBirthDate() ? $resume->getBirthDate()->format('Y-m-d') : '',
            'education' => $resume->getEducation(),
            'desiredSalary' => $resume->getDesiredSalary(),
            'skills' => $resume->getSkills(),
            'about' => $resume->getAbout(),
            'additionalEducation' => $resume->getAdditionalEducation(),
            'educationList' => $resume->getEducationList(),
        ]);
    }
    

    #[Route('/api/cv/add', name: 'api_cv_add', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        // Проверка на наличие синтаксической ошибки в JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse(['message' => 'Invalid JSON syntax'], Response::HTTP_BAD_REQUEST);
        }
        
        // Проверка на наличие обязательных полей
        $requiredFields = [
            'name', 'profession', 'age', 'status', 'photo',
            'city', 'phone', 'email', 'birthDate', 'education', 
            'desiredSalary', 'skills', 'about', 'additionalEducation', 'educationList'
        ];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return new JsonResponse(['message' => "Missing required field: $field"], Response::HTTP_BAD_REQUEST);
            }
        }
    
        try {
            $resume = new Resume(
                $data['name'],
                $data['profession'],
                $data['age'],
                $data['status'],
                $data['photo'],
                $data['city'] ?? null,
                $data['phone'] ?? null,
                $data['email'] ?? null,
                isset($data['birthDate']) ? new \DateTime($data['birthDate']) : null,
                $data['education'] ?? null,
                $data['desiredSalary'] ?? null,
                $data['skills'] ?? [],
                $data['about'] ?? null,
                $data['additionalEducation'] ?? [],
                $data['educationList'] ?? []
            );
    
            $this->dm->persist($resume);
            $this->dm->flush();
        
            return $this->json(['message' => 'Resume successfully added', 'resume' => $resume], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'Error adding resume: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    
    

    #[Route('/api/cv/{id}/edit', name: 'api_cv_edit', methods: ['POST'])]
    public function edit(string $id, Request $request): JsonResponse
    {
        $resume = $this->dm->getRepository(Resume::class)->find($id);
    
        if (!$resume) {
            return new JsonResponse(['message' => 'Resume not found'], Response::HTTP_NOT_FOUND);
        }
    
        $data = json_decode($request->getContent(), true);
    
        // Обновляем только те поля, которые переданы в запросе
        if (isset($data['name'])) {
            $resume->setName($data['name']);
        }
        if (isset($data['profession'])) {
            $resume->setProfession($data['profession']);
        }
        if (isset($data['age'])) {
            $resume->setAge($data['age']);
        }
        if (isset($data['status'])) {
            $resume->setStatus($data['status']);
        }
        if (isset($data['photo'])) {
            $resume->setPhoto($data['photo']);
        }

        if (isset($data['city'])) {
            $resume->setCity($data['city']);
        }

        if (isset($data['phone'])) {
            $resume->setPhone($data['phone']);  
        }

        if (isset($data['email'])) {
            $resume->setEmail($data['email']);
        }

        if (isset($data['birthDate'])) {
            $resume->setBirthDate(new \DateTime($data['birthDate']));
        }

        if (isset($data['education'])) {
            $resume->setEducation($data['education']);
        }

        if (isset($data['desiredSalary'])) {
            $resume->setDesiredSalary($data['desiredSalary']);
        }

        if (isset($data['skills'])) {
            $resume->setSkills($data['skills']);
        }
        

        if (isset($data['about'])) {
            $resume->setAbout($data['about']);
        }

        if (isset($data['additionalEducation'])) {
            $resume->setAdditionalEducation($data['additionalEducation']);
        }

        if (isset($data['educationList'])) {
            $resume->setEducationList($data['educationList']);
        }



        $this->dm->flush();
    
        return $this->json(['message' => 'Resume successfully updated', 'resume' => $resume], Response::HTTP_ACCEPTED);
    }
    

    #[Route('/api/cv/{id}/status/update', name: 'api_cv_status_update', methods: ['POST'])]
    public function updateStatus(string $id, Request $request): JsonResponse
    {
        $resume = $this->dm->getRepository(Resume::class)->find($id);

        if (!$resume) {
            return new JsonResponse(['message' => 'Resume not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $resume->setStatus($data['status']);

        $this->dm->flush();

        return $this->json(['message' => 'Status resume updated', 'resume' => $resume], Response::HTTP_ACCEPTED);
    }
}
