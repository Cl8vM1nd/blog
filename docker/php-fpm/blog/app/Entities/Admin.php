<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\CanResetPassword;

/**
 * Admin
 *
 * @ORM\Table(name="admin", uniqueConstraints={@ORM\UniqueConstraint(name="admin_email_unique", columns={"email"})})
 * @ORM\Entity
 */
class Admin implements Authenticatable, Authorizable, CanResetPassword
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="remember_token", type="string", length=100, nullable=true)
     */
    private $rememberToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * Admin constructor.
     * @param string $email
     * @param string $password
     * @param string $name
     */
    public function __construct(string $email, string $password, string $name)
    {
        $this->setEmail($email);
        $this->setPassword(\Hash::make($password));
        $this->setName($name);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * @param string $rememberToken
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getId();
    }

    public function getAuthPassword()
    {
        return $this->getPassword();
    }

    public function getRememberTokenName()
    {
        return 'rememberToken';
    }

    public function can($ability, $arguments = [])
    {
        // TODO: Implement can() method.
    }

    public function getEmailForPasswordReset()
    {
        return $this->getEmail();
    }

    public function sendPasswordResetNotification($token)
    {
        // TODO: Implement sendPasswordResetNotification() method.
    }

}

