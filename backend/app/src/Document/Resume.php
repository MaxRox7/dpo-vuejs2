<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JsonSerializable;

#[ODM\Document(collection: 'resume')]
class Resume implements JsonSerializable
{
    #[ODM\Id]
    private ?string $id = null;

    #[ODM\Field(type: 'string')]
    private ?string $name = null;

    #[ODM\Field(type: 'string')]
    private ?string $profession = null;

    #[ODM\Field(type: 'int')]
    private ?int $age = null;

    #[ODM\Field(type: 'string')]
    private ?string $status = null;

    #[ODM\Field(type: 'string')]
    private ?string $photo = null;

    // Новые поля
    #[ODM\Field(type: 'string')]
    private ?string $city = null;

    #[ODM\Field(type: 'string')]
    private ?string $phone = null;

    #[ODM\Field(type: 'string')]
    private ?string $email = null;

    #[ODM\Field(type: 'date')]
    private ?\DateTime $birthDate = null;

    #[ODM\Field(type: 'string')]
    private ?string $education = null;

    #[ODM\Field(type: 'float', nullable: true)]
    private ?float $desiredSalary = null;

    #[ODM\Field(type: 'collection')]
    private array $skills = [];

    #[ODM\Field(type: 'string')]
    private ?string $about = null;

    #[ODM\Field(type: 'collection')]
    private array $additionalEducation = [];

    #[ODM\Field(type: 'collection')]
    private array $educationList = [];

    // Конструктор для обязательных полей
public function __construct(
    string $name,
    string $profession,
    int $age,
    string $status,
    string $photo,
    ?string $city = null,
    ?string $phone = null,
    ?string $email = null,
    ?\DateTime $birthDate = null,
    ?string $education = null,
    ?float $desiredSalary = null,
    array $skills = [],
    ?string $about = null,
    array $additionalEducation = [],
    array $educationList = []
) {
    $this->name = $name;
    $this->profession = $profession;
    $this->age = $age;
    $this->status = $status;
    $this->photo = $photo;
    $this->city = $city;
    $this->phone = $phone;
    $this->email = $email;
    $this->birthDate = $birthDate;
    $this->education = $education;
    $this->desiredSalary = $desiredSalary;
    $this->skills = $skills;
    $this->about = $about;
    $this->additionalEducation = $additionalEducation;
    $this->educationList = $educationList;
}

    // Геттеры и сеттеры для всех полей

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): void
    {
        $this->profession = $profession;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(?string $education): void
    {
        $this->education = $education;
    }

    public function getDesiredSalary(): ?float
    {
        return $this->desiredSalary;
    }

    public function setDesiredSalary(?float $desiredSalary): void
    {
        $this->desiredSalary = $desiredSalary;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }

    public function setSkills(array $skills): void
    {
        $this->skills = $skills;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): void
    {
        $this->about = $about;
    }

    public function getAdditionalEducation(): array
    {
        return $this->additionalEducation;
    }

    public function setAdditionalEducation(array $additionalEducation): void
    {
        $this->additionalEducation = $additionalEducation;
    }

    public function getEducationList(): array
    {
        return $this->educationList;
    }

    public function setEducationList(array $educationList): void
    {
        $this->educationList = $educationList;
    }

    // Метод jsonSerialize
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'profession' => $this->profession,
            'age' => $this->age,
            'status' => $this->status,
            'photo' => $this->photo,
            'city' => $this->city,
            'phone' => $this->phone,
            'email' => $this->email,
            'birthDate' => $this->birthDate?->format('Y-m-d'),
            'education' => $this->education,
            'desiredSalary' => $this->desiredSalary,
            'skills' => $this->skills,
            'about' => $this->about,
            'additionalEducation' => $this->additionalEducation,
            'educationList' => $this->educationList,
        ];
    }
}
