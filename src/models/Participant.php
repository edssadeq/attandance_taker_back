<?php


namespace src\models;


class Participant
{
    private  int $id;
    private string $f_name;
    private string $l_name;
    private string $email;

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
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFName(): string
    {
        return $this->f_name;
    }

    /**
     * @param string $f_name
     */
    public function setFName(string $f_name): void
    {
        $this->f_name = $f_name;
    }

    /**
     * @return string
     */
    public function getLName(): string
    {
        return $this->l_name;
    }

    /**
     * @param string $l_name
     */
    public function setLName(string $l_name): void
    {
        $this->l_name = $l_name;
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
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }





}